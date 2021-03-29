<?php

//Database Connection Function
require_once 'dbconnect.php';

/*
        NOTE: WHEN YOU NEED TO CONNECT TO THE DATABASE IN THIS OR ANY FILE:
        TYPE: $db = db_connect();
        USE VARIABLE $db FOR DATABASE STATEMENTS, FOR EXAMPLE:
            $stmt = $db->prepare($sql);
        AT THE END OF THE FUNCTION, TYPE:
            $db = NULL;
    */


/* ================== BASIC PAGE NEEDS ================= */

/* Function Name: printHead
     * Description: print the <head> section for HTML with custom title
     * Parameters: title (string)
     * Return Value: none (void)
     */
function printHead($title)
{
    session_start();
    print("
        <!DOCTYPE html>
        <html lang='en'>
        <head>

          <!-- Basic Page Needs
          –––––––––––––––––––––––––––––––––––––––––––––––––– -->
          <meta charset='utf-8'>
          <title>$title</title>
          <meta name='description' content=''>

          <!-- Mobile Specific Metas
          –––––––––––––––––––––––––––––––––––––––––––––––––– -->
          <meta name='viewport' content='width=device-width, initial-scale=1'>

          <!-- CSS
          –––––––––––––––––––––––––––––––––––––––––––––––––– -->
          <link rel='stylesheet' href='assets/css/normalize.css'>
          <link rel='stylesheet' href='assets/css/style.css'>

          <!-- Favicon
          –––––––––––––––––––––––––––––––––––––––––––––––––– -->
          <link rel='icon' type='image/png' href='assets/img/favicon.ico'>

          <!-- JQUERY
          –––––––––––––––––––––––––––––––––––––––––––––––––– -->
          <script src='https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js'></script>

          <!-- FONT AWESOME ----------------------->
          <script src='https://kit.fontawesome.com/a062562745.js' crossorigin='anonymous'></script>

        </head>
        ");
}

/* Function Name: printHeader
     * Description: print the header section for HTML if user is logged in
     * Parameters: userID (session user ID)
     * Return Value: none (void)
     */
function printHeader($userID)
{
    $firstName = getUserInfo($userID, "firstName");
    $ticketNum = 0; //TODO : GET TICKET NUMBER
    print("<header>
                    <img src='assets/img/LOGO_MAIN.png'>
                    <div>
                        <h2>Hello, $firstName</h2>
                        <p>You have <a id='ticketnum'>" . getTicketNum($userID) . "</a> unfinished tickets.</p>
                    </div>
                </header>
        ");
}

/* Function Name: printSidebar
     * Description: print the sidebar section for HTML depending on page type
     * Parameters: type (string, can be notloggedin, developer, manager, or report), current (current page)
     * Return Value: none (void)
     */
function printSidebar($type, $current)
{

    //special sidebar css
    if ($type == "report") $report = "report";
    else $report = "";


    if ($type == "notloggedin") { //redirect to home page if logged in
        if (isset($_SESSION['userID']) && !empty($_SESSION['userID'])) {
            header("Location: tickets");
            exit();
        }
        if (isset($_SESSION['userID']) && !empty($_SESSION['userID']) && (getUserInfo($_SESSION['userID'], "accountType") == "developer" && $type == "management")) { //redirect to homepage if dev tries to access man page
            header("Location: tickets");
            exit();
        }
    } else if ($type != "report") { //redirect to signin page if not logged in
        if (!isset($_SESSION['userID']) && empty($_SESSION['userID'])) {
            header("Location: signin");
            exit();
        }
    }
    print("<div class='wrap'>");
    print("<div class='sidebar $report'>");
    switch ($type) {
        case "notloggedin":
            print("
                    <section id='nav'>
                        <a href='index'>Home</a>
                        <a href='about'>About Us</a>
                        <a href='purchase'>Get Buggy</a>
                        <a href='more'>Learn More</a>
                        <a href='signin'>Sign In</a>
                        <a href='signup'>Sign Up</a>
                        <a href='report'>Report Bug</a>
                    </section>
                    <section id='side-info'>
                        <img src='assets/img/LOGO_FOOTER.png'>
                    </section>
                ");
            break;
        case "developer":
            print("
                <section id='nav'>
                    <a href='tickets'>Your Tickets</a>
                    <a href='projects'>Your Projects</a>
                    <a href='search'>Search All Tickets</a>
                    <a href='accountmanagement'>Manage Account</a>
                    <a href='notifications'>Notifications</a>
                    <a href='signout'>Sign Out</a>
                </section>
                <section id='side-info'>
                    <img src='assets/img/LOGO_FOOTER.png'>
                </section>
                ");
            break;
        case "management":
            print("
                <section id='nav'>
                    <a href='tickets'>Your Tickets</a>
                    <a href='projects'>Your Projects</a>
                    <a href='search'>Search Tickets</a>
                    <a href='accountmanagement'>Manage Account</a>
                    <a href='companymanagement'>Manage Company</a>
                    <a href='employeemanagement'>Manage Employees</a>
                    <a href='approval'>Bug Approval</a>
                    <a href='notifications'>Notifications</a>
                    <a href='signout'>Sign Out</a>
                </section>
                <section id='side-info'>
                    <img src='assets/img/LOGO_FOOTER.png'>
                </section>
                ");
            break;
        case "report":
            print("<a href='https://project-buggy.herokuapp.com/'><img src='assets/img/LOGO_MAIN.png'></a>");
            break;
        default:
            print("<a>Sorry, there was an error in the sidebar.</a>");
    }
    print("</div>"); //end sidebar

    //JS to add current attribute
    print("
        <script>
            var current = $(\"a[href='$current']\");
            current.addClass('current');
        </script>
        ");
}

/* Function Name: printFooter
     * Description: print the footer section for HTML depending on page type
     * Parameters: type (string, can be basic or report)
     * Return Value: none (void)
     */
function printFooter($type)
{
    print("</div>"); //end wrap
    print("<footer>");
    switch ($type) {
        case "basic":
            print("
                <div class='links'>
                <!--GITHUB-->
                <!--TWITTER-->
                <!--LINKEDIN-->
                </div>

                <a href='contact'>Contact Us</a>
                <div class='logo'>
                    <a class='emphasis'>Buggy</a>
                    <a>All Rights Reserved</a>
                </div>
                ");
            break;
        case "report":
            print("
                    <div class='poweredby'>
                        <p>This form is powered by <a href='https://project-buggy.herokuapp.com/'>Buggy</a>
                            </p>
                    </div>
                    <div class='logo report'>
                        <a class='emphasis'>Buggy</a>
                        <a>All Rights Reserved</a>
                    </div>
                ");
            break;
        default:
            print("<a>Sorry, there was an error in the footer.</a>");
    }
    print("</footer>");
}

/* Function Name: getTicketNum
     * Description: get current amount of assigned tickets
     * Parameters: userID (int, user to be searched)
     * Return Value: int, assigned tickets
     */
function getTicketNum($userID)
{
    try {
        $db = db_connect();

        //cycle through all possible projects
        $projects = getAllProjects($userID);
        $count = 0;
        foreach($projects as $projectID) {
            $values = [$projectID];
            $sql = "SELECT assignedDevelopers FROM ticketinfo WHERE associatedProjectID = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute($values);
            $assignedDevelopers = $stmt->fetchAll(PDO::FETCH_ASSOC);
            foreach($assignedDevelopers as $ticket) {
                if($ticket["assignedDevelopers"]) {
                    $developerList = explode(",", $ticket["assignedDevelopers"]);
                    //search array for user's ID
                    if(array_search($userID, $developerList) !== FALSE) $count++;
                }
            }
        }

        return $count;
    } catch (Exception $e) {
        return FALSE;
    } finally {
        $db = NULL;
    }
}

/* Function Name: sendEmail
     * Description: send an email
     * Parameters: header (string), to (string), from (string), content (string)
     * Return Value: none (void)
     */
function sendEmail($subject, $to, $from, $content)
{
    //replace apos and quot with html code so it's parsed correctly
    // $content = str_replace("'", "", $content);
    // $content = str_replace('"', "", $content);
    $headers = "From:noreply@projectbuggy.tk" . "\r\n";
    $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
    mail($to, $subject, $content, $headers);
}

/* Function Name: emailExists
      * Description: check if email is in database
      * Parameters: email (string, form email)
      * Return Value: boolean T/F
      */
function emailExists($email)
{
    try {
        $db = db_connect();
        $values = [$email];

        $sql = "SELECT * FROM userinfo WHERE email = ?";
        $stmt = $db->prepare($sql);
        $stmt->execute($values);
        $result = $stmt->fetchColumn();
        if ($result) return TRUE;
        else return FALSE;
    } catch (Exception $e) {
        return FALSE;
    } finally {
        $db = NULL;
    }
}

/* Function Name: checkVerified
      * Description: check if user’s email is verified
      * Parameters: email (string, form email)
      * Return Value: boolean T/F
      */
function checkVerified($email)
{
    try {
        $db = db_connect();
        $values = [$email];
        $sql = "SELECT * FROM userinfo WHERE verified = 1 AND email = ?";
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

/* Function Name: companyCodeExists
      * Description: check if company code already exists in database
      * Parameters: code (int, 10-digit integer)
      * Return Value: boolean T/F
      */
function companyCodeExists($code)
{
    try {
        $db = db_connect();
        $values = [$code];
        $sql = "SELECT * FROM companyinfo WHERE companyCode = ?";
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

/* Function Name: generateRandomCode
      * Description: generate a random 10-digit code
      * Parameters: none
      * Return Value: int random code
      */
function generateRandomCode()
{
    $numbers = range(0, 9);
    shuffle($numbers);
    for ($i = 0; $i < 10; $i++) {
        global $digits; // global meaning that a variable that is defined being global is able to be used inside of a local function
        $digits .= $numbers[$i]; // concatentation assingment meaning each random number is added onto the previous making one big number in the end
    }
    return $digits;
}



/* ============== GETS ================== */


/* Function Name: getCompanyID
      * Description: get company ID corresponding to unique code
      * Parameters: companyCode (string, company code)
      * Return Value: company ID
      */
function getCompanyID($companyCode)
{
    try {
        $db = db_connect();
        $values = [$companyCode];

        $sql = "SELECT id FROM companyinfo WHERE companyCode = ?";
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

/* Function Name: getUserID
      * Description: get user ID corresponding to email
      * Parameters: email (string, email)
      * Return Value: user ID
      */
function getUserID($email)
{
    try {
        $db = db_connect();
        $values = [$email];

        $sql = "SELECT id FROM userinfo WHERE email = ?";
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


/* Function Name: getUserInfo
      * Description: get user info belonging to the corresponding user ID
      * Parameters: userID (user ID), column (db column to grab)
      * Return Value: user info
      */
function getUserInfo($userID, $column)
{
    try {
        $db = db_connect();
        $values = [$userID];

        $sql = "SELECT $column FROM userinfo WHERE id = ?";
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

/* Function Name: getCompanyInfo
      * Description: get company info belonging to the corresponding company ID
      * Parameters: companyID (company ID), column (db column to grab)
      * Return Value: company info
      */
function getCompanyInfo($companyID, $column)
{
    try {
        $db = db_connect();
        $values = [$companyID];

        $sql = "SELECT $column FROM companyinfo WHERE id = ?";
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

/* Function Name: getProjectInfo
      * Description: get project info belonging to the corresponding project ID
      * Parameters: projectID (project ID), column (db column to grab)
      * Return Value: project info
      */
function getProjectInfo($projectID, $column)
{
    try {
        $db = db_connect();
        $values = [$projectID];

        $sql = "SELECT $column FROM projectinfo WHERE id = ?";
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

/* Function Name: getTicketInfo
      * Description: get ticket info belonging to the corresponding ticket ID
      * Parameters: ticketID (ticket ID), column (db column to grab)
      * Return Value: ticket info
      */
function getTicketInfo($ticketID, $column)
{
    try {
        $db = db_connect();
        $values = [$ticketID];

        $sql = "SELECT $column FROM ticketinfo WHERE id = ?";
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

/* Function Name: getBugreportInfo
      * Description: get bug report info belonging to the corresponding bug report id
      * Parameters: reportID (project ID), column (db column to grab)
      * Return Value: report info
      */
function getBugReportInfo($reportID, $column)
{
    try {
        $db = db_connect();
        $values = [$reportID];

        $sql = "SELECT $column FROM bugreportinfo WHERE id = ?";
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

/* Function Name: getAccountType
      * Description: check account type of account ID
      * Parameters: userID (int, user id)
      * Return Value: account type associated (string)
      */
function getAccountType($userID)
{
    try {
        $db = db_connect();
        $values = [$userID];

        $sql = "SELECT accountType FROM userinfo WHERE id = ?";
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

/* Function Name: getAllProjects
      * Description: get all projects assigned to account
      * Parameters: userID (int, user id)
      * Return Value: array with all project IDs
      */
function getAllProjects($userID)
{
    try {
        $db = db_connect();

        if(getAccountType($userID) == "management") {
            $companyID = getUserInfo($userID, "associatedCompany");
            $values = [$companyID];

            $sql = "SELECT id FROM projectinfo WHERE associatedCompany = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute($values);
            $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
            $return = [];
            foreach($result as $row) {
                array_push($return, $row['id']);
            }
            return $return;
        } else {
            $values = [$userID];

            $sql = "SELECT assignedProjects FROM userinfo WHERE id = ?";
            $stmt = $db->prepare($sql);
            $stmt->execute($values);
            $result = $stmt->fetch(PDO::FETCH_ASSOC);
            if($result['assignedProjects']) $result = explode(",", $result['assignedProjects']);
            else $result = [];

            return $result;
        }
    } catch (Exception $e) {
        return [];
    } finally {
        $db = NULL;
    }
}
