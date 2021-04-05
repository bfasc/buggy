<?php
require_once 'assets/functions.php';
require_once 'php-files/companyreports.php';
printHead("Company Reports | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "company"); ?>
    <div class="main">
        <?php printHeader($_SESSION['userID']); ?>
        <h1 class="reports">Company Reports for <?php print(getCompanyInfo(getUserInfo($_SESSION['userID'], "associatedCompany"), "companyName")); ?></h1>

        <table class="reports">
            <tr>
                <th></th>
        <?php
        $totalProjects = 0;
        $data = [];
        $projectArray = [];
        $companyID = getUserInfo($_SESSION['userID'], "associatedCompany");
        $projects = getAllProjects($_SESSION['userID']);
        foreach ($projects as $element) {
            $data[$totalProjects]["projectID"] = $element;
            $data[$totalProjects]["totalTickets"] = getTotalTickets($element);
            $data[$totalProjects]["openTickets"] = getTotalOpenTickets($element);
            $data[$totalProjects]["unapprovedTickets"] = getTotalUnapprovedTickets($element);
            $data[$totalProjects]["completedTickets"] = getTotalCompletedTickets($element);
            $data[$totalProjects]["employees"] = getEmployeeCount($element);
            ++$totalProjects;
        }
        print("<h2 class='subhead'>Total Projects: $totalProjects</h2 class='subhead'>");

        foreach($data as $project) {
            print("<th>" . getProjectInfo($project["projectID"], "projectName") . "</th>");
        }
        print("</tr>
        <tr>
            <td class='descriptor'>Total Tickets</td>
        ");

        foreach($data as $project) {
            print("<td>" . $project["totalTickets"] . "</td>");
        }
        print("</tr>
        <tr>
            <td class='descriptor'>Open Tickets</td>
        ");

        foreach($data as $project) {
            print("<td>" . $project["openTickets"] . "</td>");
        }
        print("</tr>
        <tr>
            <td class='descriptor'>Unapproved Bug Reports</td>
        ");

        foreach($data as $project) {
            print("<td>" . $project["unapprovedTickets"] . "</td>");
        }
        print("</tr>
        <tr>
            <td class='descriptor'>Completed Tickets</td>
        ");

        foreach($data as $project) {
            print("<td>" . $project["completedTickets"] . "</td>");
        }
        print("</tr>
        <tr>
            <td class='descriptor'>Employees</td>
        ");

        foreach($data as $project) {
            print("<td>" . $project["employees"] . "</td>");
        }

        print("</tr>");
        ?>
        </table>
    </div>

<?php printFooter("basic"); ?>

</body>
</html>
