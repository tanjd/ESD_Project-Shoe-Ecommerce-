<?php
require_once 'template/head.php';
require_once 'template/header.php';
require_once 'include/autoload.php';

if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'Admin'){
?>

<main role="main" class="container">
    <div class="starter-template">
    <form method = "post">
    <div class="btn-group" role="group" aria-label="Basic example">
    <input type="submit" name = "all" class="btn btn-secondary" value = "All orders"/>
    <input type="submit" name = "in_progress" class="btn btn-secondary" value = "In Progress"/>
    <input type="submit" name = "dispatched" class="btn btn-secondary" value = "Dispatched"/>
    <input type="submit" name = "delivered" class="btn btn-secondary" value = "Delivered"/>
    <input type="submit" name = "completed" class="btn btn-secondary" value = "Completed"/>
    </div>
    </form>



<?php

$status = $_POST['all'] ?? 'default';
if(isset($status) && ! isset($_POST["in_progress"]) && ! isset($_POST["dispatched"]) && ! isset($_POST["delivered"]) && ! isset($_POST["completed"]) ){
    $delivery_data = CallAPI('GET', $delivery_url, 'get_all_deliveries');
    $delivery_status = checkSuccessOrFailure($delivery_data);
    if ($delivery_data != false and isset($delivery_data->{'delivery'})) {
        $delivery = $delivery_data->{'delivery'};
    } else {
        $delivery = false;
        echo "<p class='lead'><h2>No orders available</h2></p>";
    }


    if ($delivery != false) {
        echo"<br></br>";
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
  
}



if(isset($_POST["in_progress"])){
    $data = ["status" => $_POST["in_progress"]];
}

if(isset($_POST["dispatched"])){
    $data = ["status" => $_POST["dispatched"]];
}

if(isset($_POST["delivered"])){
    $data = ["status" => $_POST["delivered"]];
}

if(isset($_POST["completed"])){
    $data = ["status" => $_POST["completed"]];
}

if (isset($data['status'])){
    $delivery_data = CallAPI('GET', $delivery_url, 'get_deliveries_status',$data);
    $delivery_status = checkSuccessOrFailure($delivery_data);
    if ($delivery_data != false and isset($delivery_data->{'delivery'})) {
        $delivery = $delivery_data->{'delivery'};
    } else {
        $delivery = false;
        echo "<p class='lead'><h2>NIL</h2></p>";
    }


    if ($delivery != false) {
        echo"<br></br>";
        echo "<table id = 'deliveryTable' class = 'table'><tr>
                <th style='text-align:center'>Invoice ID</th>
                <th style='text-align:center'>Address</th>
                <th style='text-align:center'>Status</th>
                <th style='text-align:center'>Customer ID</th>
                <th></th></tr>";
        foreach ($delivery as $delivery) {
            echo "<tr>
            <td style='text-align:center'>{$delivery->invoice_id}</td>
            <td style='text-align:center'>{$delivery->address}</td>
            <td style='text-align:center'>{$delivery->status}</td>
            <td style='text-align:center'>{$delivery->customer_id}</td>
            <td style='text-align:center'><form id=searchOrder action = 'dispatch_delivery.php' method = 'post'>
                <button class='btn btn-warning' name='invoice_id' type='submit' value= {$delivery->invoice_id}>Show More</button></td>
            </form></tr>";
        }
        echo "</table>";
    }
}
  
?>
</div>



<?php }
else {
    header('Location: login.php');
    exit();
}
?>


