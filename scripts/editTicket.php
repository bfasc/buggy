<?php
    REQUIRE_ONCE "../assets/functions.php";
    try {
        $db = db_connect();
        if($_POST['type'] == "full") {
            $developerList = json_decode($_POST['developers']);

            $developerString = "";
            foreach($developerList as $key => $developer) {
                $developerString .= substr($developer, 10);
                if($key != count($developerList)-1) $developerString .= ",";
            }


            // //set values and update ticketinfo table
            $date = date('Y-m-d H:i:s');
            $values = [
                $_POST['name'],
                $_POST['description'],
                $_POST['priority'],
                $_POST['progress'],
                $developerString,
                $date,
                $_POST['id']
            ];
            $sql = "UPDATE
            ticketinfo SET name = ?, description = ?, priority = ?, status = ?, assignedDevelopers = ?, lastEditedDate = ?
            WHERE id = ?";

            $stmt = $db->prepare($sql);
            $stmt->execute($values);
            $response = "success";
        } else { //only editing progress
            $values = [
                $_POST['progress'],
                $_POST['id']
            ];
            $sql = "UPDATE ticketinfo
            SET status = ?
            WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute($values);
            $response = "success";
        }

        // Send notification to each assigned dev
        $newDevs = getTicketInfo($_POST['id'], "assignedDevelopers");
        $newDevs = explode(",", $newDevs);
        foreach($newDevs as $dev) {
            newNotification("A ticket you're working (Ticket " . $_POST['id'] . " : " . $_POST['name'] . ") on has been updated.", $dev, "ticket/" . $_POST['id']);
        }
    } catch (Exception $e) {
        $response = $e;
    } finally {
        $db = NULL;
    }
    $return_arr = array("response" => $response);
    echo json_encode($return_arr);
?>
