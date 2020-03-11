<?php
    require_once 'include/autoload.php';
    require_once 'template/head.php';
    require_once 'template/header.php';

function console_log($output, $with_script_tags = true) {
    $js_code = 'console.log(' . json_encode($output, JSON_HEX_TAG) . 
');';
    if ($with_script_tags) {
        $js_code = '<script>' . $js_code . '</script>';
    }
    echo $js_code;}

// $_SESSION["cart"] = 
//     $_cart = [
//         ["id"=>22, "quantity"=>1, "price"=>75],
//         ["id"=>33, "quantity"=>1, "price"=>89]
//             ];

$_SESSION["cart"] = [
    22 => ["name" => "Snakeskin1","quantity"=>1, "unit_price"=>75],
    33 => ["name" => "Snakeskin2", "quantity"=>1, "unit_price"=>89]];

$_SESSION['customer_id'] = 
    $customer_id = 123 ;

if (isset($_SESSION['cart']) and isset($_SESSION['customer_id'])) {

    $order_data = [
        "cart" => $_SESSION['cart'],
        "id" => $_SESSION['customer_id']
    ];

    $data = CallAPI('POST', $order_url, 'create_order', $order_data);
    $status = checkSuccessOrFailure($data);

    console_log($order_data);
    print_r($order_data);
    console_log($data);
    #print_r($data); 

    if ($status != false) {
        //if data is sent successfully to order.py then the ui page changes
        header('Location: delivery.php');
        session_destroy();
    } 
    else{
    //error msg in the UI     
    }
} 

    // $cart = []; 
    // if (isset($_SESSION['cart']))
    // {
    //     $cart = $_SESSION['cart'];
    // }

    

    $cart_total = 0; 

?>

<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>

<div class="starter-template">
        <p class="lead">
        <form action = 'checkout.php' method = 'post'></form>
        <?php
                echo "<h2>My Shopping Cart </h2>";

                if (! isset($_SESSION['cart'])){
                    echo '<div style="margin-left: 8px; font-size: 1.75em;">
                    <span class="error text-danger span-error">Your cart is empty. Start shopping now!</span>
                    </div> ';
                }
                
                else {

                    echo "<table class='table table-hover'>";
                        echo "<tr>
                                <th>ID</th>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th></th>
                                <th></th>
                        </tr>"; 
                    foreach($_SESSION['cart'] as $id_key => $contentArray)
                    {
                        $id = $id_key; 
                        $name = $contentArray['name'];
                        $unit_price = number_format($contentArray['unit_price'], 2, '.', ' ');
                        $quantity = $contentArray['quantity'];

                        echo "<tr>
                                <td>$id</td>
                                <td>$name</td>
                                <td>$$unit_price</td>
                                <td>$quantity</td>
                                <td><input type='hidden' cart_item[] = $id></td>
                                <td><a href = 'process_remove_from_cart.php?id={$id}'>Remove</a></td>
                            </tr>";

                        $cart_total += $unit_price * $quantity; 
                        $cart_total = number_format($cart_total, 2, '.', ' '); 
                    }

                        echo "<tr>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                                <td></td>
                            </tr>
                        
                        
                            <tr>
                                <th colspan = '3'>Total:</th>
                                <th colspan = '3'>$$cart_total</th>
                            </tr>

                        
                            <tr>
                                <td colspan = '6'><input class='btn btn-primary btn-sm' type='submit' value='Checkout'></td>
                            </tr>
                            </table>";
                }


                /*
                if ($success)
                {
                    outputCart_success();
                    $success = 0;
                    unset($_SESSION['success']);
                }
                
                if ($error)
                {
                    outputCart_error();
                    $error = 0;
                    unset($_SESSION['cart_error']);
                }
                */
            

        function outputCart_error()
        {
            if (isset($_SESSION['cart_error'])){
                echo "<div style='margin-left: 8px; font-size: 1.75em;'>";
                echo "Checkout failed. Please try again."; 
                echo "</div>"; 
            }
        }

        function outputCart_success()
        {
            if (isset($_SESSION['success']))
            {
                echo "<div style='margin-left: 8px; font-size: 1.75em;'>";
                echo "Checkout successful, order created."; 
                echo "</div>";
            }
                
                
            
        }
        
    ?>
        </p></form>
    </div>



</body>

<?php
require_once 'template/footer.php';
?>
</html>