<?php
/* Function Name: resetPassword
 * Description: reset a user's password
 * Parameters: email (string, md5 email), password (string, form password)
 * Return Value: T/F on success
 */
function resetPassword($email, $password) {
    try {
        $db = db_connect();
        $date = date('Y-m-d');
        $values = [$date, $email];
        $sql = "UPDATE userinfo SET password = md5( '$password' ), passLastChanged = ? WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        return TRUE;
    } catch (Exception $e) {
        return FALSE;
    } finally {
        $db = NULL;
    }
}

$db = NULL;
