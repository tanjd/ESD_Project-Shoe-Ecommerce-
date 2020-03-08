<?php

if (isset($_SESSION['customer_id'])) {

    $customer_id = $_SESSION['customer_id'];

    $POST_data = [
        "customer_id" => $customer_id,
    ];
    $data = CallAPI('GET', $customer_url, 'get_customer/', $POST_data);
    if ($data != false) {
        $customer = $data->{'customer'};
    } else {
        $customer = false;
    }

    $is_loggedin = true;
    $quantity = 0;
} else {

    $quantity = 0;
    $is_loggedin = false;
}

?>
<nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Navbar</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
        <ul class="navbar-nav mr-auto">
            <li class="nav-item active">
                <a class="nav-link" href="#">Home <span class="sr-only">(current)</span></a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">Link</a>
            </li>
            <li class="nav-item">
                <a class="nav-link disabled" href="#">Disabled</a>
            </li>
            <li class="nav-item dropdown">
                <a class="nav-link dropdown-toggle" href="http://example.com" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Dropdown</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <a class="dropdown-item" href="#">Action</a>
                    <a class="dropdown-item" href="#">Another action</a>
                    <a class="dropdown-item" href="#">Something else here</a>
                </div>
            </li>
        </ul>
        <ul class="navbar-nav right">
            <li class="nav-item">
                <a class="nav-link" href="#"><span class="fa fa-user-circle-o" aria-hidden="true"></span>Your Account</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" href="#">
                    <i class="fa fa-shopping-cart"></i> Cart <span class="badge"><?php if ($quantity != 0) {
                                                                                        echo " $quantity";
                                                                                    }  ?></span>
                </a>
            </li>
        </ul>

        <!-- <li class="nav-item">
            <a class="nav-link" href="#"> <span class="fa fa-user-circle-o" aria-hidden="true"></span><?php echo " $name" ?></a>
        </li>
        <li class="nav-item">
            <a class ="nav-link" href="<?php echo $course; ?>cart.php" id="cart">
                <i class="fa fa-shopping-cart"></i> Cart <span class="badge"><?php if ($quantity != 0) {
                                                                                    echo " $quantity";
                                                                                }  ?></span>
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="<?php echo $index; ?>process_logout.php"> <span class="fa fa-sign-out" aria-hidden="true"></span> Logout</a>
        </li> -->
        <!-- <form class="form-inline my-2 my-lg-0">
      <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
      <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
    </form> -->
    </div>
</nav>

<div class="jumbotron">
    <div class="container text-center">
        <h1>Python Shoe Shop</h1>
        <p>A microservice Shoe Shop</p>
    </div>
</div>