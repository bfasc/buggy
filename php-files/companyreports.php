<?php
/**
 * Gets the total tickets that exists for a project.
 */
function getTotalTickets($element)
{
    try {
        $db = db_connect();
        $totalTickets = 0;
        $sql = "SELECT * FROM ticketinfo WHERE associatedProjectID = $element";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            ++$totalTickets;
        }
        return $totalTickets;
    } catch (Exception $e) {
        return NULL;
    } finally {
        $db = NULL;
    }
}
/**
 * Gets the total tickets that are marked as not being completed for a specific project.
 */
function getTotalOpenTickets($element)
{
    try {
        $db = db_connect();
        $totalOpenTickets = 0;
        $sql = "SELECT status FROM ticketinfo WHERE associatedProjectID = $element";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            if ("$row[status]" !== "Completed") {
                ++$totalOpenTickets;
            }
        }
        return $totalOpenTickets;
    } catch (Exception $e) {
        return NULL;
    } finally {
        $db = NULL;
    }
}
/**
 * Gets the total amount of tickets that have not been approved for a certain project.
 */
function getTotalUnapprovedTickets($element)
{
    try {
        $db = db_connect();
        $totalUnapprovedTickets = 0;
        $sql = "SELECT approval FROM bugreportinfo WHERE associatedProjectID = $element";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            if ("$row[approval]" == 0) {
                ++$totalUnapprovedTickets;
            }
        }
        return $totalUnapprovedTickets;
    } catch (Exception $e) {
        return NULL;
    } finally {
        $db = NULL;
    }
}
/**
 * Gets the total amount of tickets that have been marked as completed.
 */
function getTotalCompletedTickets($element)
{
    try {
        $db = db_connect();
        $totalCompletedTickets = 0;
        $sql = "SELECT status FROM ticketinfo WHERE associatedProjectID = $element";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            if ("$row[status]" == "Completed") {
                ++$totalCompletedTickets;
            }
        }
        return $totalCompletedTickets;
    } catch (Exception $e) {
        return NULL;
    } finally {
        $db = NULL;
    }
}
/**
 * Returns an array of all of the projects employess are assigned to in order to
 * be looped over to then get the total amount of employess on a given project.
 */
function getEmployeeProjectArray($element, $companyID, &$projectArray)
{
    try {
        $db = db_connect();
        $sql = "SELECT assignedProjects FROM userinfo WHERE associatedCompany = $companyID AND accountType = 'developer' AND assignedProjects = $element";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            $newArray = explode(",", "$row[assignedProjects]");
            foreach ($newArray as $e) {
                array_push($projectArray, (int)$e);
            }
        }
        return $projectArray;
    } catch (Exception $e) {
        return NULL;
    } finally {
        $db = NULL;
    }
}
/**
 * Takes the array of project IDs and adds them up to get the total amount ot employess
 * for a specific project.
 */
function getTotalEmployees($projectArray, $element)
{
    $x = (int)"$element";
    $totalEmployees = 0;
    foreach ($projectArray as $p) {
        if ($p === $x) {
            ++$totalEmployees;
        }
    }
    return $totalEmployees;
}
?>
