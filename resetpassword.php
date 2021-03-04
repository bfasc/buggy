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
        <?php print $response; ?>
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
