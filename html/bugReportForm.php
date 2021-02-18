<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <title>Bug Report</title>
</head>

<body>
    <?php require_once '../php/processBugReportInfo.php'; ?>
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
                        <th colspan="2">Action</th>
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
                            <a href="bugReportForm.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                            <a href="bugReportForm.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <form action="" method="POST">
            <label for="">First Name</label>
            <input type="text" name="firstName" placeholder="First Name" value="<?php echo $firstName; ?>" required>
            <br>
            <label for="">Last Name</label>
            <input type="text" name="lastName" placeholder="Last Name" value="<?php echo $lastName; ?>" required>
            <br>
            <label for="">Email</label>
            <input type="email" name="reporterEmail" placeholder="Email" value="<?php echo $reporterEmail; ?>" required>
            <br>
            <label for="">Associated Project</label>
            <select name="projectName" id="projectName">
                <?php
                $project = $mysqli->query("SELECT projectName FROM projectinfo");
                while ($row = $project->fetch_assoc()) : ?>
                    <option value="<?php echo $row['projectName']; ?>"><?php echo $row['projectName']; ?></option>
                <?php endwhile; ?>
            </select>
            <br>
            <label for="">Bug Description</label>
            <textarea name="bugDescription" id="bugDescription" cols="30" rows="10"><?php echo $bugDescription; ?></textarea>
            <br>
            <?php if ($update == true) : ?>
                <button class="btn btn-info" type="submit" name="update">Update</button>
            <?php else : ?>
                <button type="submit" name="submit">Submit</button>
            <?php endif; ?>
        </form>
</body>

</html>