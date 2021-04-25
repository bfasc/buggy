<?php
require_once 'assets/functions.php';
require_once 'php-files/purchase.php';

printHead("Purchase Buggy | Buggy - Let's Code Together");
$response = "";
$success = FALSE;
$continue = FALSE;

if(isset($_POST['account_submit'])) {
    if(emailExists($_POST['email'])) {
        if(checkVerified($_POST['email'])) {
            $loginInfo = checkLogin($_POST['email'], $_POST['password']);
            if($loginInfo) {
                if($loginInfo == "notPurchased") { // continue to purchase
                    $continue = TRUE;
                } else {
                    $response = "You have already purchased Buggy for your company! Sign in <a href='signin'>Here</a>!";
                }
            } else {
                $response = "You have entered in the wrong email/password combo.";
            }
        } else {
            $response = "This email has not been verified yet. Check your email for a link!";
        }
    } else {
        $response = "It looks like you don't have an account! Click on the 'No Account' tab to purchase Buggy.";
    }
}
if(isset($_POST['continue_submit'])) {
    if(purchaseBuggy($_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['creditcard'])) {
        $response = "You may now sign in to get started with Buggy. Sign in <a href='signin'>Here</a>!";
        $success = TRUE;
    }
    else $response = "There was an error purchasing Buggy for your account.";
}
?>

<body>
    <?php printSidebar("notloggedin", "purchase"); ?>
    <div class="main">
        <?php if($response) print("<p class='error-response'>$response</p>");
            if($success) {
                ?>
                <h1>Thank you for your purchase!</h1>
                <p>We're glad you chose Buggy for your bug-tracking system. Sign in <a href='signin'>Here</a> to create your first project and start working!</p>

                <?php
            } // end if success
            else {
            ?>
        <div class="forms">
            <ul class="tab-group">
                <li class="tab active"><a href="#account">Already Signed Up?</a></li>
                <li class="tab"><a href="#noAccount">No Account?</a></li>
            </ul>

            <div class="tab-content">
                <div id="account">
                    <?php if($continue) { ?>
                        <h1>Purchase Buggy</h1>
                        <p>Fill out the form below to purchase Buggy for your company.</p>

                        <form action="" method="post" autocomplete="off">

                            <div class="field-row">
                                <div class="field-wrap">
                                    <label>
                                        First Name<span class="req">*</span>
                                    </label>
                                    <input type="text" required name="firstName"/>
                                </div>
                                <div class="field-wrap">
                                    <label>
                                        Last Name<span class="req">*</span>
                                    </label>
                                    <input type="text"required name="lastName"/>
                                </div>
                            </div>

                            <div class="field-wrap">
                                <label>
                                    Credit Card Number<span class="req">*</span>
                                </label>
                                <input type="text" required name="creditcard"/>
                            </div>
                            <input type="hidden" name="email" value = "<?php echo $_POST['email']; ?>">
                            <input type="submit" class="button button-block" value="Purchase" name="continue_submit"/>
                        </form>
                    <?php
                    } else { ?>
                    <h1>Already Signed Up?</h1>
                    <p>If you've already created a Management account for Buggy,
                        and you've verified your email, enter in your email and
                        password below so we can associate your purchase with
                        your account.</p>

                    <form action="" method="post" autocomplete="off">

                        <div class="field-row">
                            <div class="field-wrap">
                                <label>
                                    Email Address<span class="req">*</span>
                                </label>
                                <input type="email"required name="email"/>
                            </div>
                            <div class="field-wrap">
                                <label>
                                    Password<span class="req">*</span>
                                </label>
                                <input type="password" required name="password"/>
                            </div>
                        </div>
                        <input type="submit" class="button button-block" value="Continue" name="account_submit"/>
                    </form>
                <?php } ?>
                </div>

                <div id="noAccount">
                    <h1>No Account? No problem.</h1>
                    <p>Sign up for a Management Account, verify your email, and come back to this page to purchase Buggy for your company.</p>
                    <a href='signup#management' class='button block'>Sign Up</a>
                </div>

            </div><!-- tab-content -->
        <?php } //end else success ?>
        </div> <!-- /form -->
    </div> <!-- /main -->

    <script src="scripts/forms.js"></script>
    <script>
        /* Panel Script*/
        $('.tab a').on('click', function (e) {
            $('form').trigger("reset");
            $('.active').removeClass('active');
            $('.highlight').removeClass('highlight');
          e.preventDefault();

          $(this).parent().addClass('active');
          $(this).parent().siblings().removeClass('active');

          target = $(this).attr('href');

          $('.tab-content > div').not(target).hide();

          $(target).fadeIn(600);
        });
    </script>
    <?php printFooter("basic"); ?>
</body>

</html>
