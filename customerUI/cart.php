<?php
require_once 'include/autoload.php';

require_once 'template/head.php';
require_once 'template/header.php';


$cart_total = 0;
?>


<main role="main" class="container">
    <div class="starter-template">
        <p class="lead">
            <form action='checkout.php' method='post'></form>
            <h2>My Shopping Cart </h2>

            
            
            <?php

            // var_dump($_SESSION['cart']);
            
            if ($is_loggedin){
                if (!isset($_SESSION['cart']) or $_SESSION['cart'] == []) {
                    echo '<div style="margin-left: 8px; font-size: 1.75em;">
                    <span class="error text-danger span-error">Your cart is empty. Start shopping now!</span>
                    </div> ';
                } else {
    
                    echo "<table class='table table-hover'>";
                    echo "<form action='process_update_cart.php' method='post'>"; 
                    echo "<tr>
                                <th>Name</th>
                                <th>Price</th>
                                <th>Quantity</th>
                                <th></th>
                            </tr>";
            
        

            


                // display items in cart

                foreach ($_SESSION['cart'] as $contentArray) {
                    $id = $contentArray['id'];
                    $name = $contentArray['name'];
                    $unit_price = number_format($contentArray['unit_price'], 2, '.', ',');
                    $quantity = $contentArray['quantity']; 

                    echo "<tr>
                        <td>$name</td>
                        <td>$$unit_price</td>
                        <td><input type='number' class='form-control' size = '20' name='item[$id]' value='$quantity' min='1' style = 'width: 150px'>
                            </td>
                        <td><a href = 'process_remove_from_cart.php?id={$id}'>Remove</a></td>
                    </tr>";

                    $cart_total += $unit_price * $quantity;
                    $cart_total = number_format($cart_total, 2, '.', ',');
                }
            // var_dump($_SESSION['cart']);    
            ?>
                <tr>
                    <td colspan='2'></td>
                    <td>
                            <input type='submit' name='submit' value = 'Update Cart' class='btn btn-dark'>
                        </form>
                    </td>
                    <td></td>
                </tr>


                <tr>
                    <th colspan='2'>Total:</th>
                    <th colspan = '2'><?php echo "\$$cart_total" ?></th>
                </tr>

                <tr>
                    <td colspan = '4'></td>
                </tr>

                <tr>
                    <td colspan='4'><input type= 'button' class='btn btn-dark' value='Checkout' onclick ="location.href='process_checkout.php'"></td>
                </tr>
                </table> 
                <?php }
            }
                
                else{
                    echo '<div style="margin-left: 8px; font-size: 1.75em;">
                        <span class="error text-danger span-error">Please log in to start shopping now!</span>
                        </div> ';
                }
    ?>

        </p>
    </div>



    <?php
    // Checkout Cart
    function outputCart_error()
    {
        if (isset($_SESSION['cart_error'])) {
            echo "<div style='margin-left: 8px; font-size: 1.75em;'>";
            echo "Checkout failed. Please try again.";
            echo "</div>";
        }
    }

    function outputCart_success()
    {
        if (isset($_SESSION['success'])) {
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