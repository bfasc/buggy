<?php
require_once 'assets/functions.php';
require_once 'php-files/editCompany.php';
printHead("Manage Company | Buggy - Let's Code Together");
$companyID = getUserInfo($_SESSION['userID'], "associatedCompany");
$companyName = getCompanyInfo($companyID, "companyName");
$companyPhone = getCompanyInfo($companyID, "phoneNumber");
$companyAddress = getCompanyInfo($companyID, "streetAddress");
$companyCity = getCompanyInfo($companyID, "city");
$companyState = getCompanyInfo($companyID, "state");
$companyZip = getCompanyInfo($companyID, "zip");
$companyCountry = getCompanyInfo($companyID, "country");

$response = "";
if (isset($_POST['submit'])) {
    if (updateCompany($_POST['companyName'], $_POST['companyPhone'], $_POST['companyAddress'], $_POST['companyCity'], $_POST['companyState'], $_POST['companyZip'], $_POST['companyCountry'], $companyID)) {
        $companyID = getUserInfo($_SESSION['userID'], "associatedCompany");
        $companyName = $_POST['companyName'];
        $companyPhone = $_POST['companyPhone'];
        $companyAddress = $_POST['companyAddress'];
        $companyCity = $_POST['companyCity'];
        $companyState = $_POST['companyState'];
        $companyZip = $_POST['companyZip'];
        $companyCountry = $_POST['companyCountry'];
        $response = "You have successfully changed your company information.";
    } else $response = "Error changing company information.";
}
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "company"); ?>

    <div class="main" id="company">
        <?php printHeader($_SESSION['userID']);
        ?>
        <h2 class='subhead'>Company Management</h2 class='subhead'>
        <a href="companyreports" class="button">Generate Reports</a>
        <div class="forms" id="company-form">
            <h1>Edit Company Info</h1>
            <form action="" method="post" autocomplete="off">

                <div class="field-row">
                    <div class="field-wrap">
                        <label>
                            Company Name<span class="req">*</span>
                        </label>
                        <input type="text" required name="companyName" id="companyname" value="<?php echo $companyName; ?>" />
                    </div>
                    <div class="field-wrap">
                        <label>
                            Company Phone<span class="req">*</span>
                        </label>
                        <input type="text" required name="companyPhone" id="companyphone" value="<?php echo $companyPhone; ?>" />
                    </div>
                </div>


                <div class="field-wrap">
                    <label>
                        Company Address<span class="req">*</span>
                    </label>
                    <input type="text" required name="companyAddress" id="companyaddress" value="<?php echo $companyAddress; ?>" />
                </div>

                <div class="field-row">
                    <div class="field-wrap">
                        <label>
                            City<span class="req">*</span>
                        </label>
                        <input type="text" required name="companyCity" id="companycity" value="<?php echo $companyCity; ?>" />
                    </div>
                    <div class="field-wrap">
                        <label>
                            State/Province<span class="req">*</span>
                        </label>
                        <input type="text" required name="companyState" id="companystate" value="<?php echo $companyState; ?>" />
                    </div>
                </div>

                <div class="field-row">
                    <div class="field-wrap">
                        <label>
                            Zip Code<span class="req">*</span>
                        </label>
                        <input type="text" required name="companyZip" id="companyzip" value="<?php echo $companyZip; ?>" />
                    </div>
                    <div class="field-wrap">
                        <label>
                            Country<span class="req">*</span>
                        </label>
                        <input type="text" required name="companyCountry" id="companycountry" value="<?php echo $companyCountry; ?>" />
                    </div>
                </div>
                <input type="submit" class="button button-block" value="Edit Company" name="submit" />
            </form>
        </div>

        <div class='copylink-wrap'>
            <h3>Want to invite an employee to work with your company in Buggy projects?</h3>
            <p>Give your developer this link: </p>
            <textarea disabled id='copylink'>http://projectbuggy.tk/signup?companyCode=<?php echo getCompanyInfo(getUserInfo($_SESSION['userID'], "associatedCompany"), "companyCode"); ?></textarea>
            <a class='copy button' id='copylink'>Copy Link</a>
            <p>Or this code to enter in the signup form: </p>
            <textarea disabled id='code'><?php echo getCompanyInfo(getUserInfo($_SESSION['userID'], "associatedCompany"), "companyCode"); ?></textarea>
            <a class='copy button' id='code'>Copy Code</a>
        </div>
    </div>
    <script src="/scripts/forms.js"></script>
    <script>
        $(document).ready(function() {
            $('#companyname').prev('label').addClass('active highlight');
            $('#companyphone').prev('label').addClass('active highlight');
            $('#companyaddress').prev('label').addClass('active highlight');
            $('#companycity').prev('label').addClass('active highlight');
            $('#companystate').prev('label').addClass('active highlight');
            $('#companyzip').prev('label').addClass('active highlight');
            $('#companycountry').prev('label').addClass('active highlight');
        });

        function copy(id) {
            var copyText = document.getElementById(id);
            copyText.disabled = false;
            copyText.select();
            copyText.setSelectionRange(0, 99999);
            document.execCommand("copy");
            copyText.disabled = true;
            window.getSelection().removeAllRanges();
            if (id == 'copylink')
                alert("Copied Link");
            else
                alert("Copied Code");
        }
        $('.copy').click(function() {
            copy($(this).attr('id'));
        });

        $('#company-form').submit(function(e) {
            var name = document.getElementById('companyname').value;
            var phone = document.getElementById('companyphone').value;
            var address = document.getElementById('companyaddress').value;
            var city = document.getElementById('companycity').value;
            var state = document.getElementById('companystate').value;
            var zip = document.getElementById('companyzip').value;
            var country = document.getElementById('companycountry').value;

            if (name == "" || phone == "" || address == "" || city == "" || state == "" || zip == "" || country == "") {
                e.preventDefault();
                alert("You must fill out all of the form fields.");
            } else {
                //var phoneReg = /^(\+\d{1,2}\s)?\(?\d{3}\)?[\s.-]\d{3}[\s.-]\d{4}$/;
                var newPhoneReg = /^[0-9]{10}+$/;
                if (!phone.match(newPhoneReg)) {
                    e.preventDefault();
                    alert("You have entered an invalid value for phone number. Try using no spaces, dashes, or parentheses.");
                }
                var zipReg = /^\d{5}(?:[-\s]\d{4})?$/;
                if (!zip.match(zipReg)) {
                    e.preventDefault();
                    alert("You must enter a valid zip code.");
                }
            }
        });
    </script>
    <?php printFooter("basic"); ?>
</body>

</html>