<?php
require_once 'template/head.php';
require_once 'template/header.php';
require_once 'include/autoload.php';
?>


<main role="main" class="container">
    <div class="starter-template">    

<?php
$delivery_data = CallAPI('GET', $delivery_url, 'get_deliveries');
$delivery_status = checkSuccessOrFailure($delivery_data);
if ($delivery_data != false and isset($delivery_data->{'delivery'})) {
    $delivery = $delivery_data->{'delivery'};
} else {
    $delivery = false;
    echo "<p class='lead'><h2>All deliveries have been dispatched</h2></p>";
}


if ($delivery != false) {
    echo"<p class='lead'><h2>Pending for Delivery</h2></p>
    <br></br>";

    echo "<table id = 'deliveryTable' class = 'table'> 
            <tr>
            <th style='text-align:center'>Invoice ID</th>
            <th style='text-align:center'>Address</th>
            <th style='text-align:center'>Status</th>
            <th style='text-align:center'>Customer ID</th>
            <th></th>
        </tr>";
    foreach ($delivery as $delivery) {
        echo "<tr>
        <td style='text-align:center'>{$delivery->invoice_id}</td>
        <td style='text-align:center'>{$delivery->address}</td>
        <td style='text-align:center'>{$delivery->status}</td>
        <td style='text-align:center'>{$delivery->customer_id}</td>
        <td style='text-align:center'><form id=searchOrder action = 'dispatch_delivery.php' method = 'post'>
            <button class='btn btn-warning' name='invoice_id' type='submit' value= {$delivery->invoice_id}>Show More</button></td>
        </form>
        </tr>";
        }
        echo "</table>";
    }
?>
</div>










<?php
require_once 'template/footer.php';
?>

