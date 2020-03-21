<?php

require_once 'include/autoload.php';

if (isset($_SESSION['customer_id'])) {

    $customer_id = $_SESSION['customer_id'];

    $POST_data = [
        "customer_id" => $customer_id,
    ];
    $data = CallAPI('GET', $customer_url, 'get_customer/', $POST_data);
    $data_status = checkSuccessOrFailure($data);
    if ($data_status != false) {
        $customer = $data->{'customer'};
    } else {
        $customer = false;
    }

    $is_loggedin = true; 

}

// check if user is logged in/session expired
if (! $is_loggedin){
    $_SESSION['message'] = 'Session expired, please log in again.'; 
    header('Location: login.php'); 
    exit(); 
}
else{

    if (isset($_SESSION['cart']) && $_SESSION['cart'] != []){
        header('Location: process_payment.php'); 
        exit(); 
    }

    else{
        $_SESSION['message'] = 'Your cart is empty. Start shopping now!'; 
        header('Location: cart.php'); 
        exit();              
    }
}



?>