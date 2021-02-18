<?php
    REQUIRE_ONCE 'assets/functions.php';
    REQUIRE_ONCE 'php-files/signin.php';
    if(isset($_SESSION['userID']) && !empty($_SESSION['userID'])){
        header ("Location: tickets");
        exit ();
    }
    printHead("Sign In | Buggy - Let's Code Together");

    $response = "";
    if(isset($_POST['email']) && !empty($_POST['email'])) {
        if(emailExists($_POST['email'])) {
            if(checkVerified($_POST['email'])) {
                $loginInfo = checkLogin($_POST['email'], $_POST['password']);
                if($loginInfo) {
                    $_SESSION['userID'] = $loginInfo['id'];
                    $_SESSION['accountType'] = $loginInfo['accountType'];
                    if($loginInfo['accountType'] == "developer" || $loginInfo['accountType'] == "management") {
                        header ("Location: tickets");
                        exit ();
                    } else {$response = "error in account type";}
                } else {
                    $response = "You have entered in the wrong email/password combo.";
                }
            } else {
                $response = "This email has not been verified yet. Check your email for a link!";
            }
        } else {
            $response = "It looks like you don't have an account! You can sign up <a href='signup'>Here</a>";
        }
    }
?>
<body>
    <?php printSidebar("notloggedin", "signin"); ?>
    <div class="main">
        <?php print $response; ?>
        <h1>Sign in to your Buggy account</h1>
        <section>
            <form id="signup" method="post" action="">
                <input type="email" name="email" placeholder="Email">
                <input type="password" name="password" placeholder="Password">
                <input type="submit" value="Sign in">
            </form>

            <h3>Don't have an account?</h3>
            <a href="purchase" class="button">Get Buggy for your team</a>
            <h3>Does your team already have buggy?</h3>
            <a href="signup#developer" class="button">Sign Up with a Developer account</a>
        </section>
    </div>
    <?php printFooter("basic"); ?>

</body>
</html>
