<?php
    require_once 'include/autoload.php';

    
    // if there is no session for cart --> create one
    if (! isset($_SESSION['cart'])){
        $_SESSION['cart'] = []; 
    }

    // get product id, name, price, quantity
    $product = false; 
    $id = ''; 

    if (isset($_GET["product_id"])) {

        $GET_data = [
            "product_id" => $_GET["product_id"]
        ];
    
        $product_data = CallAPI('GET', $product_url, 'get_product/', $GET_data);
        $product_status = checkSuccessOrFailure($product_data);
        if ($product_status != false) {
            $product = $product_data->{'product'};
        } 
        /*else {
            $product = false;
        }*/
    }

    // create the selected item
    $selectedItem = []; 
    if ($product != false){
        $id = $_GET['product_id'];

        $selectedItem = [
            $id => [
                'name' => $product->name, 
                'unit_price' => $product->unit_price,
                'quantity' => 1
            ]
            ]; 
    }

    // if cart not empty
    if (isset($_SESSION['cart'])){

        // product is already in cart
        if (array_key_exists($id, $_SESSION['cart'])){
            echo'<script Type="javascript">alert("Product is already in cart!")</script>'; 
            header("Location: {$product_url}"); 
        }

        // product is not in cart
        else{
            $_SESSION["cart"] = array_merge($_SESSION["cart"],$selectedItem);
            echo'<script Type="javascript">alert("Product added to cart!")</script>'; 
            header("Location: {$product_url}"); 
        }

    }
    
    // if cart empty
    else 
    {
        $_SESSION['cart'] = $selectedItem;
        echo'<script Type="javascript">alert("Product added to cart!")</script>';  
        header("Location: {$product_url}"); 
    }


?>
