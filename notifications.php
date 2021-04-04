<?php
require_once 'assets/functions.php';
require_once 'php-files/notifications.php';
printHead("Notifications | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "notifications"); ?>

    <div class="main">
        <?php listNotifications($_SESSION['userID']); ?>
    </div>

    <?php printFooter("basic"); ?>
</body>

</html>
