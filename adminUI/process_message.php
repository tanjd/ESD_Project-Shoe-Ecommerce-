<?php
require_once 'include/autoload.php';

if (isset($_POST['submit1'])) {

    $POST_data = [
        "message" => $_POST['message']
    ];

    $data = CallAPI('POST', $message_url, 'broadcast_message', $POST_data);
    var_dump($data);
    $status = checkSuccessOrFailure($data);
    if ($status != false) {
        // $customer_id = $data->{'customer_id'};
        // $_SESSION['customer_id'] = $customer_id;
        header('Location: index.php');
        exit();
    } else {
        if (isset($data->{'message'})) {
            $_SESSION['error'] = $data->{'message'};
        } else {
            //However, autoload should handle this...
            $_SESSION['error'] = 'Server is temporarily unavailable';
        }
        header('Location: send_message.php');
        exit();
    }
}

if (isset($_POST['submit2'])) {

    $POST_data = [
        "message" => $_POST['message2'],
        "category_id"=> $_POST['categories1']
    ];
    var_dump($POST_data);

    $data = CallAPI('POST', $message_url, 'send_message_by_category', $POST_data);
    var_dump($data);
    $status = checkSuccessOrFailure($data);
    if ($status != false) {
        
        header('Location: index.php');
        exit();
    } else {
        if (isset($data->{'message'})) {
            $_SESSION['error'] = $data->{'message'};
        } else {
            //However, autoload should handle this...
            $_SESSION['error'] = 'Server is temporarily unavailable';
        }
        header('Location: send_message.php');
        exit();
    }
}
?>