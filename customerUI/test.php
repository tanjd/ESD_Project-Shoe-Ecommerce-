<?php
require_once 'include/autoload.php';

$_SESSION["cart"] = [
    [
        "id" => 1,
        "quantity" => 1,
        "price" => "22.2"
    ],
    [
        "id" => 1,
        "quantity" => 1,
        "price" => "22.2"
    ],
    [
        "id" => 1,
        "quantity" => 1,
        "price" => "22.2"
    ]
];
$POST_data = [
    "cart" => $_SESSION["cart"],
    "customer_id" => '1'
];

$test_data = CallAPI('POST', $customer_url, 'test_data', $POST_data);
$test_status = checkSuccessOrFailure($test_data);

var_dump($test_data);

?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';
?>
<main role="main" class="container">
    <div class="starter-template">
        <p class="lead">ALL YOUR HTML CODES WILL COME IN HERE</p>
        <?php
        ?>
    </div>

</main>
<?php
require_once 'template/footer.php';
?>