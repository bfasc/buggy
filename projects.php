<?php
require_once 'assets/functions.php';
require_once 'php-files/projects.php';
printHead("Projects | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "projects"); ?>

    <div class="main" id="projects">

        <?php printHeader($_SESSION['userID']); ?>
        <h1>Your Projects</h1>
        <a href="createproject" class="button">Add a New Project</a>
        <?php
        $projectList = getAllProjects($_SESSION['userID']);

        if($projectList == []) print("<h2>Create your first project.</h2>");
        foreach($projectList as $projectID) {
            $projectName = getProjectInfo($projectID, "projectName");
            $projectIcon = getProjectInfo($projectID, "projectIcon");
            $category = getProjectInfo($projectID, "projectCategory");
            $status = getProjectInfo($projectID, "status");
            $companyName = getCompanyInfo(getProjectInfo($projectID, "associatedCompany"), "companyName");
            $reportCode = getCompanyInfo(getProjectInfo($projectID, "associatedCompany"), "companyCode") . $projectID;
            print("<div class='project'>");
            print("<img src='assets/img/project-icons/$projectIcon'>");
            print("<div class='info'>");
                print("<h2>$projectName</h2>");
                print("<h3>$companyName</h3>");
            print("</div>");
            print("<p>Category: $category</p><p>Status: $status</p>");
            print("<a class='button' href='report?project=$reportCode'>Report a Bug</a>");

            if(getAccountType($_SESSION['userID']) == "management") {
                print("<a class='button' href='editproject?project=$projectID'>Edit</a>");
            }
            print("</div>");
        }
        ?>
    </div>

    <?php printFooter("basic"); ?>
</body>

</html>
