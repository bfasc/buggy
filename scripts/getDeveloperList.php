<?php
    $id = $_GET['id'];
    if(isset($_GET['selectedList'])) $selectedList = TRUE;
    else $selectedList = FALSE;
    if(isset($_GET['projectEdit'])) $projectEdit = TRUE;
    else $projectEdit = FALSE;


    REQUIRE_ONCE "../assets/functions.php";
    try {
        $db = db_connect();

        if($projectEdit) {
            $associatedProjectID = $_GET['projectEdit'];
        } else {
            if($selectedList)
                $associatedProjectID = getTicketInfo($id, "associatedProjectID");
            else
                $associatedProjectID = getBugReportInfo($id, "associatedProjectID");
        }
        $associatedCompanyID = getProjectInfo($associatedProjectID, "associatedCompany");

        //get list of all possible users in company
        $sql = "SELECT id FROM userinfo
                WHERE associatedCompany = ?";
        $values = [$associatedCompanyID];
        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response = "";

        //loop through each developer in company
        foreach($results as $developer) {
            //if this is for the Project Edit page
            if($projectEdit) {
                $developerID = $developer['id'];
                $assignedProjects = getUserInfo($developerID, "assignedProjects");
                $assignedProjects = explode(",", $assignedProjects);


                $firstName = getUserInfo($developerID, "firstName");
                $lastName = getUserInfo($developerID, "lastName");
                //if developer is assigned to corresponding project, make them selected
                if(array_search($associatedProjectID, $assignedProjects) !== FALSE) {
                    $checked = "checked";
                } else $checked = "";
                //add to list
                $response .= "
                <div class='radio-row'>
                    <label for='developer'>$firstName $lastName</label>
                    <input type='checkbox' id='developer-$developerID' class='developer-list' $checked>
                </div>";
            }
            else {//if this is for the ticket edit/ticket create page
                $developerID = $developer['id'];
                $assignedProjects = getUserInfo($developerID, "assignedProjects");
                $assignedProjects = explode(",", $assignedProjects);

                //if developer is assigned to corresponding project, add them to list
                if(array_search($associatedProjectID, $assignedProjects) !== FALSE) {
                    $firstName = getUserInfo($developerID, "firstName");
                    $lastName = getUserInfo($developerID, "lastName");

                    $checked = "";
                    //if filling checkboxes for edit page
                    if($selectedList) {
                        //grab array of all assigned devlopers for tickets
                        $assignedDevelopers = getTicketInfo($id, "assignedDevelopers");
                        $assignedDevelopers = explode(",", $assignedDevelopers);
                        if(array_search($developerID, $assignedDevelopers) !== FALSE) $checked = "checked";
                        else $checked = "";
                    }

                    //add to list
                    $response .= "
                    <div class='radio-row'>
                        <label for='developer'>$firstName $lastName</label>
                        <input type='checkbox' id='developer-$developerID' class='developer-list' $checked>
                    </div>";
                }
            }

        }
        print($response);

    } catch (Exception $e) {
        print($e);
    } finally {
        $db = NULL;
    }
?>
