<?php
    /* Function Name: getCompanyInfo
    * Description: retrieve company and project information from database by code
    * Parameters: code (string - company code)
    * Return Value: arary with company ID, project ID, company name, project name
    */
    function getCompanyInfo($code){
        try {
            $db = db_connect();

            //get company information
            $sql = "SELECT
                companyinfo.companyName, companyinfo.id AS companyID, projectinfo.projectName, projectinfo.id AS projectID
                FROM companyinfo
                INNER JOIN projectinfo
                ON companyinfo.companyCode = projectinfo.associatedCompany
                WHERE companyCode=?";
            $values = [$code];
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
?>
