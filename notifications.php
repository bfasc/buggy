<?php
require_once 'assets/functions.php';
require_once 'php-files/notifications.php';
printHead("Notifications | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "notifications"); ?>

    <div class="main">
        <?php printHeader($_SESSION['userID']); ?>
        <h2 class='subhead'>Your Notifications</h2>
        <?php listNotifications($_SESSION['userID']); ?>
    </div>

    <script>
    function readNotif(id, link) {
        $.ajax({
            url: 'scripts/readNotif.php',
            type: 'post',
            dataType: 'JSON',
            data: {"id": id},
            success: function(response) {
                if(link === undefined)
                    window.location.href = "";
                else
                    window.location.href = link;
            }
        });
    }
    $('.read').click(function(e){
        e.preventDefault();
        readNotif($(this).attr('id'), $(this).attr('href'));
    });


    </script>

    <?php printFooter("basic"); ?>
</body>

</html>
