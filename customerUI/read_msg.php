<?php
require_once 'include/autoload.php';

require_once 'template/head.php';
require_once 'template/header.php';

if (isset($_SESSION['cart']) and isset($_SESSION['customer_id'])) {

    $order_data = [
        "cart" => $_SESSION['cart'],
        "id" => $_SESSION['customer_id']
    ];

    $data = CallAPI('POST', $order_url, 'create_order', $order_data);
    $status = checkSuccessOrFailure($data);

    if ($status != false) {
        //if data is sent successfully to order.py then the ui page changes
        #header('Location: delivery.php');
        session_destroy();
    } else {
        //error msg in the UI
    }
}

$cart_total = 0;
if($is_loggedin){
    $POST_data = [
        "customer_id" => $_SESSION['customer_id']
    ];
    $msg_data = CallAPI('POST', $message_url, 'get_messages_by_customer', $POST_data);
    if($msg_data!=null){
        $message = $msg_data->{'messages'};
    }
    
    
}

$sr_no=1;

?>


<main role="main" class="container" id="text_msg">
    <div class="starter-template">
        <p class="lead">
            <i class="fas fa-inbox"></i>
            <?php if($is_loggedin){ ?>
            <h2>My Inbox </h2>


            <div class = "container" id="table1">
            <div class = "row">
            <table class="table table-hover">
            <thead class="thead-dark bg-danger">
            <h6 class="border-bottom border-gray pb-2 mb-0">Recent updates</h6>
                <tr>
                <th scope="col">Message</th>
                <th scope="col">Date</th>
                <th scope="col"></th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            <?php   
                
                    $count=0;
                    if($msg_data!=null){
                    foreach ($message as $msg) {
                        if($msg->status ==0){
                        echo "<tr>
                        
                        <td><h6><b><font color='blue'>{$msg->content_message}</font></b></h6></td>
                        <td>{$msg->created_at}</td>
                        <td ><a href='delete.php?message_id={$msg->id}&from=read_msg.php'> <button type='button' class='btn btn-danger' >Delete</button></a></td>
                        <td ><a href='seen.php?message_id={$msg->id}&from=read_msg.php'> <button type='button' class='btn btn-primary' >Read</button></a></td>
                        </tr>";
                        $count++;
                        }
                        else{
                            echo "<tr>
                        
                            <td><h6><font color='black'>{$msg->content_message}</font></h6></td>
                            <td>{$msg->created_at}</td>
                            <td ><a href='delete.php?message_id={$msg->id}&from=read_msg.php'> <button type='button' class='btn btn-danger' >Delete</button></a></td>
                            <td ><font color='grey'>Read</font></td>
                            </tr>";
                        $count++;
                        }
                    }
                    }
                    if ($count==0){
                        echo "<tr><td colspan='4'><h4><b>No new messages</b></h4></td></tr>";
                    }
                }
                else{
                    echo "Please login to view messages in inbox";
                }
                
                
                ?>
               
                
               
            </tbody>
            </table>
            </div>
            </div>


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