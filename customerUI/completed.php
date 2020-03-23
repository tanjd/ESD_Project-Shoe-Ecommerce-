<?php
require_once 'include/autoload.php';

?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';
?>
<main role="main" class="container">
    <div class="starter-template">
        <p class="lead"><h2>YOUR PAYMENT IS SUCCESSFUL</h2></p>
                        <h2>Thank you for shopping with us on Python Shoes! :-)</h2>
                        <a href="http://localhost/esd_project/customerUI/index.php">Click here to shop more!</a>
    </div>

<?php
#var_dump($_SESSION['cart']);

if (isset($_SESSION['cart']) and isset($_SESSION['customer_id'])) {

    $order_data = [
        "cart" => $_SESSION['cart'],
        "id" => $_SESSION['customer_id'],
        "address" => $_SESSION['delivery']
    ];
    
    $data = CallAPI('POST', $order_url, 'create_order', $order_data);
    $status = checkSuccessOrFailure($data);
    var_dump($data);
    if ($status != false) {
        session_destroy();
        } 

}
?>

</main>
<?php
require_once 'template/footer.php';
?>