<?php

//Get Heroku ClearDB connection information
// $cleardb_url      = parse_url(getenv("CLEARDB_DATABASE_URL"));
// $cleardb_server   = $cleardb_url["host"];
// $cleardb_username = $cleardb_url["user"];
// $cleardb_password = $cleardb_url["pass"];
// $cleardb_db       = substr($cleardb_url["path"], 1);

$active_group = 'default';
$query_builder = TRUE;

// Connect to DB
//$conn = mysqli_connect($cleardb_server, $cleardb_username, $cleardb_password, $cleardb_db);

$mysqli = new mysqli('us-cdbr-east-03.cleardb.com', 'b27268e1e174f3', 'a5769c7d', 'heroku_ea94c1083a34040');


// $result = $mysqli->query("SELECT * FROM userinfo");
// if ($result->num_rows) {
//     $row = $result->fetch_array();
//     echo print_r($row);
// }
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Buggy | Home</title>
</head>

<body>
    <h1>Home Page</h1>
    <a href="./html/bugReportForm.php">Report a Bug</a>
    <a href="./html/companyForm.php">Create Company</a>
    <a href="./html/projectForm.php">Create Project</a>
    <a href="./html/ticketForm.php">Ticket Info</a>
    <a href="./html/bugReports.php">View Bug Reports</a>
</body>

</html>