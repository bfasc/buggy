<?php
    REQUIRE_ONCE "../assets/functions.php";
    REQUIRE_ONCE "../php-files/editproject.php";
    REQUIRE_ONCE "../php-files/uploadFile.php";
    $response = "";
    $fileToUpload = "default.png";
    if(!$_POST['name'] || !$_POST['category']|| !$_POST['progress'] || $_POST['priority'] == 0 || !$_POST['link'])
        $response = "You must fill out all of the form fields.";
    else {
        if(preg_match("/^[A-Za-z0-9_-]*$/",$_POST['link'])){
            if(getProjectInfo($_POST['projectID'], "customLink") != $_POST['link']){
                if(!checkUniqueLink($_POST['link'])) $response = "This custom link is already taken.";
            }
            else {
                //if user submitted file, attempt to upload it
                if($_POST['filetmp_name'] && $_POST['filename'] && $_POST['filesize']) {
                    $fileInfo = uploadFile($_POST['filetmp_name'], $_POST['filename'], $_POST['filesize']);
                    if($fileInfo[0] != "")
                        $response = $_fileInfo[0];
                    else
                        $fileToUpload = $fileInfo[1];
                }
                if(!editProject($_POST['name'], $_POST['category'], $_POST['progress'], $_POST['priority'], $_POST['startdate'], $_POST['enddate'], $_POST['projectID'], $_POST['link'], $fileToUpload))
                    $response = "Error editing project.";
            }
        } else $response = "Your custom link must only contain alphanumeric numbers, along with the characters _ and -";
    }

    $return_arr = array("response" => $response);
    echo json_encode($return_arr);
?>
