<?php
    REQUIRE_ONCE 'assets/functions.php';
    REQUIRE_ONCE 'php-files/tickets.php';
    printHead("View Your Tickets | Buggy - Let's Code Together");
?>
<body>
        <?php printSidebar(getAccountType($_SESSION['userID']), "tickets"); ?>
        <div class="main">
            <?php printHeader($_SESSION['userID']);
            if(getAccountType($_SESSION['userID']) == "management" && getAllProjects($_SESSION['userID']) == []) {
                print("<h2>You need to create a Project to get started.</h2>
                <a href='createproject' class='button'>Create Your First Project</a>
                ");
            }
            ?>

            <h1>In Progress</h1>
            

            <h1>New Tickets</h1>

        </div>
        <?php printFooter("basic"); ?>
</body>
</html>
