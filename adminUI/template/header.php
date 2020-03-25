<?php

require_once 'include/autoload.php';

$categories_data = CALLAPI('GET', $product_url, 'get_all_categories');
$categories_data_status = checkSuccessOrFailure($categories_data);

if ($categories_data_status != false) {
    $categories = $categories_data->{'categories'};
} else {
    $categories = false;
}

$is_loggedin = False; 
if (isset($_SESSION['admin'])) {
        $is_loggedin = True; 
}



?>
<nav class="navbar navbar-expand-md navbar-dark bg-danger fixed-top">
    <a class="navbar-brand" href="index.php">Python Shoes</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>
    

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item">
                <a class="nav-link" href="index.php"><span class="fa fa-home"></span></a>
            <!-- <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Shop By Brand</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <?php
                    // foreach ($categories as $category) {
                    //     echo "<a class='dropdown-item' style='text-transform:capitalize' href='product_category.php?category_id={$category->id}'>{$category->name}</a>";
                    // }
                    ?>
                </div>
            </li> -->
        </ul>
        <ul class="navbar-nav right">
            
                    
            <?php if ($is_loggedin) {
               
                   echo "<li class='nav-item'>
                            <a class='nav-link' href='read_msg.php'>
                                <i class='fas fa-envelope'></i> <span class='badge badge-danger' id = 'count'></span>
                            </a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='account_settings.php'><span class='fas fa-user' aria-hidden='true'></span></a>
                        </li>
                        <li class='nav-item active'>
                            <a class='nav-link'>Administrator</a>
                        </li>
                        <li class='nav-item'>
                            <a class='nav-link' href='process_logout.php'> <span class='fa fa-sign-out' aria-hidden='true'></span></a>
                        </li>";
            } else {
                $actual_link = "$_SERVER[REQUEST_URI]";
                //var_dump($actual_link);
                if ($actual_link != 'login.php') {
                    echo "

                        <li class='nav-item active'>
                        <a class='nav-link' href='login.php'><span class='fas fa-user' aria-hidden='true'></span></a>
                        </li>
                        
                        <li class='nav-item active'>
                            <a class='nav-link' href='login.php'>Login</a>
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