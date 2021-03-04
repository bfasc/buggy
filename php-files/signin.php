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

/* Function Name: checkPassReset
 * Description: check if user’s password has expired
 * Parameters: email (string, form email)
 * Return Value: boolean T/F
 */
 function checkPassReset($email) {
     try {
         $db = db_connect();
         $values = [$email];
         $sql = "SELECT passLastChanged FROM userinfo WHERE email = ?";
         $stmt = $db->prepare($sql);
         $stmt->execute($values);
         $result = $stmt->fetch(PDO::FETCH_ASSOC);

         $today = date('Y-m-d');

         $difference = date_diff(date_create($today), date_create($result['passLastChanged']));
         $difference = $difference->format("%a");
         if($difference >= 180) return FALSE;
         else return TRUE;

     } catch (Exception $e) {
         return FALSE;
     } finally {
         $db = NULL;
     }
 }

$db = NULL;
