<?php
require_once 'include/autoload.php';

$data = CallAPI('GET', $customer_url, 'get_all_customers');
$status = checkSuccessOrFailure($data);
if ($status != false) {
    $customers = $data->{'customers'};
} else {
    $customers = false;
}

$product_data = CallAPI('GET', $product_url, 'get_all_products');
$product_status = checkSuccessOrFailure($product_data);
if ($product_data != false) {
    $product = $product_data->{'product'};
} else {
    $product = false;
}

?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';

#Process product table
if ($product_data == True){
    $product_table = "<table class='table'>
                    <thead class='thead-dark'>
                    <tr>
                        <th scope='col' colspan='2'>Shoe</th>
                        <th scope='col'>Description</th>
                        <th scope='col'>Price</th>
                    </tr>";
    for ($i=0; $i<count($product); $i++){
        // $product_name = $product[$i]->name;
        $product_table .= "<tr>
                        <td><img src='../product/image/{$product[$i]->image}' style='width:150px;height:100px'></td>
                        <td>{$product[$i]->name}</td>
                        <td>{$product[$i]->description}</td>
                        <td>\${$product[$i]->unit_price}</td> 
                        </tr> ";
    }
    $product_table .= "</table>";
} else {
    $product_table = $product_status;
}


?>

<main role="main" class="container">
    <div class="starter-template">
        <p class="lead">
        <?php
        echo($product_table);
        ?>
        </p>
        <?php
        // var_dump($customers);

        // foreach ($customers as $customer) {
        //     echo "this is the emails " . $customer->{'email'} . "<br>";
        // }
        ?>
    </div>
</main>
<?php
require_once 'template/footer.php';
?>