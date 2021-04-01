<?php
require_once 'assets/functions.php';
printHead("Manage Employees | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "employeemanagement"); ?>

    <div class="main">
        <?php printHeader($_SESSION['userID']);
        ?>
    </div>

    <?php printFooter("basic"); ?>
</body>

</html>
