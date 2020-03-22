<?php
    require_once 'include/autoload.php';

    if (isset($_SESSION['error'])) {
        unset($_sESSION['error']);
    }
    if (isset($_SESSION['customer_id']))
        unset($_SESSION['customer_id']);

    //clear all session
    session_unset();

    //destroy, cant create new session
    session_destroy();

    //wipe out all memories when your browser makes a new http request

    header('location:login.php');
    return;
?>