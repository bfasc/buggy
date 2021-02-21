<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <title>Project</title>
</head>

<body>
    <?php require_once '../php/processTicketInfo.php'; ?>
    <div class="container">
        <?php
        $mysqli = new mysqli('us-cdbr-east-03.cleardb.com', 'b27268e1e174f3', 'a5769c7d', 'heroku_ea94c1083a34040');
        $result = $mysqli->query("SELECT ticketinfo.id, ticketinfo.name, ticketinfo.status, ticketinfo.lastEditedDate, ticketinfo.assignedDevelopers, bugreportinfo.firstName, bugreportinfo.lastName, bugreportinfo.reporterEmail, bugreportinfo.bugDescription FROM ticketinfo INNER JOIN bugreportinfo ON ticketinfo.associatedBugID = bugreportinfo.id AND bugreportinfo.approval = 1") or die($mysqli->error);
        ?>

        <div class="row justify-content-center">
            <h1 style="text-align: center;">Tickets</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Ticket Name</th>
                        <th>Bug Description</th>
                        <th>Ticket Status</th>
                        <th>Assigned Developers</th>
                        <th>Last Edited Date</th>
                        <th>Reporter First Name</th>
                        <th>Reporter Last Name</th>
                        <th>Reporter Email</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <?php
                while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['name']; ?></td>
                        <td><?php echo $row['bugDescription']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['assignedDevelopers']; ?></td>
                        <td><?php echo $row['lastEditedDate']; ?></td>
                        <td><?php echo $row['firstName']; ?></td>
                        <td><?php echo $row['lastName']; ?></td>
                        <td><?php echo $row['reporterEmail']; ?></td>
                        <td>
                            <a href="ticketForm.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                            <a href="ticketForm.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
            <form action="" method="POST">
                <?php if ($update == true) : ?>
                    <label for="">Ticket Name</label>
                    <input type="text" name="name" id="name" placeholder="Ticket Name" value="<?php echo $name; ?>">
                    <br>
                    <label for="">Ticket Status</label>
                    <select id="ticketStatus" name="ticketStatus">
                        <option value="Not started">Not started</option>
                        <option value="Needs Review">Needs Review</option>
                        <option value="In Progress">In Progress</option>
                        <option value="Complete">Complete</option>
                    </select>
                    <br>
                    <label for="">Assigned Developers</label>
                    <textarea name="assignedDevelopers" id="assignedDevelopers" cols="30" rows="10"><?php echo $assignedDevelopers; ?></textarea>
                    <br>
                    <label for="">Last Edited Date</label>
                    <input type="date" name="lastEditedDate" placeholder="Start Date" value="<?php echo $lastEditedDate; ?>" required>
                    <br>
                <?php else : ?>
                <?php endif; ?>
                <?php if ($update == true) : ?>
                    <button class="btn btn-info" type="submit" name="update">Update</button>
                <?php else : ?>
                    <!-- <button type="submit" name="submit">Submit</button> -->
                <?php endif; ?>
            </form>
</body>

</html>