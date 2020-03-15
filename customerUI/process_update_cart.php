<?php
require_once 'include/autoload.php';

if (isset($_POST['submit']) && isset($_SESSION['cart'])){

    if (isset($_POST['item'])){
        $updated_cart_items = $_POST['item']; 
        var_dump($updated_cart_items); 
    }

    else {
        echo 'PROBLEM WITH POST ITEM'; 
    }
    
}

else {
    echo 'PROBLEM WITH SUBMIT BUTTON'; 
}

// get product id, name, price, quantity
$product = false; 
$id = ''; 

if (isset($_GET["product_id"])) {
    $id = $_GET['product_id']; 
    $GET_data = [
        "product_id" => $_GET["product_id"]
    ];

    $product_data = CallAPI('GET', $product_url, 'get_product/', $GET_data);
    $product_status = checkSuccessOrFailure($product_data);
    if ($product_status != false) {
        $product = $product_data->{'product'};
    } 
}


?>