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

$POST_data = [
    "customer_id" => $_SESSION['customer_id']
];
$data = CallAPI('POST', $message_url, 'get_messages_by_customer', $POST_data);
$message = $data->{'messages'};
$sr_no=1;
?>


<main role="main" class="container" id="text_msg">
    <div class="starter-template">
        <p class="lead">
            <i class="fas fa-inbox"></i>
            <h2>My Inbox </h2>


            <div class = "container" id="table1">
            <div class = "row">
            <table class="table table-hover">
            <thead class="thead-dark">
            <h6 class="border-bottom border-gray pb-2 mb-0">Recent updates</h6>
                <tr>
                <th scope="col">S. no</th>
                <th scope="col">Message</th>
                <th scope="col">Date</th>
                <th scope="col">Delete</th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            
                <?php 
                foreach ($message as $msg) {
                    echo "<tr>
                    <td>$sr_no</td>
                    <td>{$msg->content_message}</td>
                    <td>{$msg->created_at}</td>
                    <td></td>
                    </tr>";
                    $sr_no++;
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