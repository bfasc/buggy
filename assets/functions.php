<?php

    //Database Connection Function
    REQUIRE_ONCE 'dbconnect.php';

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
    function printHead($title){
        session_start();
        print ("
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
          <script src='http://ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js'></script>

          <!-- FONT AWESOME ----------------------->
          <script src='https://kit.fontawesome.com/a062562745.js' crossorigin='anonymous'></script>

        </head>
        ");
    }

    /* Function Name: printSidebar
     * Description: print the sidebar section for HTML depending on page type
     * Parameters: type (string, can be notloggedin, developer, manager, or report)
     * Return Value: none (void)
     */
    function printSidebar($type) {
        print("<div id='sidebar'>");
        switch ($type) {
            case "notloggedin":

                break;
            case "developer":

                break;
            case "manager":

                break;
            case "report":
                print("<a href='https://project-buggy.herokuapp.com/''><img src='assets/img/LOGO_MAIN.png'></a>");
                break;
            default:
                print("<a>Sorry, there was an error in the sidebar.</a>");
        }
        print("</div>"); //end sidebar
    }

    /* Function Name: printFooter
     * Description: print the footer section for HTML depending on page type
     * Parameters: type (string, can be basic or report)
     * Return Value: none (void)
     */
    function printFooter($type) {
        print("<footer>");
        switch ($type) {
            case "basic":

                break;
            case "report":
                print("
                    <p>This form is powered by <a href='https://project-buggy.herokuapp.com/' class='button'>Buggy</a></p>
                    <p><a class='emphasis'>Buggy</a> All Rights Reserved</p>
                ");
                break;
            default:
                print("<a>Sorry, there was an error in the footer.</a>");
        }
        print("</footer>");
    }

    /* Function Name: sendEmail
     * Description: send an email
     * Parameters: header (string), to (string), from (string), content (string)
     * Return Value: none (void)
     */
     function sendEmail($subject, $to, $from, $content) {
         $headers = 'From:' . $from . "\r\n";
         $headers .= "Content-Type: text/html; charset=ISO-8859-1\r\n";
         $headers .= "x-trustifi-key: fff5a5665045679658eb6fb15d4f4310c663a2c4cec5b848\r\n";
         $headers .= "x-trustifi-secret: 0d2c56496d8da831621cd31d3e663953\r\n";
         mail($to, $subject, $content, $headers);
     }
?>
