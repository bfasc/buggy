<?php
    REQUIRE_ONCE "../assets/functions.php";
    try {
        $db = db_connect();
        $values = [$_POST['id']];
        $sql = "UPDATE notifications SET viewed = 1 WHERE id = ?";

        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        $response = "success";
    } catch (Exception $e) {
        $response = "Error: $e";
    } finally {
        $db = NULL;
    }
    $return_arr = array("response" => $response);
    echo json_encode($return_arr);

?>
