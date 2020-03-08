<?php
require_once 'include/autoload.php';

$data = CallAPI('GET', $customer_url, 'get_all_customers');
if ($data != false) {
    $customers = $data->{'customers'};
} else {
    $customers = false;
}

?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';
?>

<main role="main" class="container">
    <div class="starter-template">
        <p class="lead">ALL YOUR HTML CODES WILL COME IN HERE</p>
        <?php
        var_dump($customers);

        // foreach ($customers as $customer) {
        //     echo "this is the emails " . $customer->{'email'} . "<br>";
        // }
        ?>
    </div>
</main>
<?php
require_once 'template/footer.php';
?>