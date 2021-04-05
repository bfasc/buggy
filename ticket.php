<?php
require_once 'assets/functions.php';
require_once 'php-files/ticket.php';

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
    <?php printSidebar(getAccountType($_SESSION['userID']), "tickets"); ?>

    <div class="main" id="ticket">
        <?php printHeader($_SESSION['userID']);
        if($response != "")
            print("<h1>$response</h1>");
        else {
            ?>
            <h2 class='subhead'>Viewing Ticket : <?php echo $ticketTitle; ?></h2>
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
                <p class='info desc'><a class='label'>Description: </a><a>$description</a></p>
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

            print "</div>";

            $threadInfo = getThreadInfo($id);
            print "</div>"; // end ticket div
            print "<div class='thread'>";
            print "<h2 class='subhead'>Discussion</h2 class='subhead'>";

            print "<div class='comment'>
                        <div class='comment-info'>
                            <p class='poster'>POSTER NAME</p>
                            <p class='date'>01/01/2020 5:39PM</p>
                            <i class='fas fa-reply' id='22'></i>
                        </div>
                        <p class='comment-text'>If it’s cropped, the door in the image will be cut off. Is this okay?</p>
                        ";
            print "<div class='reply'>
                            <div class='comment-info'>
                                <p class='poster'>POSTER NAME</p>
                                <p class='date'>01/01/2020 5:39PM</p>
                            </div>
                            <p class='comment-text'>Yes, this is fine.</p>
                    </div>";
                    print "<div class='comment-reply' id='reply-22'></div>";
            print "</div>"; //end comment

            print "<div class='comment'>
                        <div class='comment-info'>
                            <p class='poster'>POSTER NAME</p>
                            <p class='date'>01/01/2020 5:39PM</p>
                            <i class='fas fa-reply' id='21'></i>
                        </div>
                        <p class='comment-text'>I'm going to re-do this.</p>";
                    print "<div class='comment-reply' id='reply-21'></div>";
            print "</div>"; //end comment

            print "<div class='post new'>";
                print "<h2 class='subhead'>Post Comment</h2 class='subhead'>";
                print "<textarea id='$id-text'></textarea>";
                print "<input type='submit' value='Post' class='button comment-submit' id='$id'>";
            print "</div>"; //end post new
            print "</div>"; //end thread div
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

    $('.fa-reply').click(function(){
        var id = $(this).attr('id');
        if(document.getElementById('reply-'+id).innerHTML == "") {
            $('.comment-reply').html("");
            document.getElementById('reply-'+id).innerHTML = "<div class='post reply'>"+
                    "<h2 class='subhead'>Reply</h2 class='subhead'>"+
                    "<textarea id='reply-"+id+"-text'></textarea>"+
                    "<input type='submit' value='Post' class='button reply-submit' id='reply-"+id+"'>"+
                    "</div>";
            $('.reply-submit').click(function(){
                //ID will be reply-ID
                //id is the comment ID that this reply is going to.
                var text = document.getElementById("reply-"+id+"-text").value;
                submitReply(id, text);
            });
        } else document.getElementById('reply-'+id).innerHTML = "";

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


    $('.comment-submit').click(function(){
        //id is the ticket ID that the comment will be posted under.
        var id = $(this).attr('id');
        var text = document.getElementById(id+"-text").value;
        submitComment(id, text);
    });

    function submitComment(id, text){
        //id is the ticket ID that the comment will be posted under.
        $.ajax({
            url: 'scripts/submitComment.php',
            type: 'post',
            dataType: 'JSON',
            data: {"id": id, "text": text, "reply": "false"},
            success: function(response) {
                window.location.href = "";
            }
        });
    }
    function submitReply(id, text){
        //id is the comment ID that this reply is going to.
        $.ajax({
            url: 'scripts/submitComment.php',
            type: 'post',
            dataType: 'JSON',
            data: {"id": id, "text": text, "reply": "true"},
            success: function(response) {
                window.location.href = "";
            }
        });
    }
    </script>
    <?php printFooter("basic"); ?>
</body>

</html>
