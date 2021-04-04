<?php
    function listNotifications($userID) {
        try {
            $db = db_connect();
            $date = date('Y-m-d H:i:s');
            $values = [$userID];
            $sql = "SELECT * FROM notifications WHERE user = ?";

            $stmt = $db->prepare($sql);
            $stmt->execute($values);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($results as $row) {
                print_r($row);
            }
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        } finally {
            $db = NULL;
        }
    }


?>
