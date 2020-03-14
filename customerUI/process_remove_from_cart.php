<?php
    require_once 'include/autoload.php';
    
    $temp_cart = []; 
     
    if (isset($_SESSION['cart'])){

        // get the product id
        if (isset($_GET['id'])){
            $id = $_GET['id']; 
        
            // check each item in cart
            foreach ($_SESSION['cart'] as $contentArray){

                // if id of item is not the GET['id'] --> store in temp cart --> overwrite $_SESSION['cart']
                if ($contentArray['id'] != $id){
                    array_push($temp_cart, $contentArray); 
                }
            }

            // overwrites $_SESSION['cart']
            $_SESSION['cart'] = $temp_cart; 
            header('Location: cart.php'); 
            exit(); 
        }

        else{
            $_SESSION['message'] = 'Error in removing item; Please try again!';  
        }
    }

        

        

    else{
        $_SESSION['message'] = 'Error in removing item; Please try again!';   
    }

    
?>
