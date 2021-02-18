<?php

$mysqli = new mysqli('us-cdbr-east-03.cleardb.com', 'b27268e1e174f3', 'a5769c7d', 'heroku_ea94c1083a34040');

$update = false;
$projectName = '';
$projectCategory = '';
$startDate = '';
$projectIcon = '';

if (isset($_POST['submit']) && isset($_POST['status']) && isset($_POST['priority'])) {
    // Prepared statement
    $stmt = $mysqli->prepare("INSERT INTO projectinfo (projectName, projectCategory, startDate, status, priority, projectIcon) VALUES (?, ?, ?, ?, ?, ?)");
    // Binding of those values to be entered
    $stmt->bind_param("ssssss", $projectName, $projectCategory, $startDate, $status, $priority, $projectIcon);

    // Setting values
    $projectName = $_POST['projectName'];
    $projectCategory = $_POST['projectCategory'];
    $startDate = $_POST['startDate'];
    $status = $_POST['status'];
    $priority = $_POST['priority'];
    $projectIcon = $_POST['projectIcon'];

    // Executing the SQL statement
    if (!$stmt->execute()) {
        header("location: ../html/error.php");
    } else {
        header("location: ../html/success.php");
    }

    $stmt->close();
}

if (isset($_GET['delete'])) {
    $id = $_GET['delete'];
    $query = "DELETE FROM projectinfo WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo '<script>alert("Record has Been Deleted")</script>';
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $query = "SELECT * FROM projectinfo WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows) {
        $row = $result->fetch_array();
        $projectName = $row['projectName'];
        $projectCategory = $row['projectCategory'];
        $startDate = $row['startDate'];
        $status = $row['status'];
        $priority = $row['priority'];
        $projectIcon = $row['projectIcon'];
    }
}

if (isset($_POST['update'])) {

    $projectName = $_POST['projectName'];
    $projectCategory = $_POST['projectCategory'];
    $startDate = $_POST['startDate'];
    $status = $_POST['status'];
    $priority = $_POST['priority'];
    $projectIcon = $_POST['projectIcon'];

    $query = "UPDATE projectinfo SET projectName=?, projectCategory=?, startDate=?, status=?, priority=?, projectIcon=? WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('ssssssi', $projectName, $projectCategory, $startDate, $status, $priority, $projectIcon, $id);
    $stmt->execute();
    echo '<script>alert("Record has Been Updated")</script>';

    $stmt->close();

    header("location: ../html/projectForm.php");
}
