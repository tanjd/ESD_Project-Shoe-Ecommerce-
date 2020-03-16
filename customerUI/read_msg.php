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
                $sr_no=1;
                // $sql_get = mysqli_query($con, "SELECT * FROM message WHERE status=1");
                // while($main_result = mysqli_fetch_assoc($sql_get)):
                
                ?>
                <tr>
                <th scope="row"><?php echo $sr_no++; ?></th>
                <td><?php //echo $main_result['name']; ?></td>
                <td><?php //echo$main_result['content_message']; ?></td>
                <td><?php //echo $main_result['scheduled_date_time']; ?></td>
                <td><a href="delete.php?id=<?php //echo $main_result['id'];?>" class="text-danger"><i class="fas fa-trash"></i></a></td>
                </tr>
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