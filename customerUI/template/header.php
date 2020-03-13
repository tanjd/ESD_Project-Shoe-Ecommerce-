<?php

require_once 'include/autoload.php';

if (isset($_SESSION['customer_id'])) {

    $customer_id = $_SESSION['customer_id'];

    $POST_data = [
        "customer_id" => $customer_id,
    ];
    $data = CallAPI('GET', $customer_url, 'get_customer/', $POST_data);
    $data_status = checkSuccessOrFailure($data);
    if ($data_status != false) {
        $customer = $data->{'customer'};
    } else {
        $customer = false;
    }

    $categories_data = CALLAPI('GET', $product_url, 'get_all_categories');
    $categories_data_status = checkSuccessOrFailure($categories_data);
    if ($categories_data_status != false) {
        $categories = $categories_data->{'categories'};
    } else {
        $categories = false;
    }


    $is_loggedin = true;
    $quantity = 0;
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

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="index.php"><span class="fa fa-home"></span></a>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Shop By Brand</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <?php
                        foreach ($categories as $category){
                            echo "<a class='dropdown-item' href='product_category.php?category_id={$category->id}'>{$category->name}</a>";
                        }
                    ?>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav right">
            <?php if ($is_loggedin) {
                echo "<li class='nav-item'>
                    <a class='nav-link' href='cart.php'>
                        <i class='fa fa-shopping-cart'></i><span class='badge'>";if ($quantity != 0) {
                            echo " $quantity";
                        } echo"</span>  
                    </a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='#'><span class='fas fa-user' aria-hidden='true'></span></a>
                </li>
                <li class='nav-item'>
                    <a class='nav-link' href='process_logout.php'> <span class='fa fa-sign-out' aria-hidden='true'></span></a>
                 </li> -->";
            }
            else {
                $actual_link = "$_SERVER[REQUEST_URI]";
                //var_dump($actual_link);
                if ($actual_link != 'login.php'){
                    echo "
                    <li class='nav-item'>
                    <a class='nav-link' href='cart.php'>
                        <i class='fa fa-shopping-cart'></i><span class='badge'>";if ($quantity != 0) {
                            echo " $quantity";
                        } echo"</span>
                    </a>
                </li>

                <li class='nav-item'>
                <a class='nav-link' href='login.php'><span class='fas fa-user' aria-hidden='true'></span></a>
                </li>"; 
                }
            }
            ?>
        </ul>
        <!-- <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form> -->
    </div>
</nav>

<div class="jumbotron">
    <div class="container text-center">
        <h1>Python Shoes</h1>
        <p>We don't just sell snakeskin shoes.</p>
         <?php var_dump($categories);
          ?>
    </div>
</div>

