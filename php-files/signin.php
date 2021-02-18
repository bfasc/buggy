<?php
/* Function Name: checkVerified
 * Description: check if user’s email is verified
 * Parameters: email (string, form email)
 * Return Value: boolean T/F
 */
function checkVerified($email) {
    try {
        $db = db_connect();
        $values = [$email];
        $sql = "SELECT * FROM userinfo WHERE verified = 1 AND email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        $result = $stmt->fetchColumn();
        return $result;
    } catch (Exception $e) {
        return NULL;
    } finally {
        $db = NULL;
    }

}

/* Function Name: emailExists
 * Description: check if email is in database
 * Parameters: email (string, form email)
 * Return Value: boolean T/F
 */
function emailExists($email) {
    try {
        $db = db_connect();
        $values = [$_POST['email']];

        $sql = "SELECT * FROM userinfo WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        $result = $stmt->fetchColumn();
        if($result) return TRUE;
        else return FALSE;
    } catch (Exception $e) {
        return FALSE;
    } finally {
        $db = NULL;
    }
}

/* Function Name: checkLogin
 * Description: check if user’s email and pw matches
 * Parameters: email (string, form email), password (string, form password)
 * Return Value: array with userid and account type
 */
function checkLogin($email, $password) {
    try {
        $db = db_connect();
        $values = [$email, $password];
        $sql = "SELECT id, accountType FROM userinfo WHERE email = ? AND password = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result;
    } catch (Exception $e) {
        return NULL;
    } finally {
        $db = NULL;
    }
}

$db = NULL;
?>
