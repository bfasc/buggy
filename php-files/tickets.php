<?php
/* Function Name: fetchTickets
 * Description: print list of all tickets available to user
 * Parameters: userID (session user ID)
 * Return Value: none (void)
 */
function fetchTickets($userID, $progress) {
    try {
        $db = db_connect();
        $values = [$userID, $progress];

        $sql = "SELECT * FROM ticketinfo WHERE status = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
        foreach($result as $row) {
            print ("
                <div class='bug'>
                    <p class='name'>Report # : " . $row['id'] . "</p>
                    <p class='info'><a class='label'>Reported By: </a><a>" . $row['firstName'] . " " . $row['lastName'] . "</a></p>
                    <p class='info'><a class='label'>Email: </a><a>" . $row['reporterEmail'] . "</a></p>
                    <p class='info'><a class='label'>Project Name: </a><a>" . getProjectInfo($row['associatedProjectID'], "projectName") . "</a></p>
                    <p class='info'><a class='label'>Bug Details: </a><a>" . $row['bugDescription'] . "</a></p>
                    <div class='button-wrap'>
                        <a class='button approve cd-popup-trigger' id='" . $row['id'] . "' class='button'>Approve</a>
                        <a class='button deny cd-popup-trigger' id='" . $row['id'] . "' class='button'>Deny</a>
                    </div>
                </div>
            ");
        }
    } catch (Exception $e) {
        print ("Error in fetching bugs. $e");
    } finally {
        $db = NULL;
    }
}

?>
