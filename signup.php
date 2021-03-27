<?php

    //TODO: ADD JS VALIDATION
    REQUIRE_ONCE 'assets/functions.php';
    REQUIRE_ONCE 'php-files/signup.php';
    printHead("Sign Up | Buggy - Let's Code Together");

    $companyCode = "";
    $response = "";
    $success = FALSE;
    if(isset($_GET['companyCode']) && !empty($_GET['companyCode']))
        $companyCode = $_GET['companyCode'];

    //form submitted for developer account
    if(isset($_POST['developer_submit'])){
        if(getCompanyID($_POST['companyCode'])) {
            if(!emailExists($_POST['email'])) {
                if (createDevUser($_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['password'], $_POST['companyCode'])){
                    $success = TRUE;

                } else {
                    $response = "There was an error creating your account.";
                }
            } else {
                $response = "There is already an account associated with that email. <a href='signin'>Sign In Here</a>";
            }
        } else {
            $response = "The company code you entered is invalid.";
        }
    }

    if(isset($_POST['company_submit'])) {
        if(!emailExists($_POST['email'])) {
            if(createManUser($_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['password'], $_POST['companyName'], $_POST['companyPhone'], $_POST['companyAddress'], $_POST['companyCity'], $_POST['companyState'], $_POST['companyCountry'], $_POST['companyZip'])) {
                $success = TRUE;
            } else {
                $response = "There was an error creating your Management account.";
            }
        } else {
            $response = "There is already an account associated with that email. <a href='signin'>Sign In Here</a>";
        }
    }
?>

<body>
    <?php printSidebar("notloggedin", "signup"); ?>
    <div class="main">
        <?php if($response) print("<h1>$response</h1>");
        else {
            if($success) {
                ?>
                <h1>Thank you for creating your account!</h1>
                <p>An email has been sent to you with a verification link for you to click. Once you click
                    on that link, you will be able to log in to your Buggy account.</p>

                <?php
            } // end if success
            else {
            ?>
        <div class="forms">
            <?php
                if(isset($_POST['management_submit'])) {
                    ?>
                    <h1>Add Company Info</h1>
                    <p>Tell us a little bit about your company.</p>
                    <div id="company">
                        <form action="" method="post" autocomplete="off">

                            <!-- Add hidden inputs for previous POST vars -->
                            <input type="hidden" name="email" value="<?php print($_POST['email']); ?>">
                            <input type="hidden" name="firstName" value="<?php print($_POST['firstName']); ?>">
                            <input type="hidden" name="lastName" value="<?php print($_POST['lastName']); ?>">
                            <input type="hidden" name="password" value="<?php print($_POST['password']); ?>">
                            <div class="tab-content">
                                <div class="field-row">
                                    <div class="field-wrap">
                                        <label>
                                            Company Name<span class="req">*</span>
                                        </label>
                                        <input type="text"required name="companyName"/>
                                    </div>
                                    <div class="field-wrap">
                                        <label>
                                            Company Phone<span class="req">*</span>
                                        </label>
                                        <input type="text"required name="companyPhone"/>
                                    </div>
                                </div>


                                <div class="field-wrap">
                                    <label>
                                        Company Address<span class="req">*</span>
                                    </label>
                                    <input type="text"required name="companyAddress"/>
                                </div>

                                <div class="field-row">
                                    <div class="field-wrap">
                                        <label>
                                            City<span class="req">*</span>
                                        </label>
                                        <input type="text"required name="companyCity"/>
                                    </div>
                                    <div class="field-wrap">
                                        <label>
                                            State/Province<span class="req">*</span>
                                        </label>
                                        <input type="text"required name="companyState"/>
                                    </div>
                                </div>

                                <div class="field-row">
                                    <div class="field-wrap">
                                        <label>
                                            Zip Code<span class="req">*</span>
                                        </label>
                                        <input type="text"required name="companyZip"/>
                                    </div>
                                    <div class="field-wrap">
                                        <label>
                                            Country<span class="req">*</span>
                                        </label>
                                        <input type="text"required name="companyCountry"/>
                                    </div>
                                </div>

                                <input type="submit" class="button button-block" value="Continue" name="company_submit"/>
                            </div>
                        </form>
                    </div>
                    <?php
                } else { //end if isset management_submit
                    ?>
            <ul class="tab-group">
                <li class="tab active"><a href="#developer">Developer Account</a></li>
                <li class="tab"><a href="#management">Management Account</a></li>
            </ul>

            <div class="tab-content">
                <div id="developer">
                    <h1>Create a Developer account</h1>
                    <p>Create a Developer account to work with your team on their Buggy projects</p>

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
                        <div class="field-row">
                            <div class="field-wrap">
                                <label>
                                    Company Code<span class="req">*</span>
                                </label>
                                <input type="text" required name="companyCode" id="companyCode"/>
                            </div>
                            <div class="field-wrap">
                                <label>
                                    Email Address<span class="req">*</span>
                                </label>
                                <input type="email"required name="email"/>
                            </div>
                        </div>

                        <div class="field-row">
                            <div class="field-wrap">
                                <label>
                                    Password<span class="req">*</span>
                                </label>
                                <input type="password" required name="password"/>
                            </div>
                            <div class="field-wrap">
                                <label>
                                    Repeat Password<span class="req">*</span>
                                </label>
                                <input type="password"required name="repeatPassword"/>
                            </div>
                        </div>
                        <input type="submit" class="button button-block" value="Create Account" name="developer_submit"/>
                    </form>
                </div>

                <div id="management">
                    <h1>Create Management Account</h1>
                    <p>Create your Management Account to get started with Buggy</p>
                    <form action="" method="post">

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
                                Email Address<span class="req">*</span>
                            </label>
                            <input type="email" required name="email"/>
                        </div>

                        <div class="field-row">
                            <div class="field-wrap">
                                <label>
                                    Password<span class="req">*</span>
                                </label>
                                <input type="password" required name="password"/>
                            </div>
                            <div class="field-wrap">
                                <label>
                                    Repeat Password<span class="req">*</span>
                                </label>
                                <input type="password"required name="repeatPassword"/>
                            </div>
                        </div>
                        <input type="submit" class="button button-block" value="Continue" name="management_submit"/>
                    </form>
                </div>

            </div><!-- tab-content -->
            <?php } //end else in management_submit set?>
        </div> <!-- /form -->


    <script src="scripts/forms.js"></script>
    <script>
        /*Developer/Management Account Panel Script*/
        $(document).ready(function(){
            var companyCode = "<?php print $companyCode; ?>";
            if(companyCode != ""){
                $('#companyCode').val(companyCode);
                $('#companyCode').prev('label').addClass('active');
            }

            //if management is selected
            if(window.location.hash == "#management") {
                $('.tab').removeClass('active');
                $('.tab a[href*="#management"]').parent().addClass('active');
                $('#developer').hide();
                $('#management').show();
            }
        });

        $('.tab a').on('click', function (e) {
            $('form').trigger("reset");
            $('.active').removeClass('active');
            $('.highlight').removeClass('highlight');

            var companyCode = "<?php print $companyCode; ?>";
            if(companyCode != ""){
                $('#companyCode').val(companyCode);
                $('#companyCode').prev('label').addClass('active');
            }

          e.preventDefault();

          $(this).parent().addClass('active');
          $(this).parent().siblings().removeClass('active');

          target = $(this).attr('href');

          $('.tab-content > div').not(target).hide();

          $(target).fadeIn(600);

        });
    </script>

    <?php
        } // end else success
    } //end else if response
    printFooter("basic"); ?>

</body>
</html>
