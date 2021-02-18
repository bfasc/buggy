<?php
$db = new PDO("mysql:host=us-cdbr-east-03.cleardb.com;dbname=b27268e1e174f3", "a5769c7d", "heroku_ea94c1083a34040");
$db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);


// emailExists - check if email is in database
//    Inputs - form email
//    Outputs - boolean T/F
$values = [$_POST['email']];

$sql = "SELECT * FROM userinfo WHERE email = ?";
$stmt = $db->prepare($sql);
$stmt->execute($values);
$result = $stmt->fetchColumn();

// createUser as developer - create row in user info table
//    Inputs -  form email, form firstname, form lastname, form password, getCompanyID(form company code), assigned projects (determined by signup type), account type (determined by signup type), verification code (randomly generated)
//    Outputs - boolean T/F depending on success
$hash = md5( rand(0,1000) ); //verification code

$values = [
    $_POST['email'],
    $_POST['firstName'],
    $_POST['lastName'],
    $_POST['password'],
    getCompanyID($_POST['companyCode']),
    NULL,
    "developer",
    $hash
];
$sql = "INSERT INTO userinfo (email, firstName, lastName, password, associatedCompany, assignedProjects, accountType, verificationCode) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
$stmt = $db->prepare($sql);
$stmt->execute($values);



$db = null;
?>
