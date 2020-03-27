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
        <p>
            <?php
            if ($category != false){
                $description = getDescription($category_name); 
                echo "$description"; 
            }
            
            ?>
        </p>
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

function getDescription($name){

    $result = ''; 
    if ($name == 'adidas'){
        $result = "adidas' sporting prowess is in a league of its own. Taking performance to the next level since 1924, JD's range of 3-Stripes clothing and footwear keeps tradition alive. Hit the pitch in the latest football boots and kits, stay focused with their Z.N.E lines and step up your fitness in Climacool pieces and Ultra Boosts to keep you on track when you train."; 
    }
    elseif ($name == 'nike'){
        $result = "Nike's legendary style and dedication to innovation has run the streets since 1972. Get in on their game-changing rep with our range of clothing, accessories and footwear. From the revolutionary Air Max 1, 90 and 95 to the latest Air Max 2017, Air Force, Dunk and Huarache. JD have more exclusive colourways than anyone else. Gear up with Nike Apparel and feel the warmth of their Tech Fleece range in every step. You’ll find unrivalled style and innovation in every tee, hoody, cap, bag, vest, sweatshirt and jacket. With unbeatable support and comfort in every pair of leggings, track pant and tights. Keep your style looking fresh with the iconic Swoosh and JD Sports."; 
    }
    elseif ($name == 'vans'){
        $result = "Never lose the west coast look with the essential collection of Vans kicks and threads here at Python Shoes. Whether you’re looking for a fresh outfit that’s summer ready or some fresh creps to make the side stripe standout in your look, Vans has got you covered. Stay fresh on and off the board and check out the range for men, women, and kids below."; 
    }
    elseif ($name == 'puma'){
        $result = "Puma The go-to for the athletic-minded and streetwear-savvy, PUMA is a brand on everyone’s lips this season. Metallic accents and pastel colourways bring its signature Suede trainers and pool sliders bang up-to-date."; 
    }
    elseif ($name == 'saucony'){
        $result = 'Saucony exists to empower the human spirit, with every stride, on every run, and in every community'; 
    }
    return $result; 

}
require_once 'template/footer.php';
?>
