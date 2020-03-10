<?php
require_once 'include/autoload.php';

$data = CallAPI('GET', $customer_url, 'get_all_customers');
$status = checkSuccessOrFailure($data);
if ($status != false) {
    $customers = $data->{'customers'};
} else {
    $customers = false;
}

// var_dump($_GET);
// echo($_GET['name']);
$name = $_GET['name'];
$pass = 'product/' . $name;
print($pass);
$product_data = CallAPI('GET', $product_url, $pass);
$product_status = checkSuccessOrFailure($product_data);
var_dump($product_status);
if ($product_data != false) {
    $product = $product_data->{'status'};
} else {
    $product = false;
}

?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';

$product_table = $product_data;
?>

<main role="main" class="container">
    <div class="starter-template">
        <p class="lead">
        <?php
        var_dump($product_table);
        ?>
        </p>
        <?php
        // var_dump($customers);

        // foreach ($customers as $customer) {
        //     echo "this is the emails " . $customer->{'email'} . "<br>";
        // }
        ?>
    </div>
</main>
<?php
require_once 'template/footer.php';
?>