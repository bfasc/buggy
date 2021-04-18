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
            <div class="cd-popup">
                <div class="cd-popup-container">
                </div>
            </div>
            <?php
                $employeeList = getEmployees();
                foreach($employeeList as $employee) {
                    $id = $employee['id'];
                    $fname = $employee['firstName'];
                    $lname = $employee['lastName'];
                    print("<div class='employee'><h3>$fname $lname</h3><a id='$id' class='button manager'>Give Management Permissions</a><a id='$id' class='button remove'>Remove From Company</a></div>");
                    //TODO: Remove from company
                }
            ?>

        <div>
    </div>

    <?php printFooter("basic"); ?>
    <script>
    $(document).ready(function(){
        //close popup
        $('.cd-popup').on('click', function(event){
            if( $(event.target).is('.cd-popup-close') || $(event.target).is('.cd-popup') ) {
                event.preventDefault();
                $(this).removeClass('is-visible');
            }
        });
        //close popup when clicking the esc keyboard button
        $(document).keyup(function(event){
            if(event.which=='27'){
                $('.cd-popup').removeClass('is-visible');
            }
        });
    });
    function closePopup(){
        $('.cd-popup').removeClass('is-visible');
    }
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
    $('.remove').click(function(){
        event.preventDefault();
        $('.cd-popup').addClass('is-visible');
        var id = $(this).attr('id');
        $('.cd-popup-container').html("<p>Are you sure you'd like to remove this user from your company?</p>"+
        "<ul class='cd-buttons'>"+
            "<li onclick=\"removeAccount("+id+")\"><a>Yes</a></li>"+
            "<li onclick=\"closePopup()\"><a>No</a></li>"+
        "</ul>"+
        "<a class='cd-popup-close img-replace'></a>");
    });
    function removeAccount(id) {
        $.ajax({
            url: '/scripts/removeFromCompany.php',
            type: 'post',
            dataType: 'JSON',
            data: {"id": id},
            success: function(response) {
                window.location.href = "";
            }
        });
    }


    </script>
</body>

</html>
