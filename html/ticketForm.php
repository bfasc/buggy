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
        $result = $mysqli->query("SELECT * FROM ticketinfo") or die($mysqli->error);
        $bugs = $mysqli->query("SELECT * FROM bugreportinfo") or die($mysqli->error);
        ?>

        <div class="row justify-content-center">
            <h1 style="text-align: center;">Bug Reports</h1>
            <table class="table">
                <thead>
                    <tr>
                        <th>Email</th>
                        <th>Bug Description</th>
                        <th>Last Edited Date</th>
                        <th>Approved</th>
                        <th>Assigned Developers</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <?php
                while ($row = $bugs->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['reporterEmail']; ?></td>
                        <td><?php echo $row['bugDescription']; ?></td>
                        <td>
                            <a href="ticketForm.php?approve=<?php echo $row['id']; ?>" class="btn btn-info">Approve</a>
                            <a href="ticketForm.php?reject=<?php echo $row['id']; ?>" class="btn btn-danger">Reject</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
                <?php
                while ($dataRow = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $dataRow['lastEditedDate']; ?></td>
                        <?php if ($dataRow['approval'] == 0) : ?>
                            <td>No</td>
                        <?php else : ?>
                            <td>Yes</td>
                        <?php endif; ?>
                        <td><?php echo $dataRow['assignedDevelopers']; ?></td>
                        <td>
                            <a href="ticketForm.php?edit=<?php echo $dataRow['id']; ?>" class="btn btn-info">Edit</a>
                            <a href="ticketForm.php?delete=<?php echo $dataRow['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
            <form action="" method="POST">
                <?php if ($approved == 'true') : ?>
                    <label for="">Last Edited Date</label>
                    <input type="date" name="lastEditedDate" placeholder="Start Date" value="<?php echo $lastEditedDate; ?>" required><br>
                    <label for="">Assigned Developers</label>
                    <textarea name="assignedDevelopers" id="assignedDevelopers" cols="30" rows="10"><?php echo $assignedDevelopers; ?></textarea>
                    <br>
                    <button type="submit" name="submit">Submit</button>
                <?php elseif ($approved == 'false') : ?>
                    <label for="">Reason for Rejection</label>
                    <textarea name="rejectionReason" id="rejectionReason" cols="30" rows="10"><?php echo $rejectionReason; ?></textarea>
                    <br>
                    <button type="submit" name="submit">Submit</button>
                <?php else : ?>
                <?php endif; ?>
                <!-- <?php if ($update == true) : ?>
                    <button class="btn btn-info" type="submit" name="update">Update</button>
                <?php else : ?>
                    <button type="submit" name="submit">Submit</button>
                <?php endif; ?> -->
            </form>
</body>

</html>