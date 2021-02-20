<?php
    //TODO: ADD JS VALIDATION
    REQUIRE_ONCE 'assets/functions.php';
    REQUIRE_ONCE 'php-files/report.php';

    // GET COMPANY INFO FROM GET VAR
    $response = NULL;
    $responseDetails = NULL;
    $companyInfo = [];

    if(isset($_GET['company']) && !empty($_GET['company'])) {
        $companyInfo = getCompanyInfo($_GET['company']);
        if($companyInfo != []) {
            $companyName = $companyInfo['companyName'];
            $companyID = $companyInfo['companyID'];
            $projectName = $companyInfo['projectName'];
            $projectID = $companyInfo['projectID'];
        } else {
            $response = "There was an error fetching this company's information! Please contact the developer directly.";
        }
    } else {
        $response = "Broken Link! Please contact the developer directly.";
    }


    //PROCESS FORM DATA

    if(isset($_POST['email']) && !empty($_POST['email'])) {
        if(addBugReport($_POST['firstName'], $_POST['lastName'], $projectID, $_POST['email'], $_POST['details'])) {

            //send email to reporter
            $subject = "Your recent bug submission for $companyName's project $projectName";
            $content = "<p>Thank you for your bug submission. We have sent it
            to the developers, and you will be notified when there's an update.</p>";
            sendEmail($subject, $_POST['email'], "project-buggy@trustifi.com", $content);

            $response = "Thank you for submitting your bug.";
            $responseDetails = "A confirmation email has been sent to the email you
            provided. We have also forwarded this information to the lead developer at
            $companyName. A representative from their company was given your
            email address to inform you of the ticket progress.";
        } else {
            $response = "There was an error submitting your bug report into our database.";
        }
    }

    printHead("Report a bug for $projectName | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar("report", NULL); ?>
    <div class="main">
        <section id="developer">
            <?php
                //IF ERROR FETCHING COMPANY INFO
                if($response != NULL) {
                    print("<h2>$response</h2>");
                    if($responseDetails != NULL)
                        print("<p>$responseDetails</p>");
                }
                else {
            ?>
            <h2>Report a bug for <?php print $projectName; ?></h2>
            <form id="signup" method="post" action="">
                <input type="text" name="firstName" placeholder="First Name" required>
                <input type="text" name="lastName" placeholder="Last Name" required>
                <input type="email" name="email" placeholder="Email" required>
                <textarea name="details" required>Description of Bug</textarea>
                <input type="submit" value="Submit Bug">
            </form>
        </section>
        <?php } //END ELSE STMT FOR ERROR FETCHING COMPANY INFO ?>

    </div>
    <?php printFooter("report"); ?>
</body>
</html>
