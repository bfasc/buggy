<?php
    //TODO: ADD JS VALIDATION
    REQUIRE_ONCE 'assets/functions.php';
    REQUIRE_ONCE 'php-files/resetpassword.php';
    printHead("Reset Password | Buggy - Let's Code Together");

    $response = "";
    $email = $_POST['email'];

    if(isset($_POST['password']) && !empty($_POST['password'])) {
        if(resetPassword($email, $_POST['password'])){
            $response = "You have successfully changed your password. <a href='signin'>Sign in</a> here!";
        }
    }
?>
<body>
    <?php printSidebar("notloggedin", "signin"); ?>
    <div class="main">
        <?php if($response != "") print "<p class='error-response'>$response</p>"; ?>
        <div class="forms">
            <h1>Password Reset</h1>
            <p>Reset Your Password</p>
            <div id="signin">
                <form action="" method="post" autocomplete="off">
                    <div class="tab-content">
                        <div class="field-row">
                            <div class="field-wrap">
                                <label>
                                    Password<span class="req">*</span>
                                </label>
                                <input type="password" name="password">
                            </div>
                            <div class="field-wrap">
                                <label>
                                    Repeat Password<span class="req">*</span>
                                </label>
                                <input type="password" name="passwordcheck">
                            </div>
                        </div>
                        <input type="hidden" value="<?php echo $_POST['email']; ?>" name="email">
                        <input type="submit" class="button button-block" value="Sign in">
                    </div>
                </form>
            </div>
        </div>
    </div>

    <script src="scripts/forms.js"></script>


    <?php printFooter("basic"); ?>

</body>
</html>
