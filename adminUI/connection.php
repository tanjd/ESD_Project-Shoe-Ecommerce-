<?php

$con = mysqli_connect("localhost", "root", "", "notify");

if ($con){

    echo "";
}
else{
    echo mysqli_error($con);
}

?>