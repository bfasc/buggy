<?php
    //TODO: ADD JS VALIDATION
    REQUIRE_ONCE 'assets/functions.php';
    REQUIRE_ONCE 'php-files/signin.php';
    printHead("Sign In | Buggy - Let's Code Together");

    $response = "";
    if(isset($_POST['email']) && !empty($_POST['email'])) {
        if(emailExists($_POST['email'])) {
            if(checkVerified($_POST['email'])) {
                $loginInfo = checkLogin($_POST['email'], $_POST['password']);
                if($loginInfo) {
                    if($loginInfo == "notPurchased") { //management account needs to purchase for compnay
                        $response = "You still need to purchase a Buggy Plan in order to sign in on this account. Purchase one <a href='purchase'>Here</a>!";
                    } else {
                        $_SESSION['userID'] = $loginInfo['id'];
                        $_SESSION['accountType'] = $loginInfo['accountType'];
                        if($loginInfo['accountType'] == "developer" || $loginInfo['accountType'] == "management") {
                            header ("Location: tickets");
                            exit ();
                        } else {$response = "error in account type";}
                    }

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
        <div class="forms">
            <h1>Sign In</h1>
            <p>Sign in to your Buggy account</p>
            <div id="signin">
                <form action="" method="post" autocomplete="off">
                    <div class="tab-content">
                        <div class="field-row">
                            <div class="field-wrap">
                                <label>
                                    Email<span class="req">*</span>
                                </label>
                                <input type="email" name="email">
                            </div>
                            <div class="field-wrap">
                                <label>
                                    Password<span class="req">*</span>
                                </label>
                                <input type="password" name="password">
                            </div>
                        </div>
                        <input type="submit" class="button button-block" value="Sign in">
                    </div>
                </form>
            </div>
        </div>
        <section id="signin">
            <h3>Don't have an account?</h3>
            <a href="signup#management" class="button">Get Buggy for your team</a>
            <h3>Does your team already have buggy?</h3>
            <a href="signup#developer" class="button">Sign Up with a Developer account</a>
        </section>
    </div>

    <script>
        /*Form Script*/
        $('.forms').find('input, textarea').on('keyup blur focus', function (e) {
          var $this = $(this),
              label = $this.prev('label');

        	  if (e.type === 'keyup') {
        			if ($this.val() === '') {
                  label.removeClass('active highlight');
                } else {
                  label.addClass('active highlight');
                }
            } else if (e.type === 'blur') {
            	if( $this.val() === '' ) {
            		label.removeClass('active highlight');
        			} else {
        		    label.removeClass('highlight');
        			}
            } else if (e.type === 'focus') {

              if( $this.val() === '' ) {
            		label.removeClass('highlight');
        			}
              else if( $this.val() !== '' ) {
        		    label.addClass('highlight');
        			}
            }

        });
    </script>


    <?php printFooter("basic"); ?>

</body>
</html>
