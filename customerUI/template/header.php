<?php

require_once 'include/autoload.php';
require_once 'include/currency_convert.php';

$categories_data = CALLAPI('GET', $product_url, 'get_all_categories');
$categories_data_status = checkSuccessOrFailure($categories_data);
if ($categories_data_status != false) {
    $categories = $categories_data->{'categories'};
} else {
    $categories = false;
}

if (isset($_SESSION['customer_id'])) {
    $customer_id = $_SESSION['customer_id'];
    $POST_data = [
        "customer_id" => $customer_id,
    ];
    $data = CallAPI('GET', $customer_url, 'get_customer/', $POST_data);
    $message_data = CallAPI('POST', $message_url, 'get_messages_by_customer', $POST_data);
    $data_status = checkSuccessOrFailure($data);
    $msg_status = checkSuccessOrFailure($message_data);
    if ($data_status != false) {
        $customer = $data->{'customer'};
    } else {
        $customer = false;
    }

    $is_loggedin = true;
    $quantity = 0;

    if (isset($_SESSION['cart'])) {

        if ($_SESSION['cart'] != []) {
            foreach ($_SESSION['cart'] as $one_item) {
                $quantity += $one_item['quantity'];
            }
        }
    }

    if ($msg_status != false) {
        $message = $message_data->{'messages'};
        $num = 0;
        foreach ($message as $msg) {
            if ($msg->status == 0) {
                $num++;
            }
        }
        $num_of_msg = $num;
    } else {
        $message = false;
        $num_of_msg = 0;
    }
    // currency
    if (isset($_SESSION['currencyAPI'])) {
        $currencies = $_SESSION['currencyAPI']['rates'];
    } else {
        $currencies = [];
    }

    if (isset($_SESSION['currency'])) {
        $selected_currency = $_SESSION['currency'];
    } else {
        $selected_currency = 'SGD';
    }
} else {
    $quantity = 0;
    $is_loggedin = false;
}
?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="index.php">Python Shoes</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <div class="collapse navbar-collapse" id="navbarSupportedContent">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php"><span class="fa fa-home"></span></a>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Shop By Brand</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <?php
                    foreach ($categories as $category) {
                        echo "<a class='dropdown-item' style='text-transform:capitalize' href='product_category.php?category_id={$category->id}'>{$category->name}</a>";
                    }
                    ?>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav right">';
            <?php
            if ($is_loggedin) {
            ?>
                <li class='nav-item'>
                    <a class='nav-link' href='read_msg.php'>
                        <i class='fas fa-envelope'></i> <span class='badge badge-danger' id='count'><?php $num_of_msg ?></span>
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='cart.php' aria-haspopup='true' aria-expanded='false'>
                        <i class='fas fa-shopping-cart'></i><span class='badge badge-danger' id='count'><?php $quantity ?></span>
                    </a>
                </li>
                <li>
                    <a class='nav-link' href='account_settings.php'><span class='fas fa-user' aria-hidden='true'></span><?php $customer->name ?></a>
                </li>
                <li class='nav-item dropdown'>
                    <a class='nav-link dropdown-toggle' id='dropdown02' data-toggle='dropdown' aria-haspopup='true' aria-expanded='false'><span class='fa fa-dollar' aria-hidden='true'></span><?php $selected_currency ?></a>
                    <div class='dropdown-menu' aria-labelledby='dropdown02'>
                        <?php
                        foreach ($currencies as $key => $value) {
                            echo "<a class='dropdown-item' style='text-transform:capitalize' href='process_convert_currency?currency={$key}'>{$key}</a>";
                        }
                        ?>
                    </div>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='process_logout.php'> <span class='fa fa-sign-out' aria-hidden='true'></span></a>
                </li>
            <?php
            } else {
                $actual_link = "$_SERVER[REQUEST_URI]";
                if ($actual_link != 'login.php') {
                    echo "<li class='nav-item active'>
                    <a class='nav-link' href='login.php'><span class='fas fa-user' aria-hidden='true'></span></a>
                    </li>
                    <li class='nav-item active'>
                        <a class='nav-link' href='login.php'>Login</a>
                    </li>";
                }
            }
            ?>
        </ul>
    </div>
</nav>

<div class="jumbotron">
    <div class="container text-center">
        <h1>Python Shoes</h1>
        <p>We don't just sell snakeskin shoes.</p>

        <?php
        if (isset($_SESSION['header_display'])) {
            if ($_SESSION['header_display']) {
                echo "
                <div class='p-3 mb-2 bg-dark text-white'>
                <p><h3>{$_SESSION['message']}</h3></p>";
                $_SESSION['header_display'] = FALSE;
                echo '</div>';
            }
        }
        ?>
    </div>
</div>