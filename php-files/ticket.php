<?php
    function getThreadInfo($ticketID) {
        try {
            $db = db_connect();
            $values = [$ticketID];
            $sql = "SELECT * FROM comments WHERE ticket = ? AND reply = 0 ORDER BY postDate DESC";

            $stmt = $db->prepare($sql);
            $stmt->execute($values);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return 0;
        } finally {
            $db = NULL;
        }
    }
    function getReplies($commentID) {
        try {
            $db = db_connect();
            $values = [$commentID];
            $sql = "SELECT * FROM comments WHERE reply = ? ORDER BY postDate DESC";

            $stmt = $db->prepare($sql);
            $stmt->execute($values);
            return $stmt->fetchAll(PDO::FETCH_ASSOC);
        } catch (Exception $e) {
            return 0;
        } finally {
            $db = NULL;
        }
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
