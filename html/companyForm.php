<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <title>Company</title>
</head>

<body>
    <?php require_once '../php/processCompanyInfo.php'; ?>
    <div class="container">
        <?php
        $mysqli = new mysqli('us-cdbr-east-03.cleardb.com', 'b27268e1e174f3', 'a5769c7d', 'heroku_ea94c1083a34040');
        $result = $mysqli->query("SELECT * FROM companyinfo") or die($mysqli->error);
        ?>

        <div class="row justify-content-center">
            <table class="table">
                <thead>
                    <tr>
                        <th>Company Name</th>
                        <th>Street Address</th>
                        <th>City</th>
                        <th>State</th>
                        <th>Zip</th>
                        <th>Country</th>
                        <th>Phone</th>
                        <th colspan="2">Action</th>
                    </tr>
                </thead>
                <?php
                while ($row = $result->fetch_assoc()) : ?>
                    <tr>
                        <td><?php echo $row['companyName']; ?></td>
                        <td><?php echo $row['streetAddress']; ?></td>
                        <td><?php echo $row['city']; ?></td>
                        <td><?php echo $row['state']; ?></td>
                        <td><?php echo $row['zip']; ?></td>
                        <td><?php echo $row['country']; ?></td>
                        <td><?php echo $row['phoneNumber']; ?></td>
                        <td>
                            <a href="companyForm.php?edit=<?php echo $row['id']; ?>" class="btn btn-info">Edit</a>
                            <a href="companyForm.php?delete=<?php echo $row['id']; ?>" class="btn btn-danger">Delete</a>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </table>
        </div>
        <form action="" method="POST">
            <label for="">Company Name</label>
            <input type="text" name="companyName" placeholder="Company Name" value="<?php echo $companyName; ?>" required>
            <br>
            <label for="">Company Street Address</label>
            <input type="text" name="streetAddress" placeholder="Company Street" value="<?php echo $streetAddress; ?>" required>
            <br>
            <label for="">Company City</label>
            <input type="text" name="city" placeholder="Company City" value="<?php echo $city; ?>" required>
            <br>
            <label for="">Company State</label>
            <input type="text" name="state" placeholder="Company State" value="<?php echo $state; ?>">
            <br>
            <label for="">Company Zip</label>
            <input type="text" name="zip" placeholder="Company Zip" value="<?php echo $zip; ?>" required>
            <br>
            <label for="">Company Country</label>
            <input type="text" name="country" placeholder="Company Country" value="<?php echo $country; ?>" required>
            <br>
            <label for="">Company Phone Number</label>
            <input type="text" name="phoneNumber" placeholder="Company Phone" value="<?php echo $phoneNumber; ?>" required>
            <br>
            <?php if ($update == true) : ?>
                <button class="btn btn-info" type="submit" name="update">Update</button>
            <?php else : ?>
                <button type="submit" name="submit">Submit</button>
            <?php endif; ?>
        </form>
</body>

</html>