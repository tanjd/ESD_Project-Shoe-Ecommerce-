<?php

require_once 'include/autoload.php';
//$con = mysqli_connect("localhost", "root", "", "notify");

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
   
    if ($msg_status != false){
        $message = $message_data->{'messages'};
        $num_of_msg=count($message);
    }
    else{
        $message =false; 
        $num_of_msg = 0; 
    }
    
    
    
}

// ! isset $_SESSION['customer_id']
else {

    $quantity = 0;
    $is_loggedin = false;
}


?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="index.php">Python Shoes</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    <?php

        // $sql_get = mysqli_query($con, "SELECT * FROM message WHERE status=0");
        // $count = mysqli_num_rows($sql_get);


    ?>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
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
        
        <ul class="navbar-nav right">
            
                
                <?php
                    // echo '<div class="dropdown-menu" aria-labelledby="dropdown02">'; 
                    // $sql_get1 = mysqli_query($con, "SELECT * FROM message WHERE status=0");
                    // if (mysqli_num_rows($sql_get1)>0){
                    //     while($result=mysqli_fetch_assoc($sql_get1)){
                    //        echo '<a class="dropdown-item text-primary" href="read_msg.php?id='.$result['id'].'">'.$result['content_message'].'</a>';
                    //         echo '<div class="dropdown-divider"></div>';
                    //     }
                    // }
                    // else{
                    //     echo '<a class="dropdown-item text-danger" href="#"><i class="fas fa-frown-open"></i> Sorry! No messages</a>';
                    // }
                    // echo '</div>'; 
                    ?>
                
            <?php
            echo "<li class='nav-item'>
                
                    <a class='nav-link' href='read_msg.php'>
                        <i class='fas fa-envelope'></i> <span class='badge badge-danger' id = 'count'>";
                        if ($is_loggedin) {
                            $num_of_msg;
                        }
                        echo "</span>
                    </a>
                </li>"; 
            
            echo "<li class='nav-item'>
                    <a class='nav-link' href='cart.php' aria-haspopup='true' aria-expanded='false'>
                        <i class='fas fa-shopping-cart'></i><span class='badge badge-danger' id = 'count'>$quantity</span>
                    </a>
                </li>"; 

            
            ?>
                    
            <?php if ($is_loggedin) {
                
                echo"
                        <a class='nav-link' href='account_settings.php'><span class='fas fa-user' aria-hidden='true'></span></a>
                    </li>

                    <li class='nav-item active'>
                        <a class='nav-link'>$customer->name</a>
                    </li>

                    <li class='nav-item'>
                        <a class='nav-link' href='process_logout.php'> <span class='fa fa-sign-out' aria-hidden='true'></span></a>
                    </li>";
            } else {
                $actual_link = "$_SERVER[REQUEST_URI]";
                //var_dump($actual_link);
                if ($actual_link != 'login.php') {
                    echo "<li class='nav-item'>
                    <a class='nav-link' href='login.php'><span class='fas fa-user' aria-hidden='true'>  Login</span></a>
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
        
        <?php
        if (isset($_SESSION['header_display'])){
            if ($_SESSION['header_display']){
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
