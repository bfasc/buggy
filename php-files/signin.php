<?php
/* Function Name: checkLogin
 * Description: check if user’s email and pw matches
 * Parameters: email (string, form email), password (string, form password)
 * Return Value: array with userid and account type
 */
function checkLogin($email, $password) {
    try {
        $userID = getUserID($email);
        $companyID = getUserInfo($userID, "associatedCompany");

        // if((getAccountType($userID) == "management") && (getCompanyInfo($companyID, "purchased") == 0)) {
        //     $result = "notPurchased";
        // } else {
            $db = db_connect();
            $values = [$email, $password];
            $sql = "SELECT id, accountType FROM userinfo WHERE email = ? AND password = md5( ? )";
            $stmt = $db->prepare($sql);
            $stmt->execute($values);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
        // }
        return $result;
    } catch (Exception $e) {
        return NULL;
    } finally {
        $db = NULL;
    }
}

$db = NULL;
