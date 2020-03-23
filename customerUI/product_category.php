<?php
require_once 'include/autoload.php';
require_once 'include/currency_convert.php'; 

if (isset($_GET["category_id"])) {
    $category_id = $_GET["category_id"];
    $GET_data = [
        "category_id" => $category_id
    ];
    $product_data = CallAPI('GET', $product_url, 'get_products_by_category/', $GET_data);
    $product_status = checkSuccessOrFailure($product_data);
    if ($product_status != false) {
        $products = $product_data->{'products'};
    } else {
        $products = false;
    }

    $category_data = CALLAPI('GET', $product_url, 'get_category/', $GET_data);
    $category_data_status = checkSuccessOrFailure($category_data);
    if ($category_data_status != false) {
        $category = $category_data->{'category'};
        $category_name = $category->{'name'};
    } else {
        $category = false;
    }
    $is_login = false;
    if (isset($_SESSION['customer_id'])) {
        $customer_id = $_SESSION['customer_id'];
        $is_login = true;
        $POST_data = [
            "category_id" => $category_id,
            "customer_id" => $customer_id
        ];
        $sub_data = CALLAPI('POST', $customer_url, 'is_subscribed', $POST_data);
        // var_dump($sub_data);
        $sub_status = checkSuccessOrFailure($sub_data);
        if ($sub_status != false) {
            $sub_message = $sub_data->{'message'};
            if ($sub_message == false) {
                $method = 'add_subscription';
                $button_value = 'Subscribe';
            } else {
                $method = 'remove_subscription';
                $button_value = 'Unsubscribe';
            }
        }
    }
}

if (isset($_SESSION['currency'])){
    $selected_currency = $_SESSION['currency']; 
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
    <div class="starter-template">
        <p class="lead"></p>
        <h1 style='text-transform:capitalize'><?php if ($category != false) {
                                                    echo "$category_name";
                                                }  ?></h1>
        <hr>
        <span class="error text-danger span-error" style="text-align: center"><?php outputError() ?></span>
        <?php if ($is_login == true) {
            echo "<h5>To receive updates on products in this category, click subscribe!</h5>";
            if ($sub_status != false) {
                echo "<a href='process_subscribe.php?category_id={$category_id}&customer_id={$customer_id}&method={$method}'>
                            <button type='button' id='subscribe' class='btn btn-danger'>{$button_value}</button>
                        </a>";
            }
        } ?>
        <hr>
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
<!-- <script>
    async function postData(serviceURL, requestBody) {
        console.log(JSON.stringify(requestBody))
        console.log((serviceURL))
        var requestParam = {
            headers: {
                "Content-Type": "application/json"
            },

            method: 'POST',
            body: JSON.stringify(requestBody)
        }
        try {
            const response = await fetch(serviceURL, requestParam);
            data = await response.json();
            console.log(data);
            if (data.status == 'success') {
                console.log(data.status);
            } else {
                console.log('failed');
            }
        } catch (error) {
            console.error(error);
        }
    }
    $('#subscribe').click( function() {
        var serviceURL = "" + "is_subscribed";
        var requestBody = {
            "category_id": ,
            "customer_id":
        };
        console.log(requestBody)
        // postData(serviceURL, requestBody);
    });
</script> -->