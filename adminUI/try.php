<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
    integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
    crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
    integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
    crossorigin="anonymous"></script>

<style>
.summary table, 
.summary th, 
.summary td {
  border: 1px solid black;
}

</style>

<?php
require_once '../include/autoload.php';
$delivery_data = CallAPI('GET', $delivery_url, 'get_deliveries');
$delivery_status = checkSuccessOrFailure($delivery_data);
if ($delivery_data != false) {
    $delivery = $delivery_data->{'delivery'};
} else {
    $delivery = false;
}


if ($delivery != false) {

    echo "<table id = 'deliveryTable'> 
            <tr>
            <th>Invoice ID</th>
            <th>Address</th>
            <th>Status</th>
        </tr>";
    foreach ($delivery as $delivery) {
        echo "<tr>
        <td>{$delivery->invoice_id}</td>
        <td>{$delivery->address}</td>
        <td>{$delivery->status}</td>
        <td><form id=searchOrder action = 'try.php' method = 'post'>
            <button name='invoice_id' type='submit' value= {$delivery->invoice_id}>Show More</button></td>
        </form>
        </tr>";
        }
        echo "</table>";
    }


    
if(isset($_POST['invoice_id'])){
    $data = [
        "invoice_id" => $_POST['invoice_id']
    ];
    $invoice_data = CallAPI('GET', $order_url, 'get_invoice/', $data);
    $invoice_status = checkSuccessOrFailure($invoice_data);
    if ($invoice_data != false) {
        $invoice = $invoice_data->{'invoice'};
    } else {
        $invoice = false;
    }
    $order_data = CallAPI('GET', $order_url, 'get_all_orders/', $data);
    $order_status = checkSuccessOrFailure($order_data);
    if ($order_data != false) {
        $order = $order_data->{'order'};
    } else {
        $order = false;
    }

    if ($invoice != false && $order != false) {
        echo "<table id = 'orderSummary' class = 'summary'><tr> 
                <th>Product id</th>
                <th>Quantity</th>
                <th>Amount</th> 
            </tr>";
        foreach ($order as $order) {
            echo "<tr>
            <td>{$order->product_id}</td>
            <td>{$order->quantity}</td>
            <td>\${$order->price}</td>
            </tr>";
            }
        echo "<tr>
                <td>Total Amount:</td>
                <td colspan = '2'>\${$invoice->total_amount}</td>  
            </tr>";
        
        echo "</table>";
        }


}

?>


<script>
$("#searchOrder").submit(async(event)=>{
    $('#deliveryTable').hide(); 
  }
})
</script>







