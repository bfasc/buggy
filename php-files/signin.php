<?php
$db = new PDO("mysql:host=us-cdbr-east-03.cleardb.com;dbname=b27268e1e174f3", "a5769c7d", "heroku_ea94c1083a34040");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// checkVerified - check if user’s email is verified
//     Inputs - form email
//     Outputs - boolean T/F
$values = [$_POST['email']];

$sql = "SELECT * FROM userinfo WHERE verified = 1 AND email = ?";
$stmt = $db->prepare($sql);
$stmt->execute($values);
$result = $stmt->fetchColumn();

// emailExists - check if email is in database
//     Inputs - form email
//     Outputs - boolean T/F
$values = [$_POST['email']];

$sql = "SELECT * FROM userinfo WHERE email = ?";
$stmt = $db->prepare($sql);
$stmt->execute($values);
$result = $stmt->fetchColumn();

// checkLogin - check if user’s email and pw matches
//     Inputs - form email
//     Outputs - boolean T/F
$values = [$_POST['email'], $_POST['password']];

$sql = "SELECT * FROM userinfo WHERE email = ? AND password = ?";
$stmt = $db->prepare($sql);
$stmt->execute($values);
$result = $stmt->fetchColumn();


// signIn - start session with userID from db
//     Inputs - form email, form pw
//     Outputs - none (void)
$values = [$_POST['email']];

$sql = "SELECT userid FROM userinfo WHERE email = ?";
$stmt = $db->prepare($sql);
$stmt->execute($values);
$result = $stmt->fetchColumn();

$_SESSION['userID'] = $result;


$db = NULL;
?>
