<?php
function updateCompany($name, $phone, $address, $city, $state, $zip, $country, $id) {
    try {
        $db = db_connect();
        $values = [$name, $phone, $address, $city, $state, $zip, $country, $id];
        $sql = "UPDATE companyinfo SET
        companyName = ?,
        phoneNumber = ?,
        streetAddress = ?,
        city = ?,
        state = ?,
        zip = ?,
        country = ?,
        WHERE id = ?";
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
