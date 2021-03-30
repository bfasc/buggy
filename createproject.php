<?php
require_once 'assets/functions.php';
require_once 'php-files/createproject.php';
printHead("Create a Project | Buggy - Let's Code Together");
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "projects"); ?>

    <div class="main">
        <?php printHeader($_SESSION['userID']);
        ?>
        <div class="forms">
            <h1>Create a Project</h1>
            <p>Add a Project under your company, <?php print(getCompanyInfo(getUserInfo($_SESSION['userID'], "associatedCompany"), "companyName")); ?></p>
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
                                      <li class='star' title='Lowest' data-value='1'>
                                        <i class='fas fa-exclamation fa-fw'></i>
                                      </li>
                                     <li class='star' title='Low' data-value='2'>
                                        <i class='fas fa-exclamation fa-fw'></i>
                                      </li>
                                      <li class='star' title='Medium' data-value='3'>
                                        <i class='fas fa-exclamation fa-fw'></i>
                                      </li>
                                      <li class='star' title='High' data-value='4'>
                                        <i class='fas fa-exclamation fa-fw'></i>
                                      </li>
                                      <li class='star' title='Top' data-value='5'>
                                        <i class='fas fa-exclamation fa-fw'></i>
                                      </li>
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
                                    <option selected disabled>Category</option>
                                    <option id="education">Education</option>
                                    <option id="lifestyle">Lifestyle</option>
                                    <option id="socialmedia">Social Media</option>
                                    <option id="productivity">Productivity</option>
                                    <option id="game">Game</option>
                                    <option id="entertainment">Entertainment</option>
                                    <option id="news">News</option>
                                    <option id="travel">Travel</option>
                                    <option id="tech">Tech</option>
                                </select>
                            </div>
                            <div class="field-wrap">
                                <label for="select">
                                    Current Project Progress
                                </label>
                                <select id="progress">
                                    <option selected disabled>Progress</option>
                                    <option id="concept">Concept</option>
                                    <option id="development">Planning</option>
                                    <option id="development">Design</option>
                                    <option id="development">Development</option>
                                    <option id="debugging">Debugging</option>
                                    <option id="development">Completed</option>
                                </select>
                            </div>
                        </div>
                        <div class="field-row">
                            <div class="field-wrap">
                                <label for="date">
                                    Start Date
                                </label>
                                <input type="date" id="start-date">
                            </div>
                            <div class="field-wrap">
                                <label for="date">
                                    End Date
                                </label>
                                <input type="date" id="end-date">
                            </div>
                        </div>
                        <div class="field-wrap">
                            <p class='info-circle'><i class="fas fa-info-circle" onclick="alert('This will be the extension for the link that your users click to report a bug. An example would be: PRO, which would allow users visiting projectbuggy.tk/report?PRO to report bugs. It must be less than 26 characters long, unique, and only contain alphanumeric characters and/or the characters - and _');"></i></p>
                            <label>
                                Your Custom Bug Report Link<span class="req">*</span>
                            </label>
                            <input type="text" id="link">
                        </div>
                        <input type="submit" class="button button-block" value="Create Project">
                    </div>
                </form>
            </div>
        </div>
    </div>
    <script src="scripts/priority.js"></script>
    <script src="scripts/forms.js"></script>
    <script>

        $('#form').on("submit", function(e){
            e.preventDefault();

            var name = $('#name').val();
            var category = $('#category').val();
            var progress = $('#progress').val();
            var priority = parseInt($('#stars li.selected').last().data('value'), 10);
            var startdate = $('#start-date').val();
            var enddate = $('#end-date').val();
            var companyID = "<?php print(getUserInfo($_SESSION['userID'], "associatedCompany")); ?>";
            var customlink = $('#link').val();

            var validation = "";

            $.ajax({
                url: 'scripts/createproject.php',
                type: 'post',
                dataType: 'JSON',
                data: {"name": name, "category": category, "progress": progress, "priority": priority, "startdate": startdate, "enddate": enddate, "companyID": companyID, "link": customlink},
                success: function(response) {
                    if(response.response != "")
                        alert(response.response);
                    else
                        window.location.href = "projects";
                }
            });
        });

    </script>
    <?php printFooter("basic"); ?>
</body>

</html>
