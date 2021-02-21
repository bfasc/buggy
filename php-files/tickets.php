<?php
/* Function Name: fetchTickets
 * Description: print list of all tickets available to user
 * Parameters: userID (session user ID)
 * Return Value: none (void)
 */
function fetchTickets($userID) {
    try {
        $db = db_connect();

    } catch (Exception $e) {
        print ("Error! Exception : $e");
    } finally {
        $db = NULL;
    }
}

?>
