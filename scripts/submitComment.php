<?php
REQUIRE_ONCE "../assets/functions.php";
REQUIRE_ONCE "../php-files/ticket.php";
session_start();
try {
    $db = db_connect();
    $date = date('Y-m-d H:i:s');
    if($_POST['reply'] == "true") { //reply to comment
        //$_POST id is the comment ID that this reply is going to.
        $ticketID = getReplyTicketID($_POST['id']);
        $values = [$ticketID, $_SESSION['userID'], $_POST['text'], $_POST['id'], $date];
        $sql = "INSERT INTO comments (ticket, user, commentText, reply, postDate)
        VALUES (?, ?, ?, ?)";

        $stmt = $db->prepare($sql);
        $stmt->execute($values);

        $firstName = getUserInfo($_SESSION['userID'], "firstName");
        $lastName = getUserInfo($_SESSION['userID'], "lastName");
        $ticketTitle = getTicketInfo($ticketID, "name");
        $commentPoster = getCommentInfo($ticketID, "user");

        newNotification("$firstName $lastName has replied to your comment on Ticket #$ticketID: $ticketTitle", $commentPoster, "ticket/$ticketID");
        $response = "success";
    } else { //new comment in thread
        //$_POST id is the ticket ID that the comment will be posted under.
        $values = [$_POST['id'], $_SESSION['userID'], $_POST['text'], $date];
        $sql = "INSERT INTO comments (ticket, user, commentText, postDate)
        VALUES (?, ?, ?, ?)";

        $stmt = $db->prepare($sql);
        $stmt->execute($values);

        $firstName = getUserInfo($_SESSION['userID'], "firstName");
        $lastName = getUserInfo($_SESSION['userID'], "lastName");
        $ticketTitle = getTicketInfo($_POST['id'], "name");

        $assignedDevelopers = getTicketInfo($_POST['id'], "assignedDevelopers");

        $assignedDevelopers = explode(",", $assignedDevelopers);
        foreach($assignedDevelopers as $dev) {
            newNotification("$firstName $lastName has commented on Ticket #" . $_POST['id'] . ": $ticketTitle", $dev, "ticket/" . $_POST['id']);
        }

        $response = "success";
    }
} catch (Exception $e) {
    $response = $e;
} finally {
    $db = NULL;
}
$return_arr = array("response" => $response);
echo json_encode($return_arr);

?>
