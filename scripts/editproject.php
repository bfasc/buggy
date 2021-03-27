<?php
    REQUIRE_ONCE "../assets/functions.php";
    REQUIRE_ONCE "../php-files/editproject.php";
    if(editProject($_POST['name'], $_POST['category'], $_POST['progress'], $_POST['priority'], $_POST['startdate'], $_POST['enddate'], $_POST['projectID'])) {
        $response = "Success!";
    } else $response = "Error editing project.";


    $return_arr = array("response" => $response);
    echo json_encode($return_arr);
?>
