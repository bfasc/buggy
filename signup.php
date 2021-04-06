<?php
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
            if(createManUser($_POST['email'], $_POST['firstName'], $_POST['lastName'], $_POST['password'], $_POST['companyName'], $_POST['companyPhone'], $_POST['companyAddress'], $_POST['companyCity'], $_POST['companyState'], $_POST['companyCountry'], $_POST['companyZip']))
                $success = TRUE;
            else
                $response = "There was an error creating your Management account.";
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
                        <form action="" method="post" autocomplete="off" id='company-form'>

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
                                        <input type="text"required name="companyName" id="companyname"/>
                                    </div>
                                    <div class="field-wrap">
                                        <label>
                                            Company Phone<span class="req">*</span>
                                        </label>
                                        <input type="text"required name="companyPhone" id="companyphone"/>
                                    </div>
                                </div>


                                <div class="field-wrap">
                                    <label>
                                        Company Address<span class="req">*</span>
                                    </label>
                                    <input type="text"required name="companyAddress" id="companyaddress"/>
                                </div>

                                <div class="field-row">
                                    <div class="field-wrap">
                                        <label>
                                            City<span class="req">*</span>
                                        </label>
                                        <input type="text"required name="companyCity" id="companycity"/>
                                    </div>
                                    <div class="field-wrap">
                                        <label>
                                            State/Province<span class="req">*</span>
                                        </label>
                                        <input type="text"required name="companyState" id="companystate"/>
                                    </div>
                                </div>

                                <div class="field-row">
                                    <div class="field-wrap">
                                        <label>
                                            Zip Code<span class="req">*</span>
                                        </label>
                                        <input type="text"required name="companyZip" id="companyzip"/>
                                    </div>
                                    <div class="field-wrap">
                                        <label>
                                            Country<span class="req">*</span>
                                        </label>
                                        <input type="text"required name="companyCountry" id="companycountry"/>
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

                    <form action="" method="post" autocomplete="off" id='developer-form'>

                        <div class="field-row">
                            <div class="field-wrap">
                                <label>
                                    First Name<span class="req">*</span>
                                </label>
                                <input type="text" required name="firstName" id="dev-fname"/>
                            </div>

                            <div class="field-wrap">
                                <label>
                                    Last Name<span class="req">*</span>
                                </label>
                                <input type="text"required name="lastName" id="dev-lname"/>
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
                                <input type="email"required name="email" id="dev-email"/>
                            </div>
                        </div>

                        <div class="field-row">
                            <div class="field-wrap">
                                <label>
                                    Password<span class="req">*</span>
                                </label>
                                <input type="password" required name="password" id="dev-password1"/>
                            </div>
                            <div class="field-wrap">
                                <label>
                                    Repeat Password<span class="req">*</span>
                                </label>
                                <input type="password"required name="repeatPassword" id="dev-password2"/>
                            </div>
                        </div>
                        <input type="submit" class="button button-block" value="Create Account" name="developer_submit"/>
                    </form>
                </div>

                <div id="management">
                    <h1>Create Management Account</h1>
                    <p>Create your Management Account to get started with Buggy</p>
                    <form action="" method="post" id='management-form'>

                        <div class="field-row">
                            <div class="field-wrap">
                                <label>
                                    First Name<span class="req">*</span>
                                </label>
                                <input type="text" required name="firstName" id="man-fname"/>
                            </div>
                            <div class="field-wrap">
                                <label>
                                    Last Name<span class="req">*</span>
                                </label>
                                <input type="text"required name="lastName" id="man-lname"/>
                            </div>
                        </div>

                        <div class="field-wrap">
                            <label>
                                Email Address<span class="req">*</span>
                            </label>
                            <input type="email" required name="email" id="man-email"/>
                        </div>

                        <div class="field-row">
                            <div class="field-wrap">
                                <label>
                                    Password<span class="req">*</span>
                                </label>
                                <input type="password" required name="password" id="man-password1"/>
                            </div>
                            <div class="field-wrap">
                                <label>
                                    Repeat Password<span class="req">*</span>
                                </label>
                                <input type="password"required name="repeatPassword" id="man-password2"/>
                            </div>
                        </div>
                        <input type="submit" class="button button-block" value="Continue" name="management_submit"/>
                    </form>
                </div>

            </div><!-- tab-content -->
            <?php } //end else in management_submit set?>
        </div> <!-- /form -->
    </div>

    <script src="scripts/forms.js"></script>
    <div class='customAlertWrap'>
        <div class='customAlert'>
            <p class='message'></p>
            <input type='button' class='confirmButton' value='OK'>
        </div>
    </div>
    <script src='scripts/alerts.js'></script>
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


        $('#developer-form').submit(function(e){
            var fname = document.getElementById('dev-fname').value;
            var lname = document.getElementById('dev-lname').value;
            var email = document.getElementById('dev-email').value;
            var companyCode = document.getElementById('companyCode').value;
            var pass1 = document.getElementById('dev-password1').value;
            var pass2 = document.getElementById('dev-password2').value;
            var response = "";

            if(fname == "" || lname == "" || email == ""  || companyCode == "" || pass1 == "" || pass2 == "") {
                e.preventDefault();
                response = "You must fill out all of the form fields.";
            } else {
                var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/;
                if(!pass1.match(passw)) {
                    e.preventDefault();
                    response = "Your password must be at least 8 characters long and contain at least one number, one uppercase, and one lowercase letter.";
                } else {
                    if(pass1 != pass2){
                        e.preventDefault();
                        response = "Passwords do not match.";
                    }
                }
            }
            if(response != "") alert(response);
        });

        $('#management-form').submit(function(e){
            var fname = document.getElementById('man-fname').value;
            var lname = document.getElementById('man-lname').value;
            var email = document.getElementById('man-email').value;
            var pass1 = document.getElementById('man-password1').value;
            var pass2 = document.getElementById('man-password2').value;
            var response = "";

            if(fname == "" || lname == "" || email == ""  || pass1 == "" || pass2 == "") {
                e.preventDefault();
                response = "You must fill out all of the form fields.";
            } else {
                var passw = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z]).{8,20}$/;
                if(!pass1.match(passw)) {
                    e.preventDefault();
                    response = "Your password must be at least 8 characters long and contain at least one number, one uppercase, and one lowercase letter.";
                } else {
                    if(pass1 != pass2){
                        e.preventDefault();
                        response = "Passwords do not match.";
                    }
                }
            }
            if(response != "") alert(response);
        });

        $('#company-form').submit(function(e){
            var name = document.getElementById('companyname').value;
            var phone = document.getElementById('companyphone').value;
            var address = document.getElementById('companyaddress').value;
            var city = document.getElementById('companycity').value;
            var state = document.getElementById('companystate').value;
            var zip = document.getElementById('companyzip').value;
            var country = document.getElementById('companycountry').value;
            var response = "";

            if(name == "" || phone == "" || address == ""  || city == "" || state == "" || zip == "" || country == "") {
                e.preventDefault();
                response = "You must fill out all of the form fields.";
            } else {
                var phoneReg = /^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/;
                if(!phone.match(phoneReg)) {
                    e.preventDefault();
                    response = "You have entered an invalid value for phone number. Try using no spaces, dashes, or parentheses.";
                }
                var zipReg = /^\d{5}(?:[-\s]\d{4})?$/;
                if(!zip.match(zipReg)) {
                    e.preventDefault();
                    response = "You must enter an integer for your zip code.";
                }
            }
            if(response != "") alert(response);
        });


    </script>

    <?php
        } // end else success
    } //end else if response
    printFooter("basic"); ?>

</body>
</html>
