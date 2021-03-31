<?php
    REQUIRE_ONCE "../assets/functions.php";
    try {
        $db = db_connect();
        $decision = $_POST['deletebug'];

        if ($decision == "false"){ //I don't know why it's taking the string instead of boolean here. But it works this way.
          $values = [$_POST['reason'], $_POST['id']];

          $sql = "UPDATE bugreportinfo SET approval = 2, rejectionReason = ? WHERE id = ?";

          $subject = "An Update on Your Recent Bug Report";

          $variables = array();
          $variables['name'] = getBugReportInfo($_POST['id'], "firstName") . " " . getBugReportInfo($_POST['id'], "lastName");
          $variables['header_msg'] = "An update on your Bug Report";
          $variables['header_subhead'] = "The bug report that you recently submitted to " . getProjectInfo(getBugReportInfo($_POST['id'], "associatedProjectID"), "projectName") . " was rejected.";
          $variables['topic_sentence'] = "They gave the following reason for rejection: ";
          $variables['topic_subhead'] = $_POST['reason'];
          $variables['description'] = "Thank you for using Buggy's Bug Tracking System!";
          $variables['src_img'] = "http://www.projectbuggy.tk/assets/emailImages/RejectedBug.png";
          $variables['link_title'] = "";
          $variables['link'] = "";

          sendEmail($subject, getBugReportInfo($_POST['id'], "reporterEmail"), $variables);

          $stmt = $db->prepare($sql);
          $stmt->execute($values);
          $response = "success";
        }

        else {
          $values = [$_POST['id']];
          $sql = "DELETE FROM bugreportinfo WHERE id = ?";

          $subject = "An Update on Your Recent Bug Report";

          $variables = array();
          $variables['name'] = getBugReportInfo($_POST['id'], "firstName") . " " . getBugReportInfo($_POST['id'], "lastName");
          $variables['header_msg'] = "An update on your Bug Report";
          $variables['header_subhead'] = "The bug report that you recently submitted to " . getProjectInfo(getBugReportInfo($_POST['id'], "associatedProjectID"), "projectName") . " was deleted.";
          $variables['topic_sentence'] = "They gave the following reason for deletion: ";
          $variables['topic_subhead'] = $_POST['reason'];
          $variables['description'] = "Thank you for using Buggy's Bug Tracking System!";
          $variables['src_img'] = "http://www.projectbuggy.tk/assets/emailImages/RejectedBug.png";
          $variables['link_title'] = "";
          $variables['link'] = "";

          sendEmail($subject, getBugReportInfo($_POST['id'], "reporterEmail"), $variables);

          $stmt = $db->prepare($sql);
          $stmt->execute($values);
          $response = "success";
        }


    } catch (Exception $e) {
        $response = $e;
    } finally {
        $db = NULL;
    }
    $return_arr = array("response" => $response);
    echo json_encode($return_arr);
?>
