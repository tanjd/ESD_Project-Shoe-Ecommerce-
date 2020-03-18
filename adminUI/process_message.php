<?php
require_once 'include/autoload.php';

if (isset($_POST['message'])) {

    $POST_data = [
        "message" => $_POST['message']
    ];
    
    var_dump($_POST['message']);
    $data = CallAPI('POST', $message_url, 'broadcast_message', $POST_data);
    var_dump($data);
    $status = checkSuccessOrFailure($data);
    if ($status != false) {
        $customer_id = $data->{'customer_id'};
        $_SESSION['customer_id'] = $customer_id;
        // header('Location: index.php');
        // exit();
    } else {
        if (isset($data->{'message'})) {
            $_SESSION['error'] = $data->{'message'};
        } else {
            //However, autoload should handle this...
            $_SESSION['error'] = 'Server is temporarily unavailable';
        }
        // header('Location: send_message.php');
        // exit();
    }
} 
?>