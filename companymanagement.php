<?php
require_once 'assets/functions.php';
printHead("Manage Company | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "companymanagement"); ?>

    <div class="main" id="company">
        <?php printHeader($_SESSION['userID']);
        ?>
        <h2 class='subhead'>Company Management</h2 class='subhead'>
        <a href="companyreports" class="button">Generate Reports</a>

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

    <script>
    function copy(id) {
        var copyText = document.getElementById(id);
        copyText.disabled = false;
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        copyText.disabled = true;
        window.getSelection().removeAllRanges();
        if(id == 'copylink')
            alert("Copied Link");
        else
            alert("Copied Code");
    }
    $('.copy').click(function(){
        copy($(this).attr('id'));
    });

    </script>
    <?php printFooter("basic"); ?>
</body>

</html>
