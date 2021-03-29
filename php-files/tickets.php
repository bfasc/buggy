<?php
/* Function Name: fetchTickets
 * Description: print list of all tickets available to user
 * Parameters: userID (session user ID)
 * Return Value: none (void)
 */
function fetchTickets($userID, $progressShort) {
    try {
        $db = db_connect();
        //update progress var for correct sql syntax
        if($progressShort == "In Progress") $progress = "'In Progress' OR status = 'Review' OR status = 'Needs Revisions'";
        else $progress = "'Not Started'";
        // get list of projects available to user
        $assignedProjects = getUserInfo($userID, "assignedProjects");
        if($assignedProjects) {
            $assignedProjects = explode(",", $assignedProjects);
            $availableProjects = $assignedProjects;
        } else $availableProjects = [];

        //if manager, user can see all tickets under company
        if(getUserInfo($userID, "accountType") == "management") {
            $companyProjects = getAllProjects($userID);
            foreach($companyProjects as $projectID) {
                array_push($availableProjects, $projectID);
            }
            //remove any duplicates
            $availableProjects = array_unique($availableProjects);
        }

        //set where statement to show all viewable projects
        $where = "";

        foreach($availableProjects as $key => $projectID) {
            if($projectID) {
                $where .= "associatedProjectID = $projectID";
                if($key != count($availableProjects)-1)
                    $where .= " OR ";
            }
        }

        $sql = "SELECT * FROM ticketinfo WHERE (status = $progress)";
        if($availableProjects) $sql .= " AND ($where)";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        //create array of all tickets assigned to you
        $yourTickets = [];
        foreach($results as $allTicket) {
            if(getUserInfo($userID, "accountType") == "management") {
                array_push($yourTickets, $allTicket);
            } else {
                $assignedDevelopers = $allTicket['assignedDevelopers'];
                $assignedDevelopers = explode(",", $assignedDevelopers);
                if(array_search($userID, $assignedDevelopers) !== FALSE) array_push($yourTickets, $allTicket);
            }

        }

        $response = "";

        if(!$results)
            $response .= "<h2>You currently have no " . strtolower($progressShort) . " assigned tickets.</h2>";
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
                <p class='info'><a class='label'>Progress: </a><a>$status</a>
                ";
            if(getUserInfo($userID, "accountType") == "developer") {
                $response .= "<select id='progress'>
                <option selected disabled>Change Ticket Progress</option>
                <option id='notStarted'>Not Yet Started</option>
                <option id='inProgress'>In Progress</option>
                <option id='review'>Review</option>
                <option id='needsRevisions'>Needs Revisions</option>
                </select><a class='button progressChange'id='$id'>Change Progress</a>";
            }
            $response .= "</p><div class='button-wrap'><a href='ticket?$id' class='button'>View Ticket Page</a>";
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
