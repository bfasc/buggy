<?php
    $bugID = $_GET['id'];

    REQUIRE_ONCE "../assets/functions.php";
    try {
        $db = db_connect();

        $associatedProjectID = getBugReportInfo($bugID, "associatedProjectID");
        $associatedCompanyID = getProjectInfo($associatedProjectID, "associatedCompany");


        //get list of all possible users in company
        $sql = "SELECT id FROM userinfo
                WHERE associatedCompany = ?";
        $values = [$associatedCompanyID];
        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

        $response = "";

        //loop through each developer
        foreach($results as $developer) {
            $developerID = $developer['id'];
            $assignedProjects = getUserInfo($developerID, "assignedProjects");
            $assignedProjects = explode(",", $assignedProjects);
            //loop through this developer's assigned projects
            foreach($assignedProjects as $projectID) {
                if($projectID == $associatedProjectID) {
                    $firstName = getUserInfo($developerID, "firstName");
                    $lastName = getUserInfo($developerID, "lastName");
                    $response .= "
                    <div class='radio-row'>
                        <label for='developer'>$firstName $lastName</label>
                        <input type='checkbox' id='developer-$developerID' class='developer-list'>
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
