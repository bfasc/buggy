<?php
    REQUIRE_ONCE 'assets/functions.php';
    printHead("Company Reports | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "companymanagement"); ?>
    <div class="main">
        <?php printHeader($_SESSION['userID']); ?>
        <h1 class="reports">Management Reports for <?php print(getCompanyInfo(getUserInfo($_SESSION['userID'], "associatedCompany"), "companyName")); ?></h1>
        <table class="reports">
            <tr>
                <th></th>
                <th>Project 1</th>
                <th>Project 2</th>
                <th>Project 3</th>
            </tr>
            <tr>
                <td class="descriptor">Total Tickets</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
            </tr>
            <tr>
                <td class="descriptor">Open Tickets</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
            </tr>
            <tr>
                <td class="descriptor">Closed Tickets</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
            </tr>
            <tr>
                <td class="descriptor">Unapproved Bug Reports</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
            </tr>
            <tr>
                <td class="descriptor">Employees</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
                <td>PLACE#</td>
            </tr>
        </table>
    </div>

<?php printFooter("basic"); ?>

</body>
</html>
