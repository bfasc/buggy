<?php

$mysqli = new mysqli('us-cdbr-east-03.cleardb.com', 'b27268e1e174f3', 'a5769c7d', 'heroku_ea94c1083a34040');

$update = false;
$companyName = '';
$streetAddress = '';
$city = '';
$state = '';
$zip = '';
$country = '';
$phoneNumber = '';

if (isset($_POST['submit'])) {
    // Prepared statement
    $stmt = $mysqli->prepare("INSERT INTO companyinfo (companyCode, companyName, streetAddress, city, state, zip, country, phoneNumber) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
    // Binding of those values to be entered
    $stmt->bind_param("sssssssi", $companyCode, $companyName, $streetAddress, $city, $state, $zip, $country, $phoneNumber);

    // Setting values
    $companyCode = generateRandomCode();
    $companyName = $_POST['companyName'];
    $streetAddress = $_POST['streetAddress'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];
    $phoneNumber = $_POST['phoneNumber'];

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
    $query = "DELETE FROM companyinfo WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $stmt->close();
    echo '<script>alert("Record has Been Deleted")</script>';
}

if (isset($_GET['edit'])) {
    $id = $_GET['edit'];
    $update = true;
    $query = "SELECT * FROM companyinfo WHERE id = ?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('i', $id);
    $stmt->execute();
    $result = $stmt->get_result();
    if ($result->num_rows) {
        $row = $result->fetch_array();
        $companyName = $row['companyName'];
        $streetAddress = $row['streetAddress'];
        $city = $row['city'];
        $state = $row['state'];
        $zip = $row['zip'];
        $country = $row['country'];
        $phoneNumber = $row['phoneNumber'];
    }
}

if (isset($_POST['update'])) {
    //$id = $_POST['id'];
    $companyName = $_POST['companyName'];
    $streetAddress = $_POST['streetAddress'];
    $city = $_POST['city'];
    $state = $_POST['state'];
    $zip = $_POST['zip'];
    $country = $_POST['country'];
    $phoneNumber = $_POST['phoneNumber'];

    $query = "UPDATE companyinfo SET companyName=?, streetAddress=?, city=?, state=?, zip=?, country=?, phoneNumber=? WHERE id=?";
    $stmt = $mysqli->prepare($query);
    $stmt->bind_param('sssssssi', $companyName, $streetAddress, $city, $state, $zip, $country, $phoneNumber, $id);
    $stmt->execute();
    echo '<script>alert("Record has Been Updated")</script>';

    $stmt->close();

    header("location: ../html/companyForm.php");
}

function generateRandomCode()
{
    $numbers = range(0, 9);
    shuffle($numbers);
    for ($i = 0; $i < 10; $i++) {
        global $digits; // global meaning that a variable that is defined being global is able to be used inside of a local function
        $digits .= $numbers[$i]; // concatentation assingment meaning each random number is added onto the previous making one big number in the end
    }
    echo $digits;
    return $digits;
}
