<?php
    function getThreadInfo($ticketID) {

    }

    //get the ticket ID that the comment ID associates with
    function getReplyTicketID($id) {
        try {
            $db = db_connect();
            $values = [$id];
            $sql = "SELECT ticket FROM comments WHERE id = ?";

            $stmt = $db->prepare($sql);
            $stmt->execute($values);
            return $stmt->fetchColumn();

        } catch (Exception $e) {
            return 0;
        } finally {
            $db = NULL;
        }
    }
?>
