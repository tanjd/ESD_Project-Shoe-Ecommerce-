<?php

require_once('fb_login/config.php');

?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';
require_once 'include/autoload.php';

if(isset($_GET['id'])){

    $main_id = $_GET['id'];
    $sql_update = mysqli_query($con, "UPDATE message SET status=1 WHERE id='$main_id'");
}

?>
<link rel="stylesheet" href="css/login_style.css">
<link rel="stylesheet" href="css/message_style.css">
<link rel="stylesheet" href="css/use.fontawesome.comv5.3.1cssall" \ integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">

<html>
<body>
    <div class = "container" id="table1">
    <div class = "row">
    <table class="table">
    <thead class="thead-dark">
        <tr>
        <th scope="col">S. no</th>
        <th scope="col">Name</th>
        <th scope="col">Message</th>
        <th scope="col">Date</th>
        <th scope="col">Delete</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        $sr_no=1;
        $sql_get = mysqli_query($con, "SELECT * FROM message WHERE status=1");
        while($main_result = mysqli_fetch_assoc($sql_get)):
        
        ?>
        <tr>
        <th scope="row"><?php echo $sr_no++; ?></th>
        <td><?php echo $main_result['name']; ?></td>
        <td><?php echo$main_result['content_message']; ?></td>
        <td><?php echo $main_result['scheduled_date_time']; ?></td>
        <td><a href="delete.php?id=<?php echo $main_result['id'];?>" class="text-danger"><i class="fas fa-trash"></i></a></td>
        </tr>
        <?php endwhile ?>
    </tbody>
    </table>
    </div>
    </div>
</body>
</html>