<?php
require_once 'include/autoload.php';

?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';


?>


<main role="main" class="container">
    <div class="starter-template">
        <p class="lead"><h2>Your payment is Successful! Thank you for shopping with us! :-)</h2></p>
        <a href="http://localhost/esd_project/customerUI/index.php">Click here to shop more!</a>          
        <br></br>              
        <h2>RECEIPT</h2>

        <?php   
                $order_data = [ 
                "cart" => $_SESSION['cart'],
                "id" => $_SESSION['customer_id'],
                "address" => $_SESSION['delivery']];

                $cart_total = 0;
                echo "<table class='table table-hover'>";
                echo "<tr>
                        <th>Name</th>
                        <th>Price</th>
                        </tr>";
                $cart_total = 0;
                foreach ($_SESSION['cart'] as $contentArray) {
                    $name = $contentArray['name'];
                    $unit_price = number_format($contentArray['unit_price'], 2, '.', ',');

        
                    echo "<tr>
                                <td>$name</td>
                                <td>$$unit_price</td>
                            </tr>";
                    $cart_total += $unit_price * $quantity;
                }     
        ?>
        <tr>
            <th colspan='1'>Total</th>
            <th colspan='1'><?php echo "\$$cart_total" ?></th>
        </tr>

        <tr>
            <?php 
                echo "<tr><td></td></tr>";
                $delivery = $_SESSION['delivery'];
                echo"<th> Delivery Location </th>";
                echo "<th>$delivery</th>";
                echo "<tr><td></td></tr>";
                echo "<tr><th>Payment</th>
                      <th>Payment done by paypal is successful</th></tr>";
            ?>
        </tr>



    </div>

<?php
;

if (isset($_SESSION['cart']) and isset($_SESSION['customer_id']) and isset($_SESSION['delivery'])) {

    $order_data = [
        "cart" => $_SESSION['cart'],
        "id" => $_SESSION['customer_id'],
        "address" => $_SESSION['delivery']
    ];

    $data = CallAPI('POST', $order_url, 'create_order', $order_data);
    $status = checkSuccessOrFailure($data);
    if ($status != false) {
        //session_destroy();
        } 
}else{
    header('Location" process_payment.php');
}
?>




</main>
<?php
//require_once 'template/footer.php';
?>