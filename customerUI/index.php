<?php
require_once 'include/autoload.php';
require_once 'process_convert_currency.php'; 

$data = CallAPI('GET', $customer_url, 'get_all_customers');
$status = checkSuccessOrFailure($data);
if ($status != false) {
    $customers = $data->{'customers'};
} else {
    $customers = false;
}

$product_data = CallAPI('GET', $product_url, 'get_all_products');
$product_status = checkSuccessOrFailure($product_data);

if ($product_status != false) {
    $products = $product_data->{'products'};
} else {
    $products = false;
}

if (isset($_GET['currency'])){
    $selected_currency = $_GET['currency']; 
}
else{
    $selected_currency = 'SGD'; 
}
?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';
?>
<main role="main" class="container">
    <!-- <div class='card-columns'> -->
    <div class="row">
        <?php
        if ($products != false) {
            foreach ($products as $product) {
                echo "
                <div class='col-sm-4 py-2'>
                    <div class='card card-body h-100'>
                        <div class='card-header'>
                            <a href='product.php?product_id={$product->id}'><h6 class='card-title'>{$product->name}</h6></a>
                        </div>
                        <a href='product.php?product_id={$product->id}'><img class='card-img-top' src='../image/{$product->image}' alt='Card image cap' style=
                        'margin-left: auto;
                        margin-right: auto;
                        width: 85%;'></a>
                        <div class='card-body'>
                            <p class='card-text' align='justify' >{$product->description}</p>
                        </div>
                        <div class='card-footer text-center'>
                        <p class='card-text'><h2><center>{$selected_currency} ".convert($product->unit_price, $selected_currency)."</center></h2></p>
                            <a href='process_add_to_cart.php?product_id={$product->id}&from=index.php'>
                                <button type='button' class='btn btn-dark' >Add To Cart</button>
                            </a>
                        </div>
                    </div>
                </div>";
            }
        }
        ?>
    </div>
</main>
<?php
require_once 'template/footer.php';
?>