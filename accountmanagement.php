<?php
require_once 'assets/functions.php';
require_once 'php-files/search.php';
printHead("Search Tickets | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "accountmanagement"); ?>

    <div class="main">
        <?php printHeader($_SESSION['userID']);
        ?>
    </div>

    <?php printFooter("basic"); ?>
</body>

</html>