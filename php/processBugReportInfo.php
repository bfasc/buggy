<?php

// Connection to database
$mysqli = new mysqli('us-cdbr-east-03.cleardb.com', 'b27268e1e174f3', 'a5769c7d', 'heroku_ea94c1083a34040');

// Initializing variables to be set to nothing
// manily used to help in the case of updating a record that once page reloads fields are blank
// ready for either the next update or new record to be entered.
$update = false;
$firstName = '';
$lastName = '';
$reporterEmail = '';
$bugDescription = '';

if (isset($_POST['submit'])) {
    $projectName = $_POST['projectName'];
    $query = "SELECT id FROM projectinfo WHERE projectName = ?";
    $state = $mysqli->prepare($query);
    $state->bind_param('s', $projectName);
    $state->execute();
    $result = $state->get_result();
    $value = $result->fetch_object();

    // Setting values
    $firstName = $_POST['firstName'];
    $lastName = $_POST['lastName'];
    $reporterEmail = $_POST['reporterEmail'];
    $bugDescription = $_POST['bugDescription'];
    $associatedprojectID = $value->id;

    // Prepared statement
    $stmt = $mysqli->prepare("INSERT INTO bugreportinfo (associatedProjectID, firstName, lastName, reporterEmail, bugDescription) VALUES (?, ?, ?, ?, ?)");
    // Binding of those values to be entered
    $stmt->bind_param("issss", $associatedprojectID, $firstName, $lastName, $reporterEmail, $bugDescription);

    // Executing the SQL statement
    if (!$stmt->execute()) {
        header("location: ../html/error.php");
    } else {
        $stmt->close();
        header("location: ../html/success.php");
    }

    //header("location: ../index.php");
}

// if (isset($_GET['delete'])) {
//     $id = $_GET['delete'];
//     $query = "DELETE FROM bugreportinfo WHERE id = ?";
//     $stmt = $mysqli->prepare($query);
//     $stmt->bind_param('i', $id);
//     $stmt->execute();
//     $stmt->close();
//     echo '<script>alert("Record has Been Deleted")</script>';
// }

// if (isset($_GET['edit'])) {
//     $id = $_GET['edit'];
//     $update = true;
//     $query = "SELECT * FROM bugreportinfo WHERE id = ?";
//     $stmt = $mysqli->prepare($query);
//     $stmt->bind_param('i', $id);
//     $stmt->execute();
//     $result = $stmt->get_result();
//     if ($result->num_rows) {
//         $row = $result->fetch_array();
//         $firstName = $row['firstName'];
//         $lastName = $row['lastName'];
//         $reporterEmail = $row['reporterEmail'];
//         $bugDescription = $row['bugDescription'];
//     }
// }

// if (isset($_POST['update'])) {
//     //$id = $_POST['id'];
//     $firstName = $_POST['firstName'];
//     $lastName = $_POST['lastName'];
//     $reporterEmail = $_POST['reporterEmail'];
//     $bugDescription = $_POST['bugDescription'];

//     $query = "UPDATE bugreportinfo SET firstName=?, lastName=?, reporterEmail=?, bugDescription=? WHERE id=?";
//     $stmt = $mysqli->prepare($query);
//     $stmt->bind_param('ssssi', $firstName, $lastName, $reporterEmail, $bugDescription, $id);
//     $stmt->execute();
//     echo '<script>alert("Record has Been Updated")</script>';

//     $stmt->close();

//     header("location: ../html/bugReportForm.php");
// }
