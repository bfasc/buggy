<?php
    $id = $_GET['id'];
    if(isset($_GET['selectedList'])) $selectedList = TRUE;
    else $selectedList = FALSE;

    REQUIRE_ONCE "../assets/functions.php";
    try {
        $db = db_connect();

        if($selectedList)
            $associatedProjectID = getTicketInfo($id, "associatedProjectID");
        else
            $associatedProjectID = getBugReportInfo($id, "associatedProjectID");
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
        print($response);

    } catch (Exception $e) {
        print($e);
    } finally {
        $db = NULL;
    }
?>
