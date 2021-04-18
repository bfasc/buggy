<?php
    function updateAccount($password, $email, $firstName, $lastName, $id) {
        try {
            $db = db_connect();
            if($password) {
                $date = date('Y-m-d');
                $values = [$date, getUserInfo($id, "email")];
                $sql = "UPDATE userinfo SET password = md5( '$password' ), passLastChanged = ? WHERE email = ?";
                $stmt = $db->prepare($sql);
                $stmt->execute($values);
            }

            $values = [$email, $firstName, $lastName, $id];
            $sql = "UPDATE userinfo SET email = ?, firstName = ?, lastName = ? WHERE id = ?";
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
