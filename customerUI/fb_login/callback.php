<?php
require_once("config.php");
require_once '../include/autoload.php';

try {

    $accessToken = $handler->getAccessToken();
} catch (\Facebook\Exceptions\FacebookResponseException $e) {
    echo "Response Exception: " . $e->getMessage();
} catch (\Facebook\Exceptions\FacebookSDKException $e) {
    echo "SDK Exception: " . $e->getMessage();
    exit();
}

if (!$accessToken) {
    header('Location: ../login.php');
}

$oAuth2Client = $FBObject->getOAuth2Client();
if (!$accessToken->isLongLived())
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);

$response = $FBObject->get("/me?fields=id, name, email", $accessToken);
$userData = $response->getGraphNode()->asArray();

$name = $userData['name'];
$email = $userData['email'];

$POST_data = [
    "name" => $name,
    "email" => $email
];
$data = CallAPI('POST', $customer_url, 'fb_login', $POST_data);
$status = checkSuccessOrFailure($data);
if ($status != false) {
    $customer_id = $data->{'customer_id'};
    $_SESSION['customer_id'] = $customer_id;
    header('Location: ../index.php');
    exit();
} else {
    if (isset($data->{'message'})) {
        $_SESSION['error'] = $data->{'message'};
    } else {
        //However, autoload should handle this...
        $_SESSION['error'] = 'Server is temporarily unavailable';
    }
    header('Location: ../login.php');
    exit();
}
?>