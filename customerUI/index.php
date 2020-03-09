<?php
require_once 'include/autoload.php';

$data = CallAPI('GET', $customer_url, 'get_all_customers');
$status = checkSuccessOrFailure($data);
if ($status != false) {
    $customers = $data->{'customers'};
} else {
    $customers = false;
}

$product_data = CallAPI('GET', $product_url, 'get_all_products');
if ($product_data != false) {
    $product = $product_data->{'product'};
} else {
    $product = false;
}

?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';

#Process products

// for ($i=0; count($product);$i++){
//     $product_table = $i;
// }



?>

<main role="main" class="container">
    <div class="starter-template">
        <p class="lead">
        <?php
        var_dump($product);
        ?>
        </p>
        <?php
        var_dump($customers);

        // foreach ($customers as $customer) {
        //     echo "this is the emails " . $customer->{'email'} . "<br>";
        // }
        ?>
    </div>
</main>
<?php
require_once 'template/footer.php';
?>