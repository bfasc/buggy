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
 * Takes a project ID and returns its total employee count
 */
function getEmployeeCount($projectID)
{
    $companyID = getProjectInfo($projectID, "associatedCompany");
    $totalEmployees = 0;

    //get all employees in company
    $db = db_connect();
    $sql = "SELECT assignedProjects FROM userinfo WHERE associatedCompany = $companyID AND accountType = 'developer'";
    $stmt = $db->prepare($sql);
    $stmt->execute();
    $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
    foreach ($result as $row) {
        $allProjects = explode(",", $row['assignedProjects']);
        if(array_search($projectID, $allProjects) !== FALSE)
            ++$totalEmployees;
    }

    return $totalEmployees;
}
?>
