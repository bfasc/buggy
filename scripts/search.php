<?php
    session_start();
    $content = $_POST['content'];
    $assigned = $_POST['assigned'];
    $discussion = $_POST['discussion'];
    $completed = $_POST['completed'];
    $inProgress = $_POST['inProgress'];
    $projectList = json_decode($_POST['projectList']);
    // $content = "fix";
    // $assigned = FALSE;
    // $discussion = FALSE;
    // $completed = FALSE;
    // $inProgress = FALSE;
    // $projectList = [];

    REQUIRE_ONCE "../assets/functions.php";
    try {
        $db = db_connect();

        //update bugreports table with approval
        $values = [];

        $sql = "SELECT * FROM ticketinfo";

        $whereCount = 0;
        $where = "";
        if($content) {
            $where .= "(name LIKE ? OR description LIKE ?)";
            array_push($values, "%" . $content . "%");
            array_push($values, "%" . $content . "%");
            $whereCount++;
        }
        if($assigned) {
            if($whereCount > 0) $where .= " AND ";
            $where .= "assignedDevelopers LIKE ?";
            array_push($values, "%" . $_SESSION['userID'] . "%");
            $whereCount++;
        }
        //TODO discussion sql
        if($completed) {
            if($whereCount > 0) $where .= " AND ";
            $where .= "status = 'Completed'";
            $whereCount++;
        }
        if($inProgress) {
            if($whereCount > 0) $where .= " AND ";
            $where .= "status = 'In Progress'";
            $whereCount++;
        }
        if($projectList) {
            if($whereCount > 0) $where .= " AND ";
            $where .= "(";
            foreach($projectList as $key => $id) {
                $where .= "associatedProjectID = $id";
                if($key != count($projectList)-1)
                    $where .= " OR ";
                else
                    $where .= ")";
            }
        }

        if($where) $sql .= " WHERE $where";
        $stmt = $db->prepare($sql);

        if($values) $stmt->execute($values);
        else $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response = "<h1>Search Results</h1>";
        foreach($results as $ticket) {
            $id = $ticket['id'];
            $title = $ticket['name'];
            $description = $ticket['description'];
            $priority = $ticket['priority'];
            $status = $ticket['status'];
            $associatedBugID = $ticket['associatedBugID'];
            $associatedProjectID = $ticket['associatedProjectID'];
            $lastEditedDate = $ticket['lastEditedDate'];
            $approvalDate = $ticket['approvalDate'];
            $assignedDevelopers = $ticket['assignedDevelopers'];

            //priority string
            $priorityString = "";
            for($i = 0; $i < 5; $i++){
                $priorityString .= "<i class='fas fa-exclamation fa-fw";
                if($i < $priority) {
                    $priorityString .= " highlight";
                }
                $priorityString .= "'></i>";
            }

            $response .= "
            <div class='ticket'>
                <p class='name'>#$id : $title</p>
                <p class='info'><a class='label'>Priority : </a><a>$priorityString</a></p>
                <p class='info'><a class='label'>Assignees: </a><a>$assignedDevelopers</a></p>
                <p class='info'><a class='label'>Progress: </a><a>$status</a></p>
                <a href='ticket?$id' class='button'>View Ticket Page</a>
            </div>";
        }
    } catch (Exception $e) {
        $response = $e;
    } finally {
        $db = NULL;
    }
    $return_arr = array("htmlResponse" => $response);
    echo json_encode($return_arr);
?>
