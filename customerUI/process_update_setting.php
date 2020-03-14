<?php
require_once 'include/autoload.php';

if (isset($_POST['email']) and isset($_POST['address']) and isset($_POST['postal_code']) and isset($_POST['telegram_id']) and isset($_POST['telegram_setting']) and isset($_POST['email_setting'])) {
    if ($_POST['telegram_setting'] == 'true' and $_POST['telegram_id'] == ''){
        $_SESSION['error'] = 'Please enter a telegram ID';
        header('Location: account_settings.php');
        exit();
    }
    if ($_POST['telegram_setting'] == 'true'){
        $telegram_setting = true;
    } else {
        $telegram_setting = false;
    }
    if ($_POST['email_setting'] == 'true'){
        $email_setting = true;
    } else {
        $email_setting = false;
    }
    $POST_data = [
        "customer_id" => $_SESSION['customer_id'],
        "email" => $_POST['email'],
        "address" => $_POST['address'],
        "postal_code" => $_POST['postal_code'],
        "telegram_id" => $_POST['telegram_id'],
        "telegram_setting" => $telegram_setting,
        "email_setting" => $email_setting
    ];
    $data = CallAPI('POST', $customer_url, 'update_setting', $POST_data);
    $status = checkSuccessOrFailure($data);
    if ($status != false) {
        header('Location: account_settings.php');
        exit();
    } else {
        $_SESSION['error'] = $data->{'message'};
    }
} else {
    header('Location: index.php');
    exit();
}
?>