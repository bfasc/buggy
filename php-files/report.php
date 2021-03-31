<?php
    /* Function Name: getProjectFromReport
    * Description: retrieve array of project info from report code
    * Parameters: reportCode (string - report code)
    * Return Value: arary with project info
    */
    function getProjectFromReport($reportCode){
        try {
            $db = db_connect();

            //get project info
            $sql = "SELECT * FROM projectinfo
                WHERE customLink = ?";
            $values = [$reportCode];
            $stmt = $db->prepare($sql);
            $stmt -> execute($values);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);

            return $result;
        } catch (Exception $e){
            return NULL;
        } finally {
            $db = NULL;
        }
    }

    /* Function Name: addBugReport
    * Description: insert bug report into table
    * Parameters: firstName (string - reporter fname), lastName (string - reporter lname), projectID (int), email (string - reporter email), details (string, bug details)
    * Return Value: boolean T/F on success
    */
    function addBugReport($firstName, $lastName, $projectID, $email, $details){
        try {
            $db = db_connect();

            // Prepared statement
            $stmt = $db->prepare("INSERT INTO bugreportinfo (associatedProjectID, firstName, lastName, reporterEmail, bugDescription) VALUES (?, ?, ?, ?, ?)");
            // Binding of those values to be entered
            $values = [
                $projectID,
                $firstName,
                $lastName,
                $email,
                $details
            ];
            // Executing the SQL statement
            if (!$stmt->execute($values)) {
                return FALSE;
            } else {
                return TRUE;
            }
        } catch (Exception $e){
            return FALSE;
        } finally {
            $db = NULL;
        }
    }

?>
