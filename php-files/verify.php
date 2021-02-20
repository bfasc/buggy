<?php
/* Function Name: checkCode
 * Description: check if an email and verification code match
 * Parameters: email (string, get email), code (string, get hash code)
 * Return Value: boolean T/F
 */
function checkCode($email, $code) {
    try {
        $db = db_connect();
        $values = [$email, $code];
        $sql = "SELECT COUNT(*) FROM userinfo WHERE email = ? AND verificationCode = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        $result = $stmt->fetch();
        if($result != 0) return TRUE;
        else return FALSE;
    } catch (Exception $e) {
        return FALSE;
    } finally {
        $db = NULL;
    }
}

/* Function Name: verifyAccount
 * Description: change db row verified column from 0 to 1
 * Parameters: email (string, get email)
 * Return Value: boolean T/F on success
 */
function verifyAccount($email) {
    try {
        $db = db_connect();
        $values = [$email];
        $sql = "UPDATE userinfo SET verified = 1 WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        return TRUE;
    } catch (Exception $e) {
        return FALSE;
    } finally {
        $db = NULL;
    }
}

/* Function Name: checkPurchased
 * Description: check if an account has purchased buggy
 * Parameters: userID (int, management account id associated)
 * Return Value: boolean T/F
 */
function checkPurchased($userID) {
    try {
        $db = db_connect();
        $values = [$userID];
        $sql = "SELECT * FROM companyinfo WHERE managementAccountAssociated = ? AND purchased = 1";
        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        $result = $stmt->fetchColumn();
        return $result;
    } catch (Exception $e) {
        return FALSE;
    } finally {
        $db = NULL;
    }
}
?>
