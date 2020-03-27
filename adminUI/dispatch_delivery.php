<?php
require_once 'template/head.php';
require_once 'template/header.php';
require_once 'include/autoload.php';

?>


<main role="main" class="container">
    <div class="starter-template">
<?php

if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'Admin'){
    $all_status = array("In Progress","Dispatched","Delivered","Completed");
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
        $delivery_data = CallAPI('GET', $delivery_url, 'get_delivery', $data);
        $delivery_status = checkSuccessOrFailure($delivery_data);
        if ($delivery_data != false) {
            $delivery = $delivery_data->{'delivery'};
        } else {
            $delivery = false;
        }

        if ($invoice != false && $order != false) {
            $invoice_id = $invoice->id;
            echo"<p class='lead'><h2>Order Invoice #{$invoice_id}</h2></p>";
            echo "<br><br>";
            echo "<table id = 'orderSummary' class = 'table'><tr> 
                    <th style='text-align:center'>Product id</th>
                    <th style='text-align:center'>Quantity</th>
                    <th style='text-align:center'>Amount</th> 
                </tr>";
            foreach ($order as $order) {
                echo "<tr>
                <td>{$order->product_id}</td>
                <td>{$order->quantity}</td>
                <td>\${$order->price}</td>";}

            echo "<tr>
                    <td>Total Amount:</td>
                    <td></td>
                    <td style='text-align:center'>\${$invoice->total_amount}</td>  
                </tr>";

            echo "<tr>
                <td>Update Status:</td>
                <td></td></td>
                <td>";
            echo "<form action = 'dispatch_delivery.php' method = 'post'>";
            echo "<select id = 'status' name = 'status'>";
            foreach ($all_status as $status){
                echo '<option name="status" , value="' . $status . '" selected>' . $status . '</option>';
            }
            echo"</td></tr>";
            
            echo "</table>";

            echo " <button class='btn btn-warning' style='float:right' name='submit' type='submit' value= 'Update Status'>Update</button></td>
            </form>";
            
        }

    var_dump($_POST['invoice_id']);
    if(isset($_POST['status'])){
        $update_data = [
            "invoice_id" => $_POST['invoice_id'],
            "status" => $_POST['status']];                
            var_dump($update_data);
            var_dump($invoice);
        $update = CallAPI('GET', $delivery_url, 'delivery/',$update_data);
        /*             if($update != False){
                $URL="http://localhost/ESD_Project/adminUI/view_delivery.php";
                echo '<META HTTP-EQUIV="refresh" content="0;URL=' . $URL . '">';
                echo "<script type='text/javascript'>document.location.href='{$URL}';</script>";
            } */
    
    }
    #var_dump($_POST['invoice_id']);

}}
else {
    header('Location: login.php');
    exit();
}
?>

</div>



<?php
require_once 'template/footer.php';
?>