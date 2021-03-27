<?php
function createProject($name, $category, $progress, $priority, $startDate, $endDate, $companyID) {
    try {
        if($startDate) $startDate = date('Y-m-d H:i:s', strtotime($startDate));
        if($endDate) $endDate = date('Y-m-d H:i:s', strtotime($endDate));

        $db = db_connect();
        $values = [$name, $category, $startDate, $endDate, $progress, $priority, $companyID];
        $sql = "INSERT INTO projectinfo
        (projectName, projectCategory, startDate, endDate, status, priority, associatedCompany)
        VALUES (?, ?, ?, ?, ?, ?, ?)";

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
