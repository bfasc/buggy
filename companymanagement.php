<?php
require_once 'assets/functions.php';
require_once 'php-files/search.php';
printHead("Manage Company | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "companymanagement"); ?>

    <div class="main">
        <?php printHeader($_SESSION['userID']);
        ?>
        <a href="companyreports" class="button">Generate Reports</a>
    </div>

    <?php printFooter("basic"); ?>
</body>

</html>
