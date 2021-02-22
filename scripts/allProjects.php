<?php
    session_start();
    $userID = $_POST['userID'];

    REQUIRE_ONCE "../assets/functions.php";
    try {
        $assignedProjects = getUserInfo($userID, "assignedProjects");
        $assignedProjects = explode(",", $assignedProjects);

        $response = "";
        foreach($assignedProjects as $projectID) {
            $projectName = getProjectInfo($projectID, "projectName");
            $response .= "
            <div class='radio-row'>
                <label for='assigned'>$projectName</label>
                <input type='checkbox' id='$projectID' name='project-$projectID' class='project-list'>
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
