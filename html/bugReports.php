<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <title>Bug Reports</title>
</head>

<body>
    <?php require_once '../php/processBugApproval.php'; ?>
    <div class="container">
        <?php
        $mysqli = new mysqli('us-cdbr-east-03.cleardb.com', 'b27268e1e174f3', 'a5769c7d', 'heroku_ea94c1083a34040');
        $result = $mysqli->query("SELECT * FROM bugreportinfo") or die($mysqli->error);
        ?>

        <div class="row justify-content-center">
            <table class="table">
                <thead>
                    <tr>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Bug Description</th>
                        <th colspan="1">Approval</th>
                        <th colspan="1">Action</th>
                    </tr>
                </thead>
                <?php
                while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['firstName']; ?></td>
                        <td><?php echo $row['lastName']; ?></td>
                        <td><?php echo $row['reporterEmail']; ?></td>
                        <td><?php echo $row['bugDescription']; ?></td>
                        <td>
                            <a href="bugReports.php?approve=<?php echo $row['id']; ?>" class="btn btn-info">Approve</a>
                            <a href="bugReports.php?reject=<?php echo $row['id']; ?>" class="btn btn-danger">Reject</a>
                        </td>
                        <td>
                            <a href="bugReports.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                            <a href="bugReports.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <form action="" method="POST">
            <?php if ($approved == 'true') : ?>
                <label for="">Ticket Title</label>
                <input type="text" name="ticketTitle" placeholder="Ticket Title">
                <br>
                <label for="">Last Edited Date</label>
                <input type="date" name="lastEditedDate" placeholder="Start Date" value="<?php echo $lastEditedDate; ?>" required><br>
                <label for="">Assigned Developers</label>
                <textarea name="assignedDevelopers" id="assignedDevelopers" cols="30" rows="10"><?php echo $assignedDevelopers; ?></textarea>
                <br>
                <label for="">Project Status</label>
                <select id="ticketStatus" name="ticketStatus">
                    <option value="Not started">Not started</option>
                    <option value="Needs Review">Needs Review</option>
                    <option value="In Progress">In Progress</option>
                    <option value="Complete">Complete</option>
                </select>
                <br>
            <?php elseif ($approved == 'false') : ?>
                <label for="">Reason for Rejection</label>
                <textarea name="rejectionReason" id="rejectionReason" cols="30" rows="10"><?php echo $rejectionReason; ?></textarea>
                <br>
            <?php else : ?>
            <?php endif; ?>
            <?php if ($update == true) : ?>
                <button class="btn btn-info" type="submit" name="update">Update</button>
            <?php else : ?>
                <button type="submit" name="submit">Submit</button>
            <?php endif; ?>
        </form>
</body>

</html>