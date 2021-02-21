<?php
    REQUIRE_ONCE "../assets/functions.php";
    try {
        $db = db_connect();

        //update bugreports table with approval
        $values = [$_POST['id']];

        $sql = "UPDATE bugreportinfo SET approval = 1 WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute($values);

        //create bug report ticket
        $date = date('Y-m-d H:i:s');
        $values = [
            $_POST['name'],
            $_POST['description'],
            $_POST['priority'],
            "Not Started",
            $_POST['id'],
            getBugReportInfo($_POST['id'], "associatedProjectID"),
            $_POST['developers'],
            $date,
            $date
        ];
        $sql = "INSERT INTO
        ticketinfo (name, description, priority, status, associatedBugID, associatedProjectID, assignedDevelopers, lastEditedDate, approvalDate)
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?)";
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
