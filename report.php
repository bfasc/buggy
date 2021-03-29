<?php
//TODO: ADD JS VALIDATION
require_once 'assets/functions.php';
require_once 'php-files/report.php';
// Databse connection
require_once 'assets/dbconnect.php';


// GET COMPANY INFO FROM GET VAR
$response = NULL;
$responseDetails = NULL;
$companyInfo = [];
//$projectName = "";



// if(isset($_GET['project']) && !empty($_GET['project'])) {
//     $companyCode = substr($_GET['project'], 0, 10);
//     $projectID = substr($_GET['project'], 10);
//     $companyInfo = getCompanyReportInfo($companyCode, $projectID);
//     if($companyInfo) {
//         $companyName = $companyInfo['companyName'];
//         $companyID = $companyInfo['companyID'];
//         $projectName = $companyInfo['projectName'];
//         $projectID = $companyInfo['projectID'];
//     } else {
//         $response = "There was an error fetching this company's information! Please contact the developer directly.";
//     }
// } else {
//     $response = "Broken Link! Please contact the developer directly.";
// }


//PROCESS FORM DATA

if (isset($_POST['email']) && !empty($_POST['email'])) {
    $projectName = $_POST['projectName'];
    $db = db_connect();
    $values = [$projectName];
    $query = "SELECT id FROM projectinfo WHERE projectName = ?";
    $state = $db->prepare($query);
    $state->execute($values);
    $result = $state->fetchColumn();

    $associatedprojectID = $result;

    if (addBugReport($_POST['firstName'], $_POST['lastName'], $associatedprojectID, $_POST['email'], $_POST['details'])) {
        //$projectID - goes where the  post project name is
        //send email to reporter
        // $subject = "Your recent bug submission for $companyName&#39;s project $projectName";
        $subject = "Your recent bug submission for project $projectName";
        $content = "Thank you for your bug submission. We have sent it
            to the developers, and you will be notified when there&#39;s an update.";
        sendEmail($subject, $_POST['email'], "noreply@projectbuggy.tk", $content);

        $response = "Thank you for submitting your bug.";
        $responseDetails = "A confirmation email has been sent to the email you
            provided."; // We have also forwarded this information to the lead developer at
        // $companyName. A representative from their company was given your
        // email address to inform you of the ticket progress.";
    } else {
        $response = "There was an error submitting your bug report into our database.";
    }
}

printHead("Report a bug for $projectName | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar("report", NULL); ?>
    <div class="main">
        <section id="report">
            <?php
            //IF ERROR FETCHING COMPANY INFO
            if ($response != NULL) {
                print("<h2>$response</h2>");
                if ($responseDetails != NULL)
                    print("<p>$responseDetails</p>");
            } else {
            ?>


                <div class="forms">
                    <h1>Report A Bug</h1>
                    <div id="signin">
                        <form id="signup" method="post" action="" autocomplete="off">
                            <div class="tab-content">
                                <div class="field-row">
                                    <select name="projectName" id="projectName">
                                        <?php
                                        $db = db_connect();
                                        //$values = [$projectID];
                                        $sql = "SELECT projectName FROM projectinfo";
                                        $stmt = $db->prepare($sql);
                                        $stmt->execute();
                                        $result = $stmt->fetchAll(PDO::FETCH_ASSOC);
                                        foreach ($result as $row) {
                                            print("
                            <option value='" . $row['projectName'] . "'>" . $row['projectName'] . "</option>
                            ");
                                        } ?>
                                    </select>
                                    <div class="field-wrap">
                                        <label>
                                            First Name<span class="req">*</span>
                                        </label>
                                        <input type="text" name="firstName" required>
                                    </div>
                                    <div class="field-wrap">
                                        <label>
                                            Last Name<span class="req">*</span>
                                        </label>
                                        <input type="text" name="lastName" required>
                                    </div>
                                </div>
                                <div class="field-wrap">
                                    <label>
                                        Email<span class="req">*</span>
                                    </label>
                                    <input type="email" name="email" required>
                                </div>
                                <div class="field-wrap">
                                    <label>
                                        Description of Bug<span class="req">*</span>
                                    </label>
                                    <textarea name="details" required></textarea>
                                </div>
                                <input type="submit" class="button button-block" value="Submit Bug">
                            </div>
                        </form>
                    </div>
                </div>
                </form>
        </section>
    <?php } //END ELSE STMT FOR ERROR FETCHING COMPANY INFO
    ?>

    </div>
    <script src="scripts/forms.js"></script>
    <?php printFooter("report"); ?>
</body>

</html>
