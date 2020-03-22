<?php

var_dump($_GET['id']);
    
require_once 'include/autoload.php';


$POST_data = [
    "message" => $_POST['message']
];

$data = CallAPI('GET', $message_url, 'broadcast_message', $POST_data);
var_dump($data);
    
?>