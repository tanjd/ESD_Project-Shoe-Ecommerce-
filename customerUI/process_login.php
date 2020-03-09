<?php
require_once 'include/autoload.php';

if (isset($_POST['input_email']) and isset($_POST['input_password'])) {

    $POST_data = [
        "email" => $_POST['input_email'],
        "password" => $_POST['input_password']
    ];

    $data = CallAPI('POST', $customer_url, 'authenticate', $POST_data);
    $status = checkSuccessOrFailure($data);
    if ($status != false) {
        $customer_id = $data->{'customer_id'};
        $_SESSION['customer_id'] = $customer_id;
        header('Location: index.php');
        exit();
    } else {
        if (isset($data->{'message'})) {
            $_SESSION['error'] = $data->{'message'};
        } else {
            //However, autoload should handle this...
            $_SESSION['error'] = 'Server is temporarily unavailable';
        }
        header('Location: login.php');
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}

?>