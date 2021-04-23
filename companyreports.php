<?php
require_once 'assets/functions.php';
require_once 'php-files/companyreports.php';
printHead("Company Reports | Buggy - Let's Code Together");
if(isset($_POST['projectID']) && !empty($_POST['projectID'])) {
    $projectID = $_POST['projectID'];
    $totalTickets = getTotalTickets($projectID);
    $totalOpenTickets = (getTotalOpenTickets($projectID) / $totalTickets) * 100;
    $totalUnapprovedTickets = (getTotalUnapprovedTickets($projectID) / $totalTickets);
    $totalCompletedTickets = (getTotalCompletedTickets($projectID) / $totalTickets) * 100;
    $totalEmployees = getEmployeeCount($projectID);
}
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "company"); ?>
    <div class="main">
        <?php printHeader($_SESSION['userID']); ?>
        <h1 class="reports">Company Reports for <?php print(getCompanyInfo(getUserInfo($_SESSION['userID'], "associatedCompany"), "companyName")); ?></h1>
        <?php
        $totalProjects = 0;
        $companyID = getUserInfo($_SESSION['userID'], "associatedCompany");
        $projects = getAllProjects($_SESSION['userID']);
        foreach ($projects as $element) {
            ++$totalProjects;
        }
        print("<h2 class='subhead reports'>Total Projects: $totalProjects
        <form action='' method='post'>
        <select name='projectID'>");
        foreach($projects as $project) {
            $thisProjectID = $project;
            $projectName = getProjectInfo($thisProjectID, "projectName");
            print("<option value='$thisProjectID'>$projectName</option>");
        }
        print("</select>
        <input type='submit' value='Show Reports'>
        </form>

        </h2 class='subhead'>");


        if(isset($_POST['projectID']) && !empty($_POST['projectID'])) {
            print("<table class='reports'>");
            print("<tr>");
            print("<th>$projectName</th>");
            print("<th></th>");
            print("</tr><tr>");
            print("<td class='descriptor'>Total Tickets</td>");
            print("<td>$totalTickets</td>");
            print("</tr><tr>");
            print("<td class='descriptor'>Open Tickets</td>");
            print("<td>$totalOpenTickets%</td>");
            print("</tr><tr>");
            print("<td class='descriptor'>Unapproved Bug Reports</td>");
            print("<td>$totalUnapprovedTickets</td>");
            print("</tr><tr>");
            print("<td class='descriptor'>Completed Tickets</td>");
            print("<td>$totalCompletedTickets%</td>");
            print("</tr><tr>");
            print("<td class='descriptor'>Employees</td>");
            print("<td>$totalEmployees</td>");
            print("</tr>");
            print("</table>");
        }
        ?>

    </div>

<?php printFooter("basic"); ?>

</body>
</html>
