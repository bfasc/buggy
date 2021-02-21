<?php

$mysqli = new mysqli('us-cdbr-east-03.cleardb.com', 'b27268e1e174f3', 'a5769c7d', 'heroku_ea94c1083a34040');

$update = false;
$approved = '';
$lastEditedDate = '';
$approval = '';
$assignedDevelopers = '';
$rejectionReason = '';

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM bugreportinfo WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo '<script>alert("Record has Been Deleted")</script>';
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $query = "SELECT * FROM bugreportinfo WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows) {
        $row = $result->fetch_array();
        $firstName = $row['firstName'];
        $lastName = $row['lastName'];
        $reporterEmail = $row['reporterEmail'];
        $bugDescription = $row['bugDescription'];
    }
}

if (isset($_POST['update'])) {
    //$id = $_POST['id'];
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $reporterEmail = $_POST['reporterEmail'];
    $bugDescription = $_POST['bugDescription'];

    $query = "UPDATE bugreportinfo SET firstName=?, lastName=?, reporterEmail=?, bugDescription=? WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssssi', $firstName, $lastName, $reporterEmail, $bugDescription, $id);
    $stmt->execute();
    echo '<script>alert("Record has Been Updated")</script>';

    $stmt->close();

    header("location: ../html/bugReports.php");
}

if (isset($_GET['approve'])) {
    $id = $_GET['approve'];
    $approved = 'true';
    if (isset($_POST['submit'])) {
        $query = "SELECT id, associatedProjectID FROM bugreportinfo WHERE id = ?";
        $state = $mysqli->prepare($query);
        $state->bind_param('i', $id);
        $state->execute();
        $result = $state->get_result();
        $value = $result->fetch_object();

        // Setting values
        $currentDate = date('Y-m-d');
        $ticketTitle = $_POST['ticketTitle'];
        $lastEditedDate = $_POST['lastEditedDate'];
        $assignedDevelopers = $_POST['assignedDevelopers'];
        $ticketStatus = $_POST['ticketStatus'];
        $approval = 1;
        $associatedBugID = $value->id;
        $associatedProjectID = $value->associatedProjectID;

        $stmt = $mysqli->prepare("UPDATE bugreportinfo SET approval=? WHERE id = ?");
        $stmt->bind_param("si", $approval, $associatedBugID);

        // Prepared statement
        $stmt = $mysqli->prepare("INSERT INTO ticketinfo (name, status, associatedBugID, associatedProjectID, approvalDate, lastEditedDate, assignedDevelopers) VALUES (?, ?, ?, ?, ?, ?, ?)");
        // Binding of those values to be entered
        $stmt->bind_param("ssiisss", $ticketTitle, $ticketStatus, $associatedBugID, $associatedProjectID, $currentDate, $lastEditedDate, $assignedDevelopers);

        // Executing the SQL statement
        if (!$stmt->execute()) {
            header("location: ../html/error.php");
        } else {
            header("location: ../html/success.php");
        }

        $stmt->close();
    }
}

if (isset($_GET['reject'])) {
    $id = $_GET['reject'];
    $approved = 'false';
    if (isset($_POST['submit'])) {

        // Setting values
        $rejectionReason = $_POST['rejectionReason'];
        $approval = 2;

        // Prepared statement
        $stmt = $mysqli->prepare("UPDATE bugreportinfo SET approval=?, rejectionReason=? WHERE id = ?");
        // Binding of those values to be entered
        $stmt->bind_param("ssi", $approval, $rejectionReason, $id);

        // Executing the SQL statement
        if (!$stmt->execute()) {
            header("location: ../html/error.php");
        } else {
            header("location: ../html/success.php");
        }

        $stmt->close();
    }
}
