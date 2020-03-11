<?php
    require_once 'include/autoload.php';
    
    // start session
    session_start();
     
    if (isset($_SESSION['cart'])){
        // get the product id
        if (isset($_GET['id'])){
            $id = $_GET['id']; 
        }
        // remove the item from the array
        unset($_SESSION['cart'][$id]);
        
        // redirect to product list and tell the user it was added to cart
        header('Location: cart.php');
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
