<?php
    REQUIRE_ONCE "../assets/functions.php";
    REQUIRE_ONCE "../php-files/createproject.php";
    if(createProject($_POST['name'], $_POST['category'], $_POST['progress'], $_POST['priority'], $_POST['startdate'], $_POST['enddate'], $_POST['companyID'])) {
        $response = "Success!";
    } else $response = "Error creating a new project.";


    $return_arr = array("response" => $response);
    echo json_encode($return_arr);
?>
