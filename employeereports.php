<?php
    REQUIRE_ONCE 'assets/functions.php';
    printHead("Employee Reports | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "employees"); ?>
    <div class="main">
        <?php printHeader($_SESSION['userID']); ?>
        <h1 class="reports">Employee Reports for <?php print(getCompanyInfo(getUserInfo($_SESSION['userID'], "associatedCompany"), "companyName")); ?></h1>
        <table class="reports">
            <tr>
                <th></th>
                <th>Employee 1</th>
                <th>Employee 2</th>
                <th>Employee 3</th>
            </tr>
            <tr>
                <td class="descriptor">Assigned Tickets</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
            </tr>
            <tr>
                <td class="descriptor">Not Started Tickets</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
            </tr>
            <tr>
                <td class="descriptor">In Progress Tickets</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
            </tr>
            <tr>
                <td class="descriptor">Completed Tickets</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
            </tr>
            <tr>
                <td class="descriptor">Assigned Projects</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
            </tr>
        </table>
    </div>

<?php printFooter("basic"); ?>

</body>
</html>
