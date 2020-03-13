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
            'id' => $product->id,
            'name' => $product->name, 
            'unit_price' => $product->unit_price,
            'quantity' => 1
            ]; 
    }

    // if cart not empty
    if (isset($_SESSION['cart'])){

        
        foreach ($_SESSION['cart'] as $contentArray){

            // product is already in cart
            if (in_array($id, $contentArray)){
                $_SESSION['message'] = 'Product is already in cart!'; 
                break; 
                header("Location: product.php?product_id=$id"); 
                exit(); 
            }

            // product is not in cart
            else{
                $_SESSION["cart"][] = $selectedItem;
                $_SESSION['message'] = 'Product successfully added to cart!'; 
                header("Location: product.php?product_id=$id"); 
                exit(); 
            }
        }

        

    }
    
    // if cart empty
    else 
    {
        $_SESSION['cart'] = $selectedItem;
        $_SESSION['message'] = 'Product added to cart!';  
        header("Location: product.php?product_id=$id"); 
        exit(); 
    }


?>
