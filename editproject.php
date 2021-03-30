<?php
require_once 'assets/functions.php';
require_once 'php-files/editproject.php';
printHead("Edit a Project | Buggy - Let's Code Together");

if(isset($_GET['project'])) {
    $projectID = $_GET['project'];
    //if user doesn't have access to that project
    if(array_search($projectID, getAllProjects($_SESSION['userID'])) === FALSE) {
        header("Location: projects");
        exit();
    } else {
        $projectName = getProjectInfo($projectID, "projectName");
        $projectCategory = getProjectInfo($projectID, "projectCategory");
        $projectProgress = getProjectInfo($projectID, "status");
        $projectPriority = getProjectInfo($projectID, "priority");
        $projectStartDate = getProjectInfo($projectID, "startDate");
        $projectEndDate = getProjectInfo($projectID, "endDate");
        $customLink = getProjectInfo($projectID, "customLink");
    }
} else {
    header("Location: projects");
    exit();
}

?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "projects"); ?>

    <div class="main">
        <?php printHeader($_SESSION['userID']);
        ?>
        <div class="forms">
            <h1>Edit <?php echo $projectName; ?></h1>
            <div id="project">
                <form action="" method="post" autocomplete="off" id="form">
                    <div class="tab-content">
                        <div class="field-row">
                            <div class="field-wrap">
                                <label>
                                    Project Name<span class="req">*</span>
                                </label>
                                <input type="text" id="name">
                            </div>

                            <div class='field-wrap'>
                                <div class='rating-widget'>
                                    <p>Priority</p>
                                    <div class='rating-stars'>
                                    <ul id='stars'>
                                      <?php
                                      //priority rating
                                      for($i = 1; $i < 6; $i++){
                                          print("
                                          <li class='star ");
                                          if($i <= $projectPriority) {
                                              print(" selected");
                                          }
                                          print("' data-value='$i'>
                                              <i class='fas fa-exclamation fa-fw'></i></li>");
                                      }
                                      ?>
                                    </ul>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="field-row">

                            <div class="field-wrap">
                                <label for="select">
                                    Project Category
                                </label>
                                <select id="category">
                                    <option id="education" <?php if($projectCategory == "Education") echo "selected"; ?>>Education</option>
                                    <option id="lifestyle"<?php if($projectCategory == "Lifestyle") echo "selected"; ?>>Lifestyle</option>
                                    <option id="socialmedia"<?php if($projectCategory == "Social Media") echo "selected"; ?>>Social Media</option>
                                    <option id="productivity"<?php if($projectCategory == "Productivity") echo "selected"; ?>>Productivity</option>
                                    <option id="game"<?php if($projectCategory == "Game") echo "selected"; ?>>Game</option>
                                    <option id="entertainment"<?php if($projectCategory == "Entertainment") echo "selected"; ?>>Entertainment</option>
                                    <option id="news"<?php if($projectCategory == "News") echo "selected"; ?>>News</option>
                                    <option id="travel"<?php if($projectCategory == "Travel") echo "selected"; ?>>Travel</option>
                                    <option id="tech"<?php if($projectCategory == "Tech") echo "selected"; ?>>Tech</option>
                                </select>
                            </div>
                            <div class="field-wrap">
                                <label for="select">
                                    Current Project Progress
                                </label>
                                <select id="progress">
                                    <option id="concept"<?php if($projectProgress == "Conecpt") echo "selected";?>>Concept</option>
                                    <option id="planning"<?php if($projectProgress == "Planning") echo "selected";?>>Planning</option>
                                    <option id="design"<?php if($projectProgress == "Design") echo "selected";?>>Design</option>
                                    <option id="development"<?php if($projectProgress == "Development") echo "selected";?>>Development</option>
                                    <option id="debugging"<?php if($projectProgress == "Debugging") echo "selected";?>>Debugging</option>
                                    <option id="completed"<?php if($projectProgress == "Completed") echo "selected";?>>Completed</option>
                                </select>
                            </div>
                        </div>
                        <div class="field-row">
                            <div class="field-wrap">
                                <label for="date">
                                    Start Date
                                </label>
                                <input type="date" id="start-date" value = "<?php if($projectStartDate) echo date('Y-m-d', strtotime($projectStartDate)); ?>">
                            </div>
                            <div class="field-wrap">
                                <label for="date">
                                    End Date
                                </label>
                                <input type="date" id="end-date" value = "<?php if($projectEndDate) echo date('Y-m-d', strtotime($projectEndDate)); ?>">
                            </div>
                        </div>
                        <div class='field-wrap radios'>
                            <label for='radio' class='active'>
                                Assignees<span class='req'>*</span>
                            </label>
                            <div id='developerSelect'></div>
                        </div>
                        <div class="field-wrap">
                            <p class='info-circle'><i class="fas fa-info-circle" onclick="alert('This will be the extension for the link that your users click to report a bug. An example would be: PRO, which would allow users visiting projectbuggy.tk/report?PRO to report bugs. It must be less than 26 characters long, unique, and only contain alphanumeric characters and/or the characters - and _');"></i></p>
                            <label>
                                Your Custom Bug Report Link<span class="req">*</span>
                            </label>
                            <input type="text" id="link">
                        </div>
                        <input type="submit" class="button button-block" value="Edit Project">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="scripts/priority.js"></script>
    <script src="scripts/forms.js"></script>
    <script>
        $(document).ready(function(){
            $('#name').prev('label').addClass('active highlight');
            $('#link').prev('label').addClass('active highlight');
            $('#name').val("<?php echo $projectName; ?>");
            var projectID = "<?php echo $projectID; ?>";
            $('#developerSelect').load('scripts/getDeveloperList.php?id&selected&projectEdit=' + projectID);
            $('#link').val("<?php echo $customLink; ?>");
        })

        $('#form').on("submit", function(e){
            e.preventDefault();

            var name = $('#name').val();
            var category = $('#category').val();
            var progress = $('#progress').val();
            var priority = parseInt($('#stars li.selected').last().data('value'), 10);
            var startdate = $('#start-date').val();
            var enddate = $('#end-date').val();
            var projectID = "<?php echo $projectID; ?>";
            var developers = document.querySelectorAll('.developer-list');
            var customlink = $('#link').val();

            var developerList = [];
            var unassignedDeveloperList = [];

            for(var i = 0; i < developers.length; i++){
                if(developers[i].checked) {
                    developerList.push(developers[i].id);
                } else {
                    unassignedDeveloperList.push(developers[i].id);
                }
            }
            developerList = JSON.stringify(developerList);
            unassignedDeveloperList = JSON.stringify(unassignedDeveloperList);

            $.ajax({
                url: 'scripts/editproject.php',
                type: 'post',
                dataType: 'JSON',
                data: {"name": name, "category": category, "progress": progress, "priority": priority, "startdate": startdate, "enddate": enddate, "projectID": projectID, "developers": developerList, "unassignedDevelopers": unassignedDeveloperList, "link": customlink},
                success: function(response) {
                    if(response.response != "")
                        alert(response.response);
                    else
                        window.location.href = "";
                }
            });
        });

    </script>
    <?php printFooter("basic"); ?>
</body>

</html>
