<?php

$mysqli = new mysqli('us-cdbr-east-03.cleardb.com', 'b27268e1e174f3', 'a5769c7d', 'heroku_ea94c1083a34040');

if (isset($_POST['submit'])) {

    $search = $_POST['search'];
    //$completed = $_POST['completed'];
    //$progress = $_POST['progress'];
    // $approved = $_POST['approved'];
    // $rejected = $_POST['rejected'];
    $filter = $_POST['filter'];

    foreach ($_POST['filter'] as $filter) {
        $array[] = mysqli_real_escape_string($mysqli, $filter);
    }
    $values = implode("','", $array);

    $stmt = "SELECT * FROM ticketinfo WHERE approval IN ('$values')";
    $result = mysqli_query($mysqli, $stmt);

    while ($row = mysqli_fetch_assoc($result)) {
        echo "<table>";
        echo "<tr>";
        echo "<td>" . $row['lastEditedDate'] . "</td>";
        echo "<td>" . $row['approval'] . "</td>";
        echo "<td>" . $row['assignedDevelopers'] . "</td>";
        echo "<td>" . $row['rejectionReason'] . "</td>";
        echo "</tr>";
        echo "</table>";
    }
}
