<?php
    REQUIRE_ONCE 'assets/functions.php';
    REQUIRE_ONCE 'php-files/tickets.php';
    printHead("View Your Tickets | Buggy - Let's Code Together");
?>
<body>
        <?php printSidebar(getAccountType($_SESSION['userID']), "tickets"); ?>
        <div class="main" id="tickets">
            <?php printHeader($_SESSION['userID']);
            if(getAccountType($_SESSION['userID']) == "management" && getAllProjects($_SESSION['userID']) == []) {
                print("<h2>You need to create a Project to get started.</h2>
                <a href='createproject' class='button'>Create Your First Project</a>
                ");
            }
            ?>
            <div class="cd-popup" role="alert">
                <div class="cd-popup-container">
                </div>
            </div>

            <h1>In Progress</h1>
            <?php fetchTickets($_SESSION['userID'], "In Progress"); ?>

            <h1>New Tickets</h1>
            <?php fetchTickets($_SESSION['userID'], "New"); ?>
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
        </script>
</body>
</html>
