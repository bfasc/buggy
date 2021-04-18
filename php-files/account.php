<?php
require_once "resetpassword.php";
    function updateAccount($password, $email, $firstName, $lastName, $id) {
        try {
            if($password)
                resetPassword(getUserInfo($id, "email"), $password);
            $db = db_connect();
            $values = [$email, $firstName, $lastName, $id];
            $sql = "UPDATE users SET email = ?, firstName = ?, lastName = ? WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute($values);
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        } finally {
            $db = NULL;
        }
    }

?>
