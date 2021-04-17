<?php
require_once 'assets/functions.php';
require_once 'php-files/employees.php';
printHead("Manage Employees | Buggy - Let's Code Together");

?>

<body>
    <?php printSidebar(getAccountType($_SESSION['userID']), "employees"); ?>

    <div class="main">
        <?php printHeader($_SESSION['userID']);
        ?>
        <h2 class='subhead'>Employee Management</h2 class='subhead'>
            <?php
                $employeeList = getEmployees();
                foreach($employeeList as $employee) {
                    $id = $employee['id'];
                    $fname = $employee['firstName'];
                    $lname = $employee['lastName'];
                    print("<div class='employee'><h3>$fname $lname</h3><a id='$id' class='button manager'>Give Management Permissions</a></div>");
                }
            ?>

        <div>
    </div>

    <?php printFooter("basic"); ?>
    <script>
    $('.manager').click(function(){
        var id = $(this).attr('id');
        $.ajax({
            url: '/scripts/makeManager.php',
            type: 'post',
            dataType: 'JSON',
            data: {"id": id},
            success: function(response) {
                window.location.href = "";
            }
        });
    });


    </script>
</body>

</html>
