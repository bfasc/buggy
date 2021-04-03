<?php
require_once 'assets/functions.php';

$response = "";

if(isset($_GET['ticket']) && !empty($_GET['ticket'])) {
    $ticketTitle = getTicketInfo($_GET['ticket'], "name");
    if($ticketTitle == "") $response = "Invalid link.";
} else {
    $response = "Invalid link.";
}
printHead("Viewing Ticket $ticketTitle | Buggy - Let's Code Together");

if(array_search(getTicketInfo($_GET['ticket'], "associatedProjectID"), getAllProjects($_SESSION['userID'])) === FALSE) {
    //user does not have access to ticket
    header("Location: tickets");
    exit();
}
?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "projects"); ?>

    <div class="main" id="tickets">
        <?php printHeader($_SESSION['userID']);
        if($response != "")
            print("<h1>$response</h1>");
        else {
            ?>
            <h1>Viewing Ticket <?php echo $ticketTitle; ?></h1>
            <div class="cd-popup" role="alert">
                <div class="cd-popup-container">
                </div>
            </div>
            <?php
            $id = $_GET['ticket'];
            $title = getTicketInfo($id, "name");
            $description = getTicketInfo($id, "description");
            $priority = getTicketInfo($id, "priority");
            $status = getTicketInfo($id, "status");
            $associatedBugID = getTicketInfo($id, "associatedBugID");
            $associatedProjectID = getTicketInfo($id, "associatedProjectID");
            $lastEditedDate = getTicketInfo($id, "lastEditedDate");
            $approvalDate = getTicketInfo($id, "approvalDate");
            $assignedDevelopers = getTicketInfo($id, "assignedDevelopers");

            $developerString = "";
            $assignedDevelopers = explode(",", $assignedDevelopers);
            foreach($assignedDevelopers as $developer) {
                $firstName = getUserInfo($developer, "firstName");
                $lastName = getUserInfo($developer, "lastName");
                $developerString .= "$firstName $lastName <br>";
            }

            //priority string
            $priorityString = "";
            for($i = 0; $i < 5; $i++){
                $priorityString .= "<i class='fas fa-exclamation fa-fw";
                if($i < $priority) {
                    $priorityString .= " highlight";
                }
                $priorityString .= "'></i>";
            }

            print "
            <div class='ticket'>
                <p class='name'>#$id : $title</p>
                <p class='info'><a class='label'>Priority : </a><a>$priorityString</a></p>
                <p class='info'><a class='label'>Assignees: </a><a>$developerString</a></p>
                <p class='info'><a class='label'>Progress: </a><a>$status</a>
                <p class='info'><a class='label'>Description: </a><a>$description</a></p>
                ";
            if(getUserInfo($_SESSION['userID'], "accountType") == "developer") {
                print "<select id='progress'>
                <option selected disabled>Change Ticket Progress</option>
                <option id='notStarted'>Not Yet Started</option>
                <option id='inProgress'>In Progress</option>
                <option id='review'>Review</option>
                <option id='needsRevisions'>Needs Revisions</option>
                </select><a class='button progressChange'id='$id'>Change Progress</a>";
            }
            print "</p><div class='button-wrap'>";
            if(getUserInfo($_SESSION['userID'], "accountType") == "management") {
                print "<a class='button edit cd-popup-trigger' id='$id' class='button'>Edit</a>";
                print "<a class='button delete cd-popup-trigger' id='$id' class='button'>Delete</a>";
            }

            print "</div></div>";
        } //end response
        ?>
    </div>
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

        $.ajax({
            url: 'scripts/editTicket.php',
            type: 'post',
            dataType: 'JSON',
            data: {"id": id, "type": "editProgress", "progress": progress},
            success: function(response) {
                window.location.href = "";
            }
        });
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
    <?php printFooter("basic"); ?>
</body>

</html>
