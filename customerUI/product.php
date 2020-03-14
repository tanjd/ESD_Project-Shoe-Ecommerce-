<?php
require_once 'include/autoload.php';

if (isset($_GET["product_id"])) {

    $GET_data = [
        "product_id" => $_GET["product_id"]
    ];

    $product_data = CallAPI('GET', $product_url, 'get_product/', $GET_data);
    $product_status = checkSuccessOrFailure($product_data);
    if ($product_status != false) {
        $product = $product_data->{'product'};
    } else {
        $product = false;
    }
}
?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';

$product_table = "<table class='table table-bordered'>
                    <tbody>
                    <tr>
                        <td scope='row' rowspan = '4' colspan = '6'><img src='../image/{$product->image}' style='width:500px;height:450px'></td>
                        <th scope='col' colspan = '10'><h1>{$product->name}</h1></th>
                    </tr>
                    <tr>
                        <td scope='row' colspan = '4' align='left'>{$product->description}</td>
                    </tr>
                    <tr>
                        <td scope='row' colspan = '4'><h2>\${$product->unit_price}</h2></td>
                    </tr>
                    <tr>
                        <td scope='row' colspan = '2'>placeholder for size drop down list</td>
                        <td scope='row'><button type='button' class='btn btn-dark' style='width:150px;height:100px'>Add To Cart</button></td>
                    </tr>
                    </tbody>
                    </table>";

?>

<main role="main" class="container">
    <div class="starter-template">
        <p class="lead">
            <?php
            if ($product != false) {
                echo "<table class='table table-bordered'>
                <tbody>
                <tr>
                    <td scope='row' rowspan = '4' colspan = '6'><img src='../image/{$product->image}' style='width:500px;height:450px'></td>
                    <th scope='col' colspan = '10'><h1>{$product->name}</h1></th>
                </tr>
                <tr>
                    <td scope='row' colspan = '4' align='left'>{$product->description}</td>
                </tr>
                <tr>
                    <td scope='row' colspan = '4'><h2>\${$product->unit_price}</h2></td>
                </tr>
                <tr>
                    <td scope='row'>
                        <a href='process_add_to_cart.php?product_id={$product->id}&from=product.php?product_id={$product->id}'>
                            <button type='button' class='btn btn-dark' style='width:150px;height:100px'>Add To Cart</button>
                        </a>
                    </td>
                    </tr>
                </tbody>
                </table>";
            }
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