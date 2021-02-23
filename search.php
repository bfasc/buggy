<?php
    REQUIRE_ONCE 'assets/functions.php';
    REQUIRE_ONCE 'php-files/search.php';
    printHead("Search Tickets | Buggy - Let's Code Together");
?>
<body>
        <?php printSidebar(getAccountType($_SESSION['userID']), "search"); ?>
        <div class="main">
            <?php printHeader($_SESSION['userID']);?>
            <section id="search">
                <h1>Search all tickets available to you</h1>
                <section id="search-filters">
                    <div class="forms">
                        <h1>Search Filters</h1>
                        <form action="" method="post" autocomplete="off" id="searchForm">
                            <div class="tab-content">
                                <div class="field-wrap">
                                    <label>
                                        <i class="fas fa-search"></i> Search Tickets by Name/Content
                                    </label>
                                    <input type="text" id="search-text">
                                </div>
                                <div class="field-row radios">
                                    <div class="field-wrap">
                                        <label for="radio">
                                            Basic Filters
                                        </label>
                                        <div class='radio-row'>
                                            <label for="assigned">Assigned To You</label>
                                            <input type="checkbox" id="assigned" name="assigned">
                                        </div>
                                        <div class='radio-row'>
                                            <label for="discussion">Contains Discussion</label>
                                            <input type="checkbox" id="discussion" name="discussion">
                                        </div>
                                        <div class='radio-row'>
                                            <label for="completed">Completed</label>
                                            <input type="checkbox" id="completed" name="completed">
                                        </div>
                                        <div class='radio-row'>
                                            <label for="inProgress">In Progress</label>
                                            <input type="checkbox" id="inProgress" name="inProgress">
                                        </div>
                                    </div>
                                    <div class="field-wrap">
                                        <label for="radio">
                                            Within A Project
                                        </label>
                                        <div id="project-wrap">
                                        </div>
                                    </div>
                                </div>
                                <div class="field-row">
                                    <p>Within A Timeframe</p>
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
                                <input type="submit" class="button button-block" value="Search">
                            </div>
                        </form>
                    </div>

                </section>
                <div class="cd-popup" role="alert">
                    <div class="cd-popup-container">
                    </div>
                </div>
                <section id="search-results">
                </section>
            </section>
        </div>

        <script>

            // Fill Project List Search Results
            $(document).ready(function(){
                var userID = "<?php echo($_SESSION['userID']); ?>";
                $.ajax({
                    url: 'scripts/allProjects.php',
                    type: 'post',
                    dataType: 'JSON',
                    data: {"userID": userID},
                    success: function(response) {
                        $('#project-wrap').html(response.htmlResponse);
                    }
                });
            });

            function closePopup(){
                $('.cd-popup').removeClass('is-visible');
            }
            function editTicket(ticketID){
                var title = document.getElementById('ticketTitle').value;
                var description = document.getElementById('description').value;
                var progress = document.getElementById('progress').value;
                var priority = parseInt($('#stars li.selected').last().data('value'), 10);
                var developers = document.querySelectorAll('.developer-list');

                var developerList = [];

                for(var i = 0; i < developers.length; i++){
                    if(developers[i].checked) {
                        developerList.push(developers[i].id);
                    }
                }
                developerList = JSON.stringify(developerList);

                $.ajax({
                    url: 'scripts/editTicket.php',
                    type: 'post',
                    dataType: 'JSON',
                    data: {"id": ticketID, "name": title, "description": description, "priority": priority, "developers": developerList, "progress": progress},
                    success: function(response) {
                        closePopup();
                        window.location.href = "";
                    }
                });
            }

            /*Fill search results*/
            $('#searchForm').on("submit", function(e){
                e.preventDefault();

                //grab selected filters
                var content = $('#search-text').val();
                var assigned = $('#assigned').is(':checked');
                var discussion = $('#discussion').is(':checked');
                var completed = $('#completed').is(':checked');
                var inProgress = $('#inProgress').is(':checked');

                if(assigned) assigned = 1;
                else assigned = 0;

                if(discussion) discussion = 1;
                else discussion = 0;

                if(completed) completed = 1;
                else completed = 0;

                if(inProgress) inProgress = 1;
                else inProgress = 0;

                var startDate = $('#start-date').val();
                var endDate = $('#end-date').val();

                var projects = document.querySelectorAll('.project-list');
                var projectList = [];
                for(var i = 0; i < projects.length; i++){
                    if(projects[i].checked) {
                        projectList.push(projects[i].id);
                    }
                }
                projectList = JSON.stringify(projectList);
                $.ajax({
                    url: 'scripts/search.php',
                    type: 'post',
                    dataType: 'JSON',
                    data: {"content": content, "assigned": assigned, "discussion": discussion, "completed": completed, "inProgress": inProgress, "projectList": projectList, "startDate": startDate, "endDate": endDate},
                    success: function(response) {
                        $('#search-results').html(response.htmlResponse);
                        /*Popup Edit Window */
                        //POPUP SCRIPT
                        $(document).ready(function(){
                            //open popup
                            $('.cd-popup-trigger').on('click', function(event){
                                event.preventDefault();
                                $('.cd-popup').addClass('is-visible');
                            });

                            //close popup
                            $('.cd-popup').on('click', function(event){
                                if( $(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup') ) {
                                    event.preventDefault();
                                    $(this).removeClass('is-visible');
                                }
                            });
                            //close popup when clicking the esc keyboard button
                            $(document).keyup(function(event){
                                if(event.which=='27'){
                                    $('.cd-popup').removeClass('is-visible');
                                }
                            });
                        });

                        $('.edit').click(function(){
                            var id = $(this).attr('id');
                            $('.cd-popup-container').load('scripts/editForm.php?id='+id);
                        });
                        $('#search-results').css("border", "solid #E75858 2px");
                    }
                });
            });

            /*Form Script*/
            $('.forms').find('input, textarea').on('keyup blur focus', function (e) {
              var $this = $(this),
                  label = $this.prev('label');

            	  if (e.type === 'keyup') {
            			if ($this.val() === '') {
                      label.removeClass('active highlight');
                    } else {
                      label.addClass('active highlight');
                    }
                } else if (e.type === 'blur') {
                	if( $this.val() === '' ) {
                		label.removeClass('active highlight');
            			} else {
            		    label.removeClass('highlight');
            			}
                } else if (e.type === 'focus') {

                  if( $this.val() === '' ) {
                		label.removeClass('highlight');
            			}
                  else if( $this.val() !== '' ) {
            		    label.addClass('highlight');
            			}
                }

            });
        </script>

        <?php printFooter("basic"); ?>
</body>
</html>
