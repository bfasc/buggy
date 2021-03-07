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
            <li onclick='editTicket($ticketID)'><a>Edit</a></li>
            <li onclick='closePopup()'><a>Cancel</a></li>
        </ul>
        <a class='cd-popup-close img-replace'></a>
    ";

    //javascript to load developer list
    $response .= "<script>
        $('#developerSelect').load('scripts/getDeveloperList.php?id=$ticketID&selectedList');
    </script>";

    //javascript for interactive priority selection
    $response .= "<script>
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
    </script>";

    print($response);

?>
