<?php
require_once 'assets/functions.php';
require_once 'php-files/verify.php';
printHead("Verify Your Account | Buggy - Let's Code Together");

$response = "";
if (isset($_GET['code']) && !empty($_GET['code']) && isset($_GET['email']) && !empty($_GET['email'])) {
    if (checkCode($_GET['code'], $_GET['email'])) {
        if (!checkVerified($_GET['email'])) {

            verifyAccount($_GET['email']);

            //check if management account needs purchase
            $userID = getUserID($_GET['email']);
            if (getAccountType($userID) == "management") { //management account
                if (checkPurchased($userID)) {
                    $response = "You're all set! <a href='signin'>Sign In here</a>!";
                } else {
                    $response = "Thank you for signing up! The next step is to purchase the Buggy plan for your company. You can do that <a href='purchase'>here</a>!";
                }
            } else { //developer account
                $response = "Thank you for verifying your email! <a href='signin'>Sign In here</a>!";
            }
        } else {
            $response = "You have already verified your email. <a href='signin'>Sign In here</a>!";
        }
    } else {
        $response = "Broken link! Please click the link in your email.";
    }
} else {
    $response = "Broken link! Please click the link in your email.";
}
// vs code changes checking things out
// new changes be done
?>

<body>
    <?php printSidebar("notloggedin", ""); ?>
    <div class="main">
        <h1>Verify your Buggy Account</h1>
        <section>
            <h2 class='subhead'> <?php print($response); ?> </h2 class='subhead'>
        </section>
    </div>
    <?php printFooter("basic"); ?>

</body>

</html>
