<?php
require_once 'assets/functions.php';
require_once 'php-files/projects.php';
printHead("Projects | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "projects"); ?>

    <div class="main" id="projects">

        <?php printHeader($_SESSION['userID']); ?>
        <h2 class='subhead'>Your Projects</h2>
        <?php if(getUserInfo($_SESSION['userID'], "accountType") == "management") print("<a href=\"createproject\" class=\"button\">Add a New Project</a>"); ?>
        <?php
        $projectList = getAllProjects($_SESSION['userID']);
        if($projectList == []) {
            print("<h2 class='subhead'>You currently have no assigned projects.</h2 class='subhead'>");
            if(getUserInfo($_SESSION['userID'], "accountType") == "management") print("<h2 class='subhead'>Create your first project.</h2 class='subhead'>");
        }
        foreach($projectList as $projectID) {
            $projectName = getProjectInfo($projectID, "projectName");
            $projectIcon = getProjectInfo($projectID, "projectIcon");
            $category = getProjectInfo($projectID, "projectCategory");
            $status = getProjectInfo($projectID, "status");
            $priority = getProjectInfo($projectID, "priority");
            $companyName = getCompanyInfo(getProjectInfo($projectID, "associatedCompany"), "companyName");
            $reportCode = getProjectInfo($projectID,"customLink");
            print("<div class='project'>");
            print("<img src='assets/img/project-icons/$projectIcon'>");
            print("<div class='info'>");
                print("<h2 class='subhead'>PROJECT: $projectName</h2 class='subhead'>");
                print("<h3>COMPANY: $companyName</h3>");
            //priority string
            $priorityString = "";
            for($i = 0; $i < 5; $i++){
                $priorityString .= "<i class='fas fa-exclamation fa-fw";
                if($i < $priority) {
                    $priorityString .= " highlight";
                }
                $priorityString .= "'></i>";
            }
            print("<p>Category: $category</p><p>Status: $status</p><p>Priority: $priorityString</p>");
            print("</div>"); //end info

            print("<div class='button-wrap'>");
            print("<a class='button' href='report?project=$reportCode'>Report a Bug</a>");

            if(getAccountType($_SESSION['userID']) == "management") {
                print("<a class='button' href='editproject?project=$projectID'>Edit</a>");
            }
            print("</div>"); //end button wrap


            print("<div id='reportLink-wrap'>
                <p>Give your users this link to report bugs they find in your project:
                    <textarea disabled id='reportLink-$projectID'>http://www.projectbuggy.tk/report?project=$reportCode</textarea>
                    <a class='copyLink button' id='report-$projectID'>Copy Link</a>
                </p>
            </div>");
            print("</div>");
        }
        ?>
    </div>
    <script>
    function copyLink(id) {
        var copyText = document.getElementById("reportLink-"+id);
        copyText.disabled = false;
        copyText.select();
        copyText.setSelectionRange(0, 99999);
        document.execCommand("copy");
        copyText.disabled = true;
        window.getSelection().removeAllRanges();
        alert("Copied Link");
    }
    $('.copyLink').click(function(){
        copyLink($(this).attr('id').substring(7, $(this).attr('id').length));
    });

    </script>

    <?php printFooter("basic"); ?>
</body>

</html>
