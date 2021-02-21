<?php

$mysqli = new mysqli('us-cdbr-east-03.cleardb.com', 'b27268e1e174f3', 'a5769c7d', 'heroku_ea94c1083a34040');

$update = false;
$approved = '';
$lastEditedDate = '';
$approval = '';
$assignedDevelopers = '';
$rejectionReason = '';
$name = '';

// if (isset($_POST['submit'])) {
//     // Prepared statement
//     $stmt = $mysqli->prepare("INSERT INTO ticketinfo (lastEditedDate, approval, assignedDevelopers) VALUES (?, ?, ?)");
//     // Binding of those values to be entered
//     $stmt->bind_param("sss", $lastEditedDate, $approval, $assignedDevelopers);

//     // Setting values
//     $lastEditedDate = $_POST['lastEditedDate'];
//     $approval = $_POST['approval'];
//     $assignedDevelopers = $_POST['assignedDevelopers'];

//     // Executing the SQL statement
//     if (!$stmt->execute()) {
//         header("location: ../html/error.php");
//     } else {
//         header("location: ../html/success.php");
//     }

//     $stmt->close();
// }

// new code dumb to commit changes with no idex.php this is fun

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM ticketinfo WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo '<script>alert("Record has Been Deleted")</script>';
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $query = "SELECT * FROM ticketinfo WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows) {
        $row = $result->fetch_array();
        $name = $row['name'];
        $lastEditedDate = $row['lastEditedDate'];
        $assignedDevelopers = $row['assignedDevelopers'];
    }
}

if (isset($_POST['update'])) {

    $name = $_POST['name'];
    $ticketStatus = $_POST['ticketStatus'];
    $lastEditedDate = $_POST['lastEditedDate'];
    $assignedDevelopers = $_POST['assignedDevelopers'];

    $query = "UPDATE ticketinfo SET name=?, status=?, lastEditedDate=?, assignedDevelopers=? WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssssi', $name, $ticketStatus, $lastEditedDate, $assignedDevelopers, $id);
    $stmt->execute();
    echo '<script>alert("Record has Been Updated")</script>';

    $stmt->close();

    header("location: ../html/ticketForm.php");
}

// if (isset($_GET['approve'])) {
//     $id = $_GET['approve'];
//     $approved = 'true';
//     if (isset($_POST['submit'])) {
//         submission($id, $mysqli, $lastEditedDate, $assignedDevelopers, 1);
//     }
// }

// if (isset($_GET['reject'])) {
//     $id = $_GET['reject'];
//     $approved = 'false';
//     if (isset($_POST['submit'])) {

//         $query = "SELECT id, associatedProjectID FROM bugreportinfo WHERE id = ?";
//         $state = $mysqli->prepare($query);
//         $state->bind_param('i', $id);
//         $state->execute();
//         $result = $state->get_result();
//         $value = $result->fetch_object();

//         // Setting values
//         $rejectionReason = $_POST['rejectionReason'];
//         $approval = 0;
//         $associatedBugID = $value->id;
//         $associatedProjectID = $value->associatedProjectID;

//         // Prepared statement
//         $stmt = $mysqli->prepare("INSERT INTO ticketinfo (associatedBugID, associatedProjectID, approval, rejectionReason) VALUES (?, ?, ?, ?)");
//         // Binding of those values to be entered
//         $stmt->bind_param("iiss", $associatedBugID, $associatedProjectID, $approval, $rejectionReason);

//         // Executing the SQL statement
//         if (!$stmt->execute()) {
//             header("location: ../html/error.php");
//         } else {
//             header("location: ../html/success.php");
//         }

//         $stmt->close();
//     }
// }

// function submission($id, $mysqli, $lastEditedDate, $assignedDevelopers, $approval)
// {
//     $query = "SELECT id, associatedProjectID FROM bugreportinfo WHERE id = ?";
//     $state = $mysqli->prepare($query);
//     $state->bind_param('i', $id);
//     $state->execute();
//     $result = $state->get_result();
//     $value = $result->fetch_object();

//     // Setting values
//     $lastEditedDate = $_POST['lastEditedDate'];
//     $assignedDevelopers = $_POST['assignedDevelopers'];
//     $associatedBugID = $value->id;
//     $associatedProjectID = $value->associatedProjectID;

//     // Prepared statement
//     $stmt = $mysqli->prepare("INSERT INTO ticketinfo (associatedBugID, associatedProjectID, lastEditedDate, approval, assignedDevelopers) VALUES (?, ?, ?, ?, ?)");
//     // Binding of those values to be entered
//     $stmt->bind_param("iisss", $associatedBugID, $associatedProjectID, $lastEditedDate, $approval, $assignedDevelopers);

//     // Executing the SQL statement
//     if (!$stmt->execute()) {
//         header("location: ../html/error.php");
//     } else {
//         header("location: ../html/success.php");
//     }

//     $stmt->close();
// }
