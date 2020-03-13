<?php
session_start();
require_once('Facebook/autoload.php');

$FBObject = new \Facebook\Facebook([
    'app_id' => '203646284208498',
    'app_secret' => '58e00718b17db48d789a8802421550df',
    'default_graph_version' => 'v2.10'
]);


$handler = $FBObject -> getRedirectLoginHelper();
?>