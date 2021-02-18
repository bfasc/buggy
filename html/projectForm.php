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
    <?php require_once '../php/processProjectInfo.php'; ?>
    <div class="container">
        <?php
        $mysqli = new mysqli('us-cdbr-east-03.cleardb.com', 'b27268e1e174f3', 'a5769c7d', 'heroku_ea94c1083a34040');
        $result = $mysqli->query("SELECT * FROM projectinfo") or die($mysqli->error);
        ?>

        <div class="row justify-content-center">
            <table class="table">
                <thead>
                    <tr>
                        <th>Project Name</th>
                        <th>Category</th>
                        <th>Start Date</th>
                        <th>Status</th>
                        <th>Priority</th>
                        <th>Icon</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <?php
                while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['projectName']; ?></td>
                        <td><?php echo $row['projectCategory']; ?></td>
                        <td><?php echo $row['startDate']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['priority']; ?></td>
                        <td><?php echo $row['projectIcon']; ?></td>
                        <td>
                            <a href="projectForm.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                            <a href="projectForm.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
            <form action="" method="POST">
                <label for="">Project name</label>
                <input type="text" name="projectName" placeholder="Project Name" value="<?php echo $projectName; ?>" required>
                <br>
                <label for="">Project Category</label>
                <input type="text" name="projectCategory" placeholder="Category" value="<?php echo $projectCategory; ?>" required>
                <br>
                <label for="">Start Date</label>
                <input type="date" name="startDate" placeholder="Start Date" value="<?php echo $startDate; ?>" required>
                <br>
                <label for="">Project Status</label>
                <select id="status" name="status">
                    <option value="concept">Concept</option>
                    <option value="development">Development</option>
                    <option value="inProgress">In Progress</option>
                    <option value="complete">Complete</option>
                </select>
                <br>
                <label for="">Project Priority</label><br>
                <input type="radio" id="one" name="priority" value="1">
                <label for="one">1</label><br>
                <input type="radio" id="two" name="priority" value="2">
                <label for="two">2</label><br>
                <input type="radio" id="three" name="priority" value="3">
                <label for="three">3</label><br>
                <input type="radio" id="four" name="priority" value="4">
                <label for="four">4</label><br>
                <input type="radio" id="five" name="priority" value="5">
                <label for="five">5</label>
                <br>
                <label for="">Project Icon</label>
                <input type="text" name="projectIcon" placeholder="Project Icon" value="<?php echo $projectIcon; ?>">
                <br>
                <?php if ($update == true) : ?>
                    <button class="btn btn-info" type="submit" name="update">Update</button>
                <?php else : ?>
                    <button type="submit" name="submit">Submit</button>
                <?php endif; ?>
            </form>
</body>

</html>