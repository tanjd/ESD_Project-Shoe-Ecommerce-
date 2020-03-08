<?php
    require_once 'include/autoload.php';

    $data = CallAPI('POST', $customer_url, 'authenticate', $result);
    var_dump($data);
    if (isset($_POST['email']) and isset($_POST['password'])){

        $email = 'tanjd@hotmail.com';
        $password = 'hello';

        $email = $_POST['email'];
        $password = $_POST['password'];
        $result = [
            "email" => $email,
            "password" => $password
        ];

        $data = CallAPI('POST', $customer_url, 'authenticate', $result);
        if ($data != false) {
            $customer_id = $data->{'customer_id'};
            $_SESSION['customer_id'] = $customer_id;
            header('Location: index.php');     //student correct id and pw
            exit();
        }
        else {
            $_SESSION['error'] = $error_message;
            header('Location: index.php');     //student correct id and pw
            exit();
        }
    }
?>