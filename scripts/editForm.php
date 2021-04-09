<?php
    REQUIRE_ONCE "../assets/functions.php";
    $ticketID = $_GET['id'];
    $title = getTicketInfo($ticketID, "name");
    $description = getTicketInfo($ticketID, "description");
    $priority = getTicketInfo($ticketID, "priority");
    $progress = getTicketInfo($ticketID, "status");

    $response = "
        <div class='forms'>
            <div class='field-wrap'>
                <label class='active'>
                    Ticket Title<span class='req'>*</span>
                </label>
                <input type='text' id='ticketTitle' value='$title'>
            </div>
            <div class='field-wrap'>
                <div class='rating-widget'>
                    <p>Priority</p>
                    <div class='rating-stars'>
                    <ul id='stars'>";

                    //priority rating
                    for($i = 1; $i < 6; $i++){
                        $response .= "
                        <li class='star ";
                        if($i <= $priority) {
                            $response .= " selected";
                        }
                        $response .= "' data-value='$i'>
                            <i class='fas fa-exclamation fa-fw'></i></li>";
                    }
            $response .= "
                    </ul>
                    </div>
                </div>
            </div>
            <div class='field-wrap'>
                <label for='textarea' class='active'>
                    Ticket Description<span class='req'>*</span>
                </label>
                <textarea id='description'>$description</textarea>
            </div>
            <div class='field-wrap radios'>
                <label for='radio' class='active'>
                    Assignees<span class='req'>*</span>
                </label>
                <div id='developerSelect'></div>
            </div>
            <div class='field-wrap'>
                <label for='select' class='active'>
                    Progress<span class='req'>*</span>
                </label>
                <select id='progress'>";
                    //select the prior-selected option
                    $response .= "
                        <option id='notStarted' ";
                    if($progress == 'Not Started') $response .= "selected";
                    $response .= ">Not Started</option>";

                    $response .= "<option id='inProgress' ";
                    if($progress == 'In Progress') $response .= "selected";
                    $response .= ">In Progress</option>";

                    $response .= "<option id='needsReview' ";
                    if($progress == 'Review') $response .= "selected";
                    $response .= ">Review</option>";

                    $response .= "<option id='needsRevisions' ";
                    if($progress == 'Needs Revisions') $response .= "selected";
                    $response .=">Needs Revisions</option>";

                    $response .= "<option id='completed' ";
                    if($progress == 'Completed') $response .= "selected";
                    $response .= ">Completed</option>";
                $response .= "</select>
            </div>
        </div>
        <ul class='cd-buttons'>
            <li onclick='editTicket($ticketID)'><a>Save</a></li>
            <li onclick='closePopup()'><a>Cancel</a></li>
        </ul>
        <a class='cd-popup-close img-replace'></a>
    ";

    //javascript to load developer list
    $response .= "<script>
        $('#developerSelect').load('scripts/getDeveloperList.php?id=$ticketID&selectedList');
    </script>";

    //javascript for interactive priority selection
    $response .= "<script src='scripts/priority.js'></script>";

    print($response);

?>
