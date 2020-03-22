
<?php
require_once 'include/autoload.php';

if (isset($_GET["message_id"])) {
    $id = $_GET['message_id']; 
    $GET_data = [
        "message_id" => $_GET["message_id"]
    ];
    
    $message_data = CallAPI('GET', $message_url, 'update_message_status/', $GET_data);
    $message_status = checkSuccessOrFailure($message_data);
    if ($message_status != false) {
        
        header('Location: read_msg.php');
        exit();
    } 
}



?>