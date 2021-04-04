<?php
require_once 'assets/functions.php';
printHead("Manage Company | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "companymanagement"); ?>

    <div class="main">
        <?php printHeader($_SESSION['userID']);
        ?>
        <h2 class='subhead'>Want to invite an employee to work with your company in Buggy projects?</h2 class='subhead'>
        <p>Give your developer this link: <a>http://projectbuggy.tk/signup?companyCode=<?php echo getCompanyInfo(getUserInfo($_SESSION['userID'], "associatedCompany"), "companyCode"); ?></a> or this code: <a><?php echo getCompanyInfo(getUserInfo($_SESSION['userID'], "associatedCompany"), "companyCode"); ?></a> to fill in the signup form.</p>
        <a href="companyreports" class="button">Generate Reports</a>
    </div>

    <?php printFooter("basic"); ?>
</body>

</html>
