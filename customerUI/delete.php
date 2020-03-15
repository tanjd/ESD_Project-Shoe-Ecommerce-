<?php
$con = mysqli_connect("localhost", "root", "", "notify");

if(isset($_GET['id'])){

    $delete_id = $_GET['id'];


    $sql_delete =mysqli_query($con, "DELETE FROM message where id='$delete_id'");
    if($sql_delete){
        header('location: read_msg.php');
        
    }
    else{
        echo mysqli_error($con);
    }
}

?>