<?php
    require_once 'include/autoload.php';

    // session_start(); 

    if (! isset($_SESSION['cart'])){
        $_SESSION['cart'] = []; 
    }

    $from = $_GET['from'];
    

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


    
    // create the selected item
    $selectedItem = []; 
    if ($product != false && $id != ''){

        $selectedItem = [
            'id' => $id,
            'name' => $product->name, 
            'unit_price' => $product->unit_price,
            'quantity' => 1
            ]; 
    }

    // if cart not empty
    if (isset($_SESSION['cart']) && ! empty($_SESSION['cart'])){

        // check if product is already in cart
        foreach ($_SESSION['cart'] as $contentArray){

            
            // product is already in cart
            if (in_array($id, $contentArray)){
                // break;
                $contentArray['quantity'] += 1; 
                $_SESSION['message'] = 'Product is already in cart!'; 
                $_SESSION['header_display'] = TRUE;
                //header("Location: $from"); 
                //exit(); 
            }

            // product is not in cart
            else{
                array_push($_SESSION['cart'], $selectedItem);
                $_SESSION['message'] = 'Product successfully added to cart!'; 
                $_SESSION['header_display'] = TRUE;
                //header("Location: $from"); 
                //exit(); 
            }
        }

        

    }
    
    // if cart empty
    else 
    {
        array_push($_SESSION['cart'], $selectedItem);
        $_SESSION['message'] = 'Product added to cart!';  
        $_SESSION['header_display'] = TRUE;
        header("Location: $from"); 
        exit(); 
    }
var_dump($_SESSION['cart']); 
var_dump($_SESSION['message']); 
?>
