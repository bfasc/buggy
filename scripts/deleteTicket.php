<?php
    REQUIRE_ONCE "../assets/functions.php";
    try {
        $db = db_connect();
        $values = [$_POST['id']];
        $sql = "DELETE FROM ticketinfo WHERE id=?";

        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        $response = "success";
    } catch (Exception $e) {
        $response = $e;
    } finally {
        $db = NULL;
    }
    $return_arr = array("response" => $response);
    echo json_encode($return_arr);
?>
