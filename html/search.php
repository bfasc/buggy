<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <!-- CSS only -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-giJF6kkoqNQ00vy+HMDP7azOuL0xtbfIcaT9wjKHr8RbDVddVHyTfAAsrekwKmP1" crossorigin="anonymous">
    <!-- JavaScript Bundle with Popper -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.0-beta1/dist/js/bootstrap.bundle.min.js" integrity="sha384-ygbV9kiqUc6oa4msXn9868pTtWMgiQaeYH7/t7LECLbyPA2x65Kgf80OJFdroafW" crossorigin="anonymous"></script>
    <title>Search</title>
</head>

<body>
    <?php require_once '../php/processSearch.php'; ?>
    <h1>Search for tickets</h1>
    <form action="" method="POST">
        <label for="">Search Tickets</label>
        <input type="text" name="search" placeholder="search">
        <br>
        <h2>Search Filters</h2>
        <input type="checkbox" id="completed" name="completed" value="Completed">
        <label for="completed">Completed</label>
        <br>
        <input type="checkbox" id="progress" name="progress" value="Progress">
        <label for="progress">In Progress</label>
        <br>
        <input type="checkbox" id="approved" name="filter[]" value="1">
        <label for="approved">Approved</label>
        <br>
        <input type="checkbox" id="rejected" name="filter[]" value="0">
        <label for="rejected">Rejected</label>
        <br>
        <button type="submit" name="submit">Submit</button>
    </form>
</body>

</html>