<?php
    require_once 'include/autoload.php';


    if (! isset($_SESSION['cart'])){
        $_SESSION['cart'] = []; 
    }

    $from = $_GET['from'];
    

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

  
    $selectedItem = []; 
    if ($product != false && $id != ''){

        $selectedItem = [
            'id' => $id,
            'name' => $product->name, 
            'unit_price' => $product->unit_price,
            'quantity' => 1
            ]; 
    }


    
   
    if (isset($_SESSION['cart']) && ! empty($_SESSION['cart'])){

        $cartItemId = []; 
        foreach ($_SESSION['cart'] as $contentArray){
            array_push($cartItemId, $contentArray['id']); 
        }


    
        if (! in_array($id, $cartItemId)){
            array_push($_SESSION['cart'], $selectedItem);
            $_SESSION['message'] = 'Product successfully added to cart!'; 
            $_SESSION['header_display'] = TRUE;
            header("Location: $from"); 
            exit(); 
        }

            
        else{
            $_SESSION['message'] = 'Product is already in cart! To update the quantity, please go to cart'; 
            $_SESSION['header_display'] = TRUE;
            header("Location: $from"); 
            exit(); 
        }    

    }
    
    
    else 
    {
        array_push($_SESSION['cart'], $selectedItem);
        $_SESSION['message'] = 'Product successfully added to cart!';  
        $_SESSION['header_display'] = TRUE;
        header("Location: $from"); 
        exit(); 
    }

?>
