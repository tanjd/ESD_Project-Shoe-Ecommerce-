<link href="//netdna.bootstrapcdn.com/bootstrap/3.0.0/css/bootstrap.min.css" rel="stylesheet" id="bootstrap-css">
<script src="//netdna.bootstrapcdn.com/bootstrap/3.0.0/js/bootstrap.min.js"></script>
<script src="//code.jquery.com/jquery-1.11.1.min.js"></script>

<?php
require_once 'include/autoload.php';
require_once 'include/currency_convert.php';

if (is_null($_SESSION['cart']) or is_null($_SESSION['customer_id']) or is_null($_SESSION['delivery'])) {
    
    header('Location: process_payment.php');
    
}else{

    $order_data = [ 
        "cart" => $_SESSION['cart'],
        "id" => $_SESSION['customer_id'],
        "address" => $_SESSION['delivery']];

    if (isset($_SESSION['currency'])) {
        $selected_currency = $_SESSION['currency'];
    } else {
        $selected_currency = 'SGD';
    }
}
?>
<br></br><br></br><br></br>
<div class="container">
    <div class="row">
        <div class="well col-xs-10 col-sm-10 col-md-15 col-xs-offset-1 col-sm-offset-1">
            <div class="row">
                <div class="col-xs-6 col-sm-6 col-md-15">
                    <address>
                        <strong>Python Shoes</strong>
                        <br>
                        Singapore
                        <br>
                        Clemnti Road 21, 500101
                        <br>
                        P: (65) 6588-7565
                    </address>
                </div>
                <div class="col-xs-6 col-sm-6 col-md-6 text-right">
                    <p>
                        <em>Date: 02, April 2020</em>
                    </p>

                </div>
            </div>
            <div class="row">
                <div class="text-center">
                    <img src="https://cdn.dribbble.com/users/637635/screenshots/6065726/800_600_2.gif" alt="thankyou.gif" width="400" height="300">
                    <h1>Receipt</h1>
                </div>
                </span>
                <table class="table table-hover">
                    <tbody>
                    <thead>
                        <tr>
                        <th> Delivery Location</th>
                        <td colspan='3' class="text-right"> <?php echo $_SESSION['delivery'] ?> </td>
                        </tr>
                    </thead>
                    
                        <?php
                            $cart_total = 0;

                            echo "<table class='table table-hover'>";
                            echo "<thead>
                                <tr>
                                    <th >Name</th>
                                    <th> Quantity </th>
                                    <th>Price</th>
                                    <th> Total </th>
                                </tr>
                                    </thead>";

                            $cart_total = 0;
                            foreach ($_SESSION['cart'] as $contentArray) {
                                $name = $contentArray['name'];
                                $temp_price = number_format($contentArray['unit_price'], 2, '.', ',');
                                $unit_price =convert($temp_price, $selected_currency);
                                $quantity = $contentArray['quantity'];
                                $total_price = $unit_price * $quantity;
                    
                                echo "<tr>
                                            <td>$name</td>
                                            <td> $quantity </td>
                                            <td>$selected_currency $total_price</td>
                                            <td>$selected_currency $total_price </td>
                                        </tr>";
                                    $cart_total += $total_price;
                            }     
                    ?>

                        <tr>
                            <td>   </td>
                            <td>   </td>
                            <td class="text-right"><h4><strong>Total: </strong></h4></td>
                            <td class="text-left text-danger"><h4><strong><?php echo "$selected_currency $cart_total" ?> </strong></h4></td>
                        </tr>

                    </tbody>
                </table>
                <div>
                    <h1 style="text-align:center;">Your payment is Successful! </h1>
                    <h2 style="text-align:center;">Thank you for shopping with us :-)</h2>
                    <tr ><a href="http://localhost/ESD_Project/customerUI/index.php">Click here to shop more!</a></tr> 
                    
                </div>
            </div>
        </div>
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
   unset($_SESSION['cart']);
   unset($_SESSION['delivery']);
}
?>

