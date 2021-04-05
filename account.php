<?php
require_once 'assets/functions.php';
printHead("Manage Account | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "account"); ?>

    <div class="main">
        <?php printHeader($_SESSION['userID']);
        ?>
    </div>

    <?php printFooter("basic"); ?>
</body>

</html>
