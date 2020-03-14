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
    <div class="starter-template">
        <p class="lead"></p>
        <h1><?php echo "$category_name" ?></h1>
        <hr>
        <span class="error text-danger span-error" style="text-align: center"><?php outputError() ?></span>
        <?php if ($is_login == true) {
            echo "<h5>To receive updates on products in this category, click subscribe!</h5>";
            if ($message == false) {
                echo "<a href='process_subscribe.php?category_id={$category_id}&customer_id={$customer_id}&method=add_subscription'>
                        <button type='button' id='subscribe' class='btn btn-danger'>Subscribe</button>
                    </a>";
            } else {
                echo "<a href='process_subscribe.php?category_id={$category_id}&customer_id={$customer_id}&method=remove_subscription'>
                        <button type='button' id='unsubscribe' class='btn btn-danger'>Unsubscribe</button>
                    </a>";
            }
        } ?>
        <hr>
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
    </div>
</main>
<?php
require_once 'template/footer.php';
?>