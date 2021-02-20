<?php
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
