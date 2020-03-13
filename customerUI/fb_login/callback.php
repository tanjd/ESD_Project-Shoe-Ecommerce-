<?php
require_once("config.php");
require_once '../include/autoload.php';

try {

    $accessToken = $handler->getAccessToken();
}catch(\Facebook\Exceptions\FacebookResponseException $e){
    echo "Response Exception: ". $e->getMessage();
}catch(\Facebook\Exceptions\FacebookSDKException $e){
    echo "SDK Exception: ". $e->getMessage();
    exit();
}

if (!$accessToken){
    header('Location: test_login.php');
}

$oAuth2Client = $FBObject ->getOAuth2Client();
if (!$accessToken->isLongLived())
    $accessToken = $oAuth2Client->getLongLivedAccessToken($accessToken);

    $response = $FBObject->get("/me?fields=id, name, email", $accessToken);
    $userData = $response->getGraphNode()->asArray();

    $_SESSION['userData'] = $userData;
    $_SESSION['access_token'] = (string) $accessToken;

    $email = $_SESSION['userData']['email'];
    $name = $_SESSION['userData']['name'];
    $POST_data = [
        "name" => $name,
        "email" => $email
    ];

    $data = CallAPI('POST', $customer_url, 'fb_login', $POST_data);
    header('Location: ../index.php');
    exit();

   




?>