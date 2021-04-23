<?php
    session_start();
    $content = $_POST['content'];
    $id = $_POST['idnum'];
    $assigned = $_POST['assigned'];
    $discussion = $_POST['discussion'];
    $completed = $_POST['completed'];
    $inProgress = $_POST['inProgress'];
    $projectList = json_decode($_POST['projectList']);
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $priority = $_POST['priority'];
    REQUIRE_ONCE "../assets/functions.php";
    try {
        $db = db_connect();

        // get list of projects available to user
        $assignedProjects = getUserInfo($_SESSION['userID'], "assignedProjects");
        $assignedProjects = explode(",", $assignedProjects);

        $availableProjects = $assignedProjects;

        //if manager, able to see all projects associated with company
        if(getUserInfo($_SESSION['userID'], "accountType") == "management") {
            $companyProjects = getAllProjects($_SESSION['userID']);
            foreach($companyProjects as $projectID) {
                array_push($availableProjects, $projectID);
            }
            $availableProjects = array_unique($availableProjects);
        }

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
        if($id) {
            if($whereCount > 0) $where .= " AND ";
            $where .= "id = ?";
            array_push($values, $id);
            $whereCount++;
        }
        if($priority != 0) {
            if($whereCount > 0) $where .= " AND ";
            $where .= "priority = ?";
            array_push($values, $priority);
            $whereCount++;
        }
        //TODO discussion sql
        if($completed) {
            if($whereCount > 0) $where .= " AND ";
            $where .= "status = 'Completed'";
            $whereCount++;
        }
        if($inProgress) {
            if($whereCount > 0 && $completed)
                $where .= " OR ";
            else if($whereCount > 0)
                $where .= " AND ";
            $where .= "(status = 'In Progress' OR status = 'Review' OR status = 'Needs Revisions')";
            $whereCount++;
        }
        if($startDate) {
            if($whereCount > 0) $where .= " AND ";
            $where .= "approvalDate >= ?";
            array_push($values, $startDate . " 00:00:00");
            $whereCount++;
        }
        if($endDate) {
            if($whereCount > 0) $where .= " AND ";
            $where .= "approvalDate <= ?";
            array_push($values, $endDate . " 00:00:00");
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
        else {
            //search all available projects
            $projectString = "";
            if($whereCount > 0) $where .= " AND ";
            $where .= "(";
            foreach($availableProjects as $key => $projectID) {
                $where .= "associatedProjectID = $projectID";
                if($key != count($availableProjects)-1)
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

        if(!$results)
            $response .= "<h2 class='subhead'>No results found. Try changing your filters.</h2 class='subhead'>";
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

            $developerString = "";
            $assignedDevelopers = explode(",", $assignedDevelopers);
            foreach($assignedDevelopers as $developer) {
                $firstName = getUserInfo($developer, "firstName");
                $lastName = getUserInfo($developer, "lastName");
                $developerString .= "$firstName $lastName <br>";
            }

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
                <p class='info'><a class='label'>Assignees: </a><a>$developerString</a></p>
                <p class='info'><a class='label'>Progress: </a><a>$status</a></p>
                <div class='button-wrap'><a href='ticket?$id' class='button'>View Ticket Page</a>
                ";

            if(getUserInfo($_SESSION['userID'], "accountType") == "management")
                $response .= "<a class='button edit cd-popup-trigger' id='$id' class='button'>Edit</a>";
            $response .= "</div></div>";
        }
    } catch (Exception $e) {
        $response = $e;
    } finally {
        $db = NULL;
    }
    $return_arr = array("htmlResponse" => $response);
    echo json_encode($return_arr);
?>
