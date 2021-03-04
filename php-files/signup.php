<?php

/* Function Name: createDevUser
 * Description: create row in user info table for developer account
 * Parameters: email (string - form email), firstname (string - form firstname), lastname (string - form lastname), password (string - form password), companyCode (string - form company code)
 * Return Value: boolean T/F on success
 */
function createDevUser($email, $firstName, $lastName, $password, $companyCode) {
    try {
        $db = db_connect();
        $hash = md5( rand(0,1000) ); //verification code
        $values = [
            $email,
            $firstName,
            $lastName,
            getCompanyID($companyCode),
            "developer",
            $hash,
            date('Y-m-d')
        ];
        $sql = "INSERT INTO userinfo (email, firstName, lastName, password, associatedCompany, accountType, verificationCode, passLastChanged) VALUES (?, ?, ?, md5( '$password' ), ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute($values);

        $subject = "Please verify your Buggy account";
        $content = "Thank you for signing up for your Buggy account! Please click the link below to verify your account.<br><a href='http://project-buggy.herokuapp.com/verify?code=$hash&email=$email'>Click Here to verify your account</a>";

        sendEmail($subject, $_POST['email'], "project-buggy@trustifi.com", $content);
        return TRUE;
    } catch (Exception $e) {
        return FALSE;
    } finally {
        $db = NULL;
    }
}

/* Function Name: createManUser
 * Description: create row in user info table for management account
 * Parameters: email (string - form email), firstname (string - form firstname), lastname (string - form lastname), password (string - form password), companyName (string - form company name), companyPhone (string - form company phone #), companyStreet (string - form company street addr), companyCity (string - form company city), companyState (string - form company state), companyZip (int -form company zip code)
 * Return Value: boolean T/F on success
 */
function createManUser($email, $firstName, $lastName, $password, $companyName, $companyPhone, $companyStreet, $companyCity, $companyState, $companyCountry, $companyZip) {
    try {
        $db = db_connect();
        // Create Company in DB
        $companyCode = createCompany($companyName, $companyPhone, $companyStreet, $companyCity, $companyState, $companyCountry, $companyZip);
        if(!$companyCode) return FALSE;


        // Create user in DB
        $hash = md5( rand(0,1000) ); //verification code
        $values = [
            $email,
            $firstName,
            $lastName,
            getCompanyID($companyCode),
            "management",
            $hash,
            date('Y-m-d')
        ];
        $sql = "INSERT
        INTO userinfo (email, firstName, lastName, password, associatedCompany, accountType, verificationCode, passLastChanged)
        VALUES (?, ?, ?, md5( '$password' ), ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute($values);

        //Add new management account to company's db row
        $values = [$db->lastInsertID(), $companyCode];
        $sql = "UPDATE companyinfo
        SET managementAccountAssociated = ?
        WHERE companyCode = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute($values);

        $subject = "Please verify your Buggy account";
        $content = "Thank you for signing up for your Buggy account! Please click the link below to verify your account.<br><a href='http://wwww.https://project-buggy.herokuapp.com/verify?code=$hash&email=$email'>Click Here to verify your account</a>";

        sendEmail($subject, $_POST['email'], "project-buggy@trustifi.com", $content);
        return TRUE;
    } catch (Exception $e) {
        return FALSE;
    } finally {
        $db = NULL;
    }
}


/* Function Name: createCompany
 * Description: create row in company info table for company
 * Parameters: companyName (string - form company name), companyPhone (string - form company phone #), companyStreet (string - form company street addr), companyCity (string - form company city), companyState (string - form company state), companyZip (int -form company zip code)
 * Return Value: new row's company code column
 */
function createCompany($companyName, $companyPhone, $companyStreet, $companyCity, $companyState, $companyCountry, $companyZip) {
    try {
        $db = db_connect();
        $companyCode = generateRandomCode();
        while(companyCodeExists($companyCode)) {
            $companyCode = generateRandomCode();
        }
        // Create user in DB
        $hash = md5( rand(0,1000) ); //verification code
        $values = [
            $companyCode,
            $companyName,
            $companyStreet,
            $companyCity,
            $companyState,
            $companyZip,
            $companyCountry,
            $companyPhone
        ];
        $sql = "INSERT INTO companyinfo (companyCode, companyName, streetAddress, city, state, zip, country, phoneNumber) VALUES (?, ?, ?, ?, ?, ?, ?, ?)";
        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        return $companyCode;
    } catch (Exception $e) {
        return FALSE;
    } finally {
        $db = NULL;
    }
}
?>
