<?php
/* Function Name: fetchTickets
 * Description: print list of all tickets available to user
 * Parameters: userID (session user ID)
 * Return Value: none (void)
 */
function fetchTickets($userID, $progress) {
    try {
        $db = db_connect();
        //update progress var for correct sql syntax
        if($progress == "In Progress") $progress = "'In Progress' OR status = 'Needs Review' OR status = 'Needs Revisions'";
        else $progress = "'Not Started'";
        // get list of projects available to user
        $assignedProjects = getUserInfo($userID, "assignedProjects");
        $assignedProjects = explode(",", $assignedProjects);

        $availableProjects = $assignedProjects;

        //if manager, able to see all projects associated with company
        if(getUserInfo($userID, "accountType") == "management") {
            $companyProjects = getAllProjects($userID);
            foreach($companyProjects as $project) {
                $projectID = $project['id'];
                array_push($availableProjects, $projectID);
            }
            //remove any duplicates
            $availableProjects = array_unique($availableProjects);
        }

        //get array of all viewable projects
        $where = "";
        foreach($availableProjects as $key => $projectID) {
            $where .= "associatedProjectID = $projectID";
            if($key != count($availableProjects)-1)
                $where .= " OR ";
        }

        $sql = "SELECT * FROM ticketinfo WHERE status = $progress AND $where";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //create array of all tickets assigned to you
        $yourTickets = [];
        foreach($results as $allTicket) {
            $assignedDevelopers = $allTicket['assignedDevelopers'];
            $assignedDevelopers = explode(",", $assignedDevelopers);
            if(array_search($userID, $assignedDevelopers) !== FALSE) array_push($yourTickets, $allTicket);
        }

        $response = "";

        if(!$results)
            $response .= "<h2>You currently have no assigned tickets.</h2>";
        foreach($yourTickets as $ticket) {
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

            if(getUserInfo($userID, "accountType") == "management") {
                $response .= "<a class='button edit cd-popup-trigger' id='$id' class='button'>Edit</a>";
                $response .= "<a class='button delete cd-popup-trigger' id='$id' class='button'>Delete</a>";
            }

            $response .= "</div></div>";
        }
        print $response;


    } catch (Exception $e) {
        print ("Error in fetching bugs. $e");
    } finally {
        $db = NULL;
    }
}

?>
