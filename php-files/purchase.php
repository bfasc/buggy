<?php
/* Function Name: purchaseBuggy
 * Description: mark company account as purchased to verify purchase
 * Parameters: email (string, form email), firstName (string, form fname), lastName (string, form lname), creditCard (string, form cc number)
 * Return Value: boolean T/F
 */
    function purchaseBuggy($email, $firstName, $lastName, $creditCard) {
        try {
            $db = db_connect();
            $values = [$email];
            $sql = "SELECT id FROM userinfo WHERE email = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute($values);
            $result = $stmt->fetchColumn();
            $userID = $result;

            $values = [$userID];
            $sql = "UPDATE companyinfo SET purchased = 1 WHERE ManagementAccountAssociated = ?";
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
