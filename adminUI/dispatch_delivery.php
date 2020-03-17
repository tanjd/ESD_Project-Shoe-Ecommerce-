<?php
require_once 'template/head.php';
require_once 'template/header.php';
require_once 'include/autoload.php';
?>

<?php

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
        $invoice_id = $invoice->id;
        echo "Order #{$invoice_id}";
        echo "<br><br><br>";



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

        echo "<form action = 'dispatch_delivery.php' method = 'post'>
        <button name='update_id' type='submit' value= {$invoice_id}>Dispatch</button></td>
        </form>";

    }
}

?>


<?php

        if(isset($_POST['update_id'])){
            $update_data = [
                "invoice_id" => $_POST['update_id']];
            $update = CallAPI('GET', $delivery_url, 'delivery/',$update_data);
            if($update != False){
                $URL="http://localhost/esd/adminui/view_delivery.php";
                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
            }

        }
?>


<?php
require_once 'template/footer.php';
?>