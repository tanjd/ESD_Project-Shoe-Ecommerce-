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
            echo 'error in removing item'; 
        }
    }

        

        

    else{
        echo 'nothing in session cart'; 

    }

    
    /*

    if (isset($_GET['course']) and isset($_GET['section']) and isset($_GET['title']) and isset($_GET['location']) and isset($_GET['school'])) {
        $course = $_GET['course'];
        $section = $_GET['section'];
        $title = $_GET['title'];
        $school = $_GET['school'];
        if($_GET['location'] == 'cart'){
            $url = "Location: cart.php";
        }
        else {
            $url = "Location: course_sections.php?course={$course}&title={$title}&school={$school}";
        }
        
        
        if (isset($_SESSION['cart'])){
            if (!isEmpty($_SESSION['cart'])){
                //echo '$_SESSION[cart is combined]';
                foreach($_SESSION["cart"] as $course_section => $sectionArray) {
                    //var_dump($course_section);
                    //var_dump($v);
                    if (($sectionArray['course'] == $course) and ($sectionArray['section'] == $section)){
                        unset($_SESSION["cart"][$course_section]);
                    }
                        				
                    if(empty($_SESSION["cart"]))
                        unset($_SESSION["cart"]);
                }

                header($url);
                exit();

            }
            //cart is empty, unset shopping cart
            else {
                //echo '$_SESSION[cart is empty]';
                unset($_SESSION["cart"]);
                header($url);
                exit();
            }
            //var_dump($_SESSION);

        }
        else{
            //echo '$_SESSION[cart doesnt exist]';
            //var_dump($_SESSION);
            header($url);
            exit();
        }
    } */
?>
