<?php 
require_once 'include/autoload.php'; 

if (isset($_GET['currency'])){
    $_SESSION['currency'] = $_GET['currency']; 
    header('Location: '.$_SERVER['HTTP_REFERER']); 
    exit(); 
}



?>