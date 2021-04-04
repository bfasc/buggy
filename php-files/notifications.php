<?php
    function listNotifications($userID) {
        try {
            $db = db_connect();
            $date = date('Y-m-d H:i:s');
            $values = [$userID];
            $sql = "SELECT * FROM notifications WHERE user = ? AND viewed = 0";

            $stmt = $db->prepare($sql);
            $stmt->execute($values);
            $results = $stmt->fetchAll(PDO::FETCH_ASSOC);

            foreach($results as $row) {
                $description = $row['notifText'];
                $link = $row['link'];

                $today = date('Y-m-d');
                $date = date("Y-m-d", strtotime($row['notifDate']));
                $difference = date_diff(date_create($today), date_create($date));
                $difference = $difference->format("%a");
                switch($difference) {
                    case 0:
                        $dateFormat = date("g:i a", strtotime($row['notifDate']));
                        break;
                    case 1:
                        $dateFormat = "Yesterday " . date("g:i a", strtotime($row['notifDate']));
                        break;
                    default:
                        $dateFormat = $difference . " days ago";
                }

                print("<div class='notif'>");
                    print("<p>$description</p>
                            <p class='date'><i class='far fa-clock'></i>$dateFormat</p>
                            <a class='button read' href='$link' id='" . $row['id'] . "'>View Here</a>
                            <a class='button read' id='" . $row['id'] . "'>Mark As Read</a>");
                print("</div>");
            }
            return TRUE;
        } catch (Exception $e) {
            return FALSE;
        } finally {
            $db = NULL;
        }
    }


?>
