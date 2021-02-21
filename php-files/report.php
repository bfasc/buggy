<?php
    /* Function Name: getCompanyInfo
    * Description: retrieve company and project information from database by code
    * Parameters: code (string - company code), projectID (id - associated project ID)
    * Return Value: arary with company ID, project ID, company name, project name
    */
    function getCompanyReportInfo($code, $projectID){
        try {
            $db = db_connect();

            //get company information
            $sql = "SELECT
                companyinfo.companyName, companyinfo.id AS companyID, projectinfo.projectName, projectinfo.id AS projectID
                FROM companyinfo
                INNER JOIN projectinfo
                ON companyinfo.id = projectinfo.associatedCompany
                WHERE companyinfo.companyCode=? AND projectinfo.id=?";
            $values = [$code, $projectID];
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
