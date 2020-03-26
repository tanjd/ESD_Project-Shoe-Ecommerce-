<?php
require_once 'include/autoload.php';

if (isset($_POST['input_email']) and isset($_POST['input_password'])) {

    if(($_POST['input_email']=='admin') and ($_POST['input_password']) == 'password'){
        $_SESSION['admin'] = 'Admin'; 
        header('Location: index.php');
        exit();
    } else {
        if (($_POST['input_email'])!='admin' or ($_POST['input_password'])!='password') {
            $_SESSION['error'] = 'Incorrect Username or password';
        } 
        header('Location: login.php');
        exit();
    }
}
else {
    header('Location: login.php');
    exit();
}

?>