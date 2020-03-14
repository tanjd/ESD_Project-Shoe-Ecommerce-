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
    
}


?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';
?>
<main role="main" class="container">
    <div class="starter-template">
        <p class="lead">
            <?php
            if ($products != false) {
                echo "<table class='table'>
                    <thead class='thead-dark'>
                    <tr>
                        <th scope='col' colspan='2'>Shoe</th>
                        <th scope='col'>Description</th>
                        <th scope='col'>Price</th>
                        <th scope='col'>Add to Cart</th>
                    </tr>";
                foreach ($products as $product) {
                    echo "<tr>
                        <td><img src='../image/{$product->image}' style='width:150px;height:100px'></td>
                        <td><a href='product.php?product_id={$product->id}'>{$product->name}</a></td>
                        <td>{$product->description}</td>
                        <td>{$product->unit_price}</td>
                        <td>
                            <a href='process_add_to_cart.php?product_id={$product->id}'>
                                <button type='button' class='btn btn-dark' style='width:120px;height:70px'>Add To Cart</button>
                            </a>
                        </td>

                        </tr>";
                }
                echo "</table>";
            }
            ?>
        </p>
    </div>
</main>
<?php
require_once 'template/footer.php';
?>