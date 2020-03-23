<?php
require_once 'include/autoload.php';

if (isset($_POST['submit']) && isset($_SESSION['cart'])){

    if (isset($_POST['item'])){
        $updated_cart_items = $_POST['item']; 
    }

    else {
        $_SESSION['message'] = 'An error occured. Please try again!'; 
    }
    
}

else {
    $_SESSION['message'] = 'An error occured. Please try again!'; 
}

$temp_cart = []; 

foreach ($updated_cart_items as $id => $quantity){
    
    // get product id, name, price, quantity from database
    $product = false; 
    $GET_data = ['product_id' => $id]; 

    $product_data = CallAPI('GET', $product_url, 'get_product/', $GET_data);
    $product_status = checkSuccessOrFailure($product_data);
    if ($product_status != false) {
        $product = $product_data->{'product'};
    }
    
    $temp_item = []; 
    if ($product != false && $id != ''){

        $temp_item = [
            'id' => $id,
            'name' => $product->name, 
            'unit_price' => $product->unit_price,
            'quantity' => $quantity
            ]; 

        // append item array to temp_cart
        array_push($temp_cart, $temp_item); 
    }

}

// overwrites data in SESSION cart with temp_cart
$_SESSION['cart'] = $temp_cart; 
$_SESSION['message'] = 'Cart is successfully updated!'; 
$_SESSION['header_display'] = TRUE;
header('Location: cart.php'); 
exit(); 

var_dump($_SESSION['cart']); 






?>