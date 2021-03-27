<?php
require_once 'assets/functions.php';
require_once 'php-files/search.php';
printHead("Search Tickets | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "companymanagement"); ?>
    <?php
    $totalProjects = 0;
    $projectArray = [];
    $companyID = getAssociatedCompanyID($_SESSION['userID']);
    $projects = getAllProjects($_SESSION['userID']);
    foreach ($projects as $element) {
        echo "Project ID: $element[id]\n";
        ++$totalProjects;
        getTotalTickets($element);
        getTotalOpenTickets($element);
        getTotalUnapprovedTickets($element);
        getTotalCompletedTickets($element);
        getEmployeeProjectArray($element, $companyID, $projectArray);
    }
    foreach ($projects as $element) {
        getTotalEmployees($projectArray, $element);
    }
    echo "<p>Total Projects: $totalProjects</p>";
    ?>

    <?php printFooter("basic"); ?>
</body>

</html>

<?php
/**
 * Gets the company ID of the of the mamangement user who is signed in.
 * To be used when getting the employess.
 */
function getAssociatedCompanyID($userID)
{
    try {
        $db = db_connect();
        $values = [$userID];

        $sql = "SELECT associatedCompany FROM userinfo WHERE id = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        $result = $stmt->fetchColumn();
        return $result;
    } catch (Exception $e) {
        return NULL;
    } finally {
        $db = NULL;
    }
}
/**
 * Gets the total tickets that exists for a project.
 */
function getTotalTickets($element)
{
    try {
        $db = db_connect();
        $totalTickets = 0;
        $sql = "SELECT * FROM ticketinfo WHERE associatedProjectID = $element[id]";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            ++$totalTickets;
        }
        echo "Total Tickets: $totalTickets\n";
    } catch (Exception $e) {
        echo "Error";
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
        $sql = "SELECT status FROM ticketinfo WHERE associatedProjectID = $element[id]";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            if ("$row[status]" !== "Completed") {
                ++$totalOpenTickets;
            }
        }
        echo "Total Open Tickets: $totalOpenTickets\n";
    } catch (Exception $e) {
        echo "Error";
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
        $sql = "SELECT approval FROM bugreportinfo WHERE associatedProjectID = $element[id]";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            if ("$row[approval]" == 0) {
                ++$totalUnapprovedTickets;
            }
        }
        echo "Total Unapproved Tickets: $totalUnapprovedTickets\n";
    } catch (Exception $e) {
        echo "Error";
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
        $sql = "SELECT status FROM ticketinfo WHERE associatedProjectID = $element[id]";
        $stmt = $db->prepare($sql);
        $stmt->execute();
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach ($result as $row) {
            if ("$row[status]" == "Completed") {
                ++$totalCompletedTickets;
            }
        }
        echo "Total Completed Tickets: $totalCompletedTickets\n";
    } catch (Exception $e) {
        echo "Error";
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
        $sql = "SELECT assignedProjects FROM userinfo WHERE associatedCompany = $companyID AND accountType = 'developer' AND assignedProjects = $element[id]";
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
        echo "Error";
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
    $x = (int)"$element[id]";
    $totalEmployees = 0;
    foreach ($projectArray as $p) {
        if ($p === $x) {
            ++$totalEmployees;
        }
    }
    echo "Total Employees: $totalEmployees\n";
}
?>