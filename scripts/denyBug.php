<?php
    REQUIRE_ONCE "../assets/functions.php";
    try {
        $db = db_connect();
        $values = [$_POST['reason'], $_POST['id']];

        $sql = "UPDATE bugreportinfo SET approval = 2, rejectionReason = ? WHERE id = ?";

        $subject = "An Update on Your Recent Bug Report";
        $content = "Your recent bug report has been rejected by the management at " . getProjectInfo(getBugReportInfo($_POST['id'], "associatedProjectID"), "projectName") .
        ". The listed reason for rejection is : " . $_POST['reason'] . ".";
        sendEmail($subject, getBugReportInfo($_POST['id'], "reporterEmail"), "project-buggy@trustifi.com", $content);


        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        $response = "success";
    } catch (Exception $e) {
        $response = $e;
    } finally {
        $db = NULL;
    }
    $return_arr = array("response" => $response);
    echo json_encode($return_arr);
?>
