<?php
    REQUIRE_ONCE 'assets/functions.php';
    REQUIRE_ONCE 'php-files/tickets.php';
    printHead("View Your Tickets | Buggy - Let's Code Together");
?>
<body>
        <?php printSidebar(getAccountType($_SESSION['userID']), "tickets"); ?>
        <div class="main" id="tickets">
            <div class="cd-popup" role="alert">
                <div class="cd-popup-container">
                </div>
            </div>
            <?php printHeader($_SESSION['userID']);
            if(getAccountType($_SESSION['userID']) == "management" && getAllProjects($_SESSION['userID']) == []) {
                print("<h2 class='subhead'>You need to create a Project to get started.</h2 class='subhead'>
                <a href='createproject' class='button'>Create Your First Project</a>
                ");
            } else {
            ?>
            <h2 class='subhead'>In Progress</h2>
            <?php fetchTickets($_SESSION['userID'], "In Progress"); ?>

            <h2 class='subhead'>New Tickets</h2>
            <?php fetchTickets($_SESSION['userID'], "New");
            } ?>
        </div>
        <?php printFooter("basic"); ?>

        <script>
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
        $('.progressChange').click(function(){
            var id = $(this).attr('id');
            var progress = document.getElementById('progress').value;
            if(progress != "" && progress != null) {
                $.ajax({
                    url: 'scripts/editTicket.php',
                    type: 'post',
                    dataType: 'JSON',
                    data: {"id": id, "type": "editProgress", "progress": progress},
                    success: function(response) {
                        window.location.href = "";
                    }
                });
            }
        });
        $('.delete').click(function(){
            var id = $(this).attr('id');
            $('.cd-popup-container').html("<p>Are you sure you want to delete this ticket?</p>"+
            "<ul class='cd-buttons'>"+
                "<li onclick=\"deleteTicket("+id+")\"><a>Delete</a></li>"+
                "<li onclick=\"closePopup()\"><a>Cancel</a></li>"+
            "</ul>"+
            "<a class='cd-popup-close img-replace'></a>");
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
                data: {"id": ticketID,
                "name": title,
                "description": description,
                "priority": priority,
                "developers": developerList,
                "progress": progress,
                "type": "full"
            },
                success: function(response) {
                    closePopup();
                    window.location.href = "";
                }
            });
        }
        function deleteTicket(ticketID) {
            $.ajax({
                url: 'scripts/deleteTicket.php',
                type: 'post',
                dataType: 'JSON',
                data: {"id": ticketID},
                success: function(response) {
                    closePopup();
                    window.location.href = "";
                }
            });
        }
        </script>
</body>
</html>
