<?php
require_once 'include/autoload.php';
if (isset($_GET['category_id']) and isset($_GET['customer_id']) and isset($_GET['method'])) {
    $POST_data = [
        "category_id" => $_GET['category_id'],
        "customer_id" => $_GET['customer_id']
    ];
    $method = $_GET['method'];
    $data = CallAPI('POST', $customer_url, $method, $POST_data);
    $status = checkSuccessOrFailure($data);
    if ($status != false) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    } else {
        $_SESSION['error'] = $data->{'message'};
        header('Location: ' . $_SERVER['HTTP_REFERER']);
        exit();
    }
} else {
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    exit();
}
?>