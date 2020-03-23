<?php 
require_once 'include/autoload.php'; 

if (isset($_GET['currency']) && isset($_GET['from'])){
    $_SESSION['currency'] = $_GET['currency']; 
    header('Location: '.$_SERVER['PHP_SELF']); 
    exit(); 
}



?>