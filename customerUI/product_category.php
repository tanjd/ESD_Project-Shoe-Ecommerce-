<?php
require_once 'include/autoload.php';
$data = CallAPI('GET', $customer_url, 'get_all_customers');
$status = checkSuccessOrFailure($data);
if ($status != false) {
    $customers = $data->{'customers'};
} else {
    $customers = false;
}

if (isset($_GET["category_id"])) {
    $GET_data = [
        "category_id" => $_GET["category_id"]
    ];
    $product_data = CallAPI('GET', $product_url, 'get_products_by_category/', $GET_data);
    $product_status = checkSuccessOrFailure($product_data);
    if ($product_status != false) {
        $products = $product_data->{'products'};
    } else {
        $products = false;
    }

    $categories_data = CALLAPI('GET', $product_url, 'get_all_categories');
    $categories_data_status = checkSuccessOrFailure($categories_data);
    if ($categories_data_status != false) {
        $categories = $categories_data->{'categories'};
    } else {
        $categories = false;
    }
    foreach ($categories as $category) {
        if ($_GET["category_id"] == $category->id) {
            $category_name = $category->name;
        }
    }
    $is_login = false;
    if (isset($_SESSION['customer_id'])) {
        $is_login = true;
        $category_id = $_GET["category_id"];
        $customer_id = $_SESSION["customer_id"];
        $POST_data = [
            "category_id" => $category_id,
            "customer_id" => $customer_id
        ];
        $sub_data = CALLAPI('POST', $customer_url, 'is_subscribed', $POST_data);
        $status = checkSuccessOrFailure($sub_data);
        if ($status != false) {
            $message = $sub_data->{'message'};
        }
    }
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
                        <p class='card-text'><h2><center>\${$product->unit_price}</center></h2></p>
                            <a href='process_add_to_cart.php?product_id={$product->id}&from=product_category.php?category_id={$category_id}'>
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