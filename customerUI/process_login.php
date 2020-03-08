<?php
    require_once 'include/autoload.php';
    $data = CallAPI('GET', $customer_url, 'get_customer/', '1');
    var_dump($data);
    if (isset($_POST['email']) and isset($_POST['password'])){

        $email = 'tanjd@hotmail.com';
        $password = 'hello';

        $email = $_POST['email'];
        $password = $_POST['password'];
        $POST_data = [
            "email" => $email,
            "password" => $password
        ];

        $data = CallAPI('POST', $customer_url, 'authenticate', $POST_data);
        if ($data != false) {
            $customer_id = $data->{'customer_id'};
            $_SESSION['customer_id'] = $customer_id;
            // header('Location: index.php');
            // exit();
        }
        else {
            $_SESSION['error'] = $error_message;
            // header('Location: index.php');
            // exit();
        }
    }
?>