<?php 
    require_once 'include/autoload.php';

    if (isset($_SESSION['cart']) and isset($_SESSION['customer_id'])) {
        
        //var_dump($_SESSION['cart']);

        $order_data = [
            "cart" => $_SESSION['cart'],
            "id" => $_SESSION['customer_id']
        ];
    
        $data = CallAPI('POST', $order_url, 'create_order', $order_data);
        $status = checkSuccessOrFailure($data);
    
        if ($status != false) {
            "Echo success";
            //if data is sent successfully to order.py then the ui page changes
            #header('Location: delivery.php');
            //session_destroy();
        } 
        else{
        //error msg in the UI     
        }
    } 
?>

<?php
    require_once 'template/head.php';
    require_once 'template/header.php';

?>

<main role="main" class="container">
    <div class="starter-template">

        <p class="lead">Order Confirmed</p>
        <table style="width:100%">
            <tr>
            <th>ID</th>
                <th>Name</th>
                <th>Price</th>
                <th>Quantity</th>
            </tr>   
        
        <?php
        $cart_total = 0;
        foreach($_SESSION['cart'] as $contentArray)
        {
            $id = $contentArray['id']; 
            $name = $contentArray['name'];
            $unit_price = number_format($contentArray['unit_price'], 2, '.', ' ');
            $quantity = $contentArray['quantity'];

            echo "<tr>
                    <td>$id</td>
                    <td>$name</td>
                    <td>$$unit_price</td>
                    <td>$quantity</td>
                    <td><input type='hidden' cart_item[] = $id></td>
                </tr>";
                
            $cart_total += $unit_price * $quantity;  
        }
        echo"<tr>
                <th colspan = '3'>Total:</th>
                <th colspan = '3'>$$cart_total</th>
            </tr>";
        ?>
        </table>
        <p></p>
        
        <p class="lead">Delivery Location</p>
        <?php
        //header();
        ?>

        <p class="lead">Payment</p>
        <table style="width:100%" id='test'>
        <tr>try</tr>
        <tr> <script src="https://www.paypal.com/sdk/js?client-id=sb"></script>
        <script>paypal.Buttons().render('body');</script>
        </tr>

        </table>
        
        



        
        
        
        <?php
        //header();
        ?>

    </div>

</main>
<?php
require_once 'template/footer.php';
?>

</div>
</body>
</html>
