<?php
    REQUIRE_ONCE 'assets/functions.php';
    REQUIRE_ONCE 'php-files/approval.php';
    printHead("Bug Report Approval | Buggy - Let's Code Together");
?>
<body>
        <?php printSidebar(getAccountType($_SESSION['userID']), "approval"); ?>
        <div class="main">
            <?php printHeader($_SESSION['userID']); ?>
            <section id='reports'>
                <h1>Approve Bugs</h1>
                <div class="cd-popup" role="alert">
                    <div class="cd-popup-container">
                    </div>
                </div>
                <?php
                $projectArray = getAllProjects($_SESSION['userID']);
                foreach($projectArray as $row) {
                    listBugs($row['id']);
                }
                ?>
            </section>
        </div>

        <script>
        //POPUP SCRIPT
        $(document).ready(function(){
        	//open popup
        	$('.cd-popup-trigger').on('click', function(event){
                //priority rating code from: https://codepen.io/depy/pen/vEWWdw
                  /* 1. Visualizing things on Hover - See next part for action on click */
                  $('#stars li').on('mouseover', function(){
                    var onStar = parseInt($(this).data('value'), 10); // The star currently mouse on

                    // Now highlight all the stars that's not after the current hovered star
                    $(this).parent().children('li.star').each(function(e){
                      if (e < onStar) {
                        $(this).addClass('hover');
                      }
                      else {
                        $(this).removeClass('hover');
                      }
                    });

                  }).on('mouseout', function(){
                    $(this).parent().children('li.star').each(function(e){
                      $(this).removeClass('hover');
                    });
                  });


                  /* 2. Action to perform on click */
                  $('#stars li').on('click', function(){
                    var onStar = parseInt($(this).data('value'), 10); // The star currently selected
                    var stars = $(this).parent().children('li.star');

                    for (i = 0; i < stars.length; i++) {
                      $(stars[i]).removeClass('selected');
                    }

                    for (i = 0; i < onStar; i++) {
                      $(stars[i]).addClass('selected');
                    }

                  });


        		event.preventDefault();
        		$('.cd-popup').addClass('is-visible');

                //form js
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
        function closePopup(){
            $('.cd-popup').removeClass('is-visible');
        }


        //APPROVAL / DENIAL SCRIPT
        function approveBug(id){
            var title = document.getElementById('ticketTitle').value;
            var description = document.getElementById('description').value;
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
                url: 'scripts/approveBug.php',
                type: 'post',
                dataType: 'JSON',
                data: {"id": id, "name": title, "description": description, "priority": priority, "developers": developerList},
                success: function(response) {
                    closePopup();
                    window.location.href = "";
                }
            });
        }
        function denyBug(id){
            var reason = document.getElementById('rejectionreason').value;
            $.ajax({
                url: 'scripts/denyBug.php',
                type: 'post',
                dataType: 'JSON',
                data: {"id": id, "reason": reason},
                success: function(response) {
                    closePopup();
                    window.location.href = "";
                }
            });
        }
        $('.approve').click(function(){
            var id = $(this).attr('id');
            $('.cd-popup-container').html("<p>Fill out the following fields to create a ticket for this bug.</p>"+
            "<div class='forms'>"+
                "<div class='field-row'>"+
                    "<div class='field-wrap'>"+
                        "<label>"+
                            "Ticket Title<span class='req'>*</span>"+
                        "</label>"+
                        "<input type='text' id='ticketTitle'>"+
                    "</div>"+
                    "<div class='field-wrap'>"+
                    "<div class='rating-widget'>"+
                        "<p>Priority</p>"+
                        "<div class='rating-stars'>"+
                        "<ul id='stars'>"+
                          "<li class='star' title='Lowest' data-value='1'>"+
                            "<i class='fas fa-exclamation fa-fw'></i>"+
                          "</li>"+
                         " <li class='star' title='Low' data-value='2'>"+
                            "<i class='fas fa-exclamation fa-fw'></i>"+
                          "</li>"+
                          "<li class='star' title='Medium' data-value='3'>"+
                            "<i class='fas fa-exclamation fa-fw'></i>"+
                          "</li>"+
                          "<li class='star' title='High' data-value='4'>"+
                            "<i class='fas fa-exclamation fa-fw'></i>"+
                          "</li>"+
                          "<li class='star' title='Top' data-value='5'>"+
                            "<i class='fas fa-exclamation fa-fw'></i>"+
                          "</li>"+
                        "</ul>"+
                        "</div>"+
                    "</div>"+
                    "</div>"+
                "</div>"+
                "<div class='field-wrap'>"+
                    "<label for='textarea'>"+
                        "Ticket Description<span class='req'>*</span>"+
                    "</label>"+
                    "<textarea id='description'></textarea>"+
                "</div>"+
                "<div class='field-wrap radios'>"+
                    "<label for='radio'>"+
                        "Assignees<span class='req'>*</span>"+
                    "</label>"+
                    "<div id='developerSelect'>"+
                    "</div>"+
                "</div>"+
            "</div>"+
            "<ul class='cd-buttons'>"+
                "<li onclick=\"approveBug("+id+")\"><a>Approve</a></li>"+
                "<li onclick=\"closePopup()\"><a>Cancel</a></li>"+
            "</ul>"+
            "<a class='cd-popup-close img-replace'></a>");

            $('#developerSelect').load('scripts/getDeveloperList.php?id='+id);
        });

        $('.deny').click(function(){
            var id = $(this).attr('id');
            $('.cd-popup-container').html("<p>Enter a rejection reason. This information will be emailed to the bug reporter.</p>"+
            "<div class='forms'><textarea id='rejectionreason'></textarea></div>"+
            "<ul class='cd-buttons'>"+
                "<li onclick=\"denyBug("+id+")\"><a>Deny</a></li>"+
                "<li onclick=\"closePopup()\"><a>Cancel</a></li>"+
            "</ul>"+
            "<a class='cd-popup-close img-replace'></a>");
        });

        </script>
        <?php printFooter("basic"); ?>
</body>
</html>
