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


if (isset($_SESSION['cart']) and isset($_SESSION['customer_id'])) {

    $order_data = [
        "cart" => $_SESSION['cart'],
        "id" => $_SESSION['customer_id']
    ];

    $data = CallAPI('POST', $order_url, 'create_order', $order_data);
    $status = checkSuccessOrFailure($data);

    // console_log($order_data);
    //print_r($order_data);
    console_log($data);
    //print_r($data); 

    if ($status != false) {
        //if data is sent successfully to order.py then the ui page changes
        #header('Location: delivery.php');
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


<main role="main" class="container">
    <div class="starter-template">
        <p class="lead">
            <form action = 'checkout.php' method = 'post'></form>
            <h2>My Shopping Cart </h2>
            <?php
            if (! isset($_SESSION['cart']) or $_SESSION['cart'] == []){
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
                        </tr>"; 
        
            
            
                // display items in cart

                foreach($_SESSION['cart'] as $contentArray){
                var_dump($contentArray); 
                $id = $contentArray['id']; 
                $name = $contentArray['name'];
                $unit_price = number_format($contentArray['unit_price'], 2, '.', ' ');

                if (isset($_POST['submit']) && isset($_POST['quantity'][$id])) {
                    $quantity = $_POST['quantity'][$id];
                } else { 
                    $quantity = 1;
                }

                echo "<tr>
                        <td>$id</td>
                        <td>$name</td>
                        <td>$$unit_price</td>
                        <td><input type='number' class='form-control' size = '20' name='quantity[$id]' value='$quantity' min='1' style = 'width: 150px'>
                            </td>
                        <td><a href = 'process_remove_from_cart.php?id={$id}'>Remove</a></td>
                    </tr>";

                $cart_total += $unit_price * $quantity; 
                $cart_total = number_format($cart_total, 2, '.', ' '); 
            }


            ?>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td><form action='' method='post'>
                    <input type='submit' name='submit' class='btn btn-primary btn-sm'>
                    </form></td>
                <td></td>
            </tr>

            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>

            <tr>
                <th colspan = '2'>Total:</th>
                <th>$<?php$cart_total ?></th>
                <th></th>
                <th></th>
            </tr>

            <tr>
                <td colspan = '5'><input class='btn btn-primary btn-sm' type='submit' value='Checkout'></td>
            </tr>
        </table> <?php } ?>    

        </p>
        </div>

        <?php
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

</main>
        
        <?php
        

require_once 'template/footer.php';
?>