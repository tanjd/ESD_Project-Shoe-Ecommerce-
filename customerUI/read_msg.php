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
?>


<main role="main" class="container">
    <div class="starter-template">
        <p class="lead">
            <form action='checkout.php' method='post'></form>
            <h2>My Inbox </h2>


            <div class = "container" id="table1">
            <div class = "row">
            <table class="table table-hover">
            <thead class="thead-dark">
                <tr>
                <th scope="col">S. no</th>
                <th scope="col">Message</th>
                <th scope="col"></th>
                <th scope="col">Date</th>
                <th scope="col">Delete</th>
                </tr>
            </thead>
            <tbody>
                <?php 
                $POST_data = [
                    "customer_id" => 1
                ];
                $data = CallAPI('POST', $message_url, 'get_messages_by_customer', $POST_data);
                
                var_dump($data);
                foreach ($data as $msg) {
                    var_dump($msg);
                    echo "<tr>
                    
                    <td></td>
                    <td></td>
                    <td></td>
                    <td></td>
                    </tr>";
                }

                ?>
                
                <?php //endwhile ?>
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