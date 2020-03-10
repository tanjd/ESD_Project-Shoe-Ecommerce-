<?php
    require_once 'include/autoload.php';
    require_once 'template/head.php';
    require_once 'template/header.php';

    $cart = []; 
    if (isset($_SESSION['cart']))
    {
        $cart = $_SESSION['cart'];
    }

    
    $action = isset($_GET['action']) ? $_GET['action'] : "";
    echo "<div class='col-md-12'>";
        if($action=='removed'){
            echo "<div class='alert alert-info'>";
                echo "Product was removed from your cart!";
            echo "</div>";
        }
        else if($action=='quantity_updated'){
            echo "<div class='alert alert-info'>";
                echo "Product quantity was updated!";
            echo "</div>";
        }
    echo "</div>";

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

                if ($cart == []){
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
                    foreach($cart as $cart_content => $contentArray)
                    {
                        $id = $contentArray['id'];
                        $name = $contentArray['name'];
                        $unit_price = $contentArray['unit_price'];
                        $quantity = $contentArray['quantity'];

                        echo "<tr>
                                <td>$id</td>
                                <td>{$name}</td>
                                <td>{$unit_price}</td>
                                <td>$quantity</td>
                                <td><input type='hidden' name='cart_items[]' value='$id, $name, $unit_price, $quantity'></td>
                                <td><a href = 'cart_remove_item.php?id={$contentArray['id']}&title=&name={$contentArray['name']}&location=cart&quantity={$quantity}'>Remove</a></td>
                            </tr>";

                        $cart_total += $unit_price * $quantity; 
                        $cart_total = round($cart_total, 2); 
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