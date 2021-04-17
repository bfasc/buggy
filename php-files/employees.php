<?php
function getEmployees(){
    $db = db_connect();
    $associatedCompanyID = getUserInfo($_SESSION['userID'], "associatedCompany");

    //get list of all possible users in company
    $sql = "SELECT * FROM userinfo
            WHERE associatedCompany = ? AND accountType = 'developer'";
    $values = [$associatedCompanyID];
    $stmt = $db->prepare($sql);
    $stmt->execute($values);
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}

?>
