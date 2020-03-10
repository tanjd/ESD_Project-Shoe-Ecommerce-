<?php
require_once 'include/autoload.php';

if (isset($_GET["product_id"])) {

    $GET_data = [
        "product_id" => $_GET["product_id"]
    ];

    $product_data = CallAPI('GET', $product_url, 'get_product/', $GET_data);
    $product_status = checkSuccessOrFailure($product_data);
    if ($product_data != false) {
        $product = $product_data->{'product'};
    } else {
        $product = false;
    }
}
?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';

// $product = [
//     "category_id" => 1,
//     "description" => "Force the sneaker community to respect you and grab the Air Force 1 Low White '07. This AF 1 Low comes with a white upper, white Nike \"Swoosh\", white midsole, and a white sole. These sneakers released in January 2018 and retailed for $90. Buy these classic sneakers today on Python Shoes.",
//     "id" => 2,
//     "image" => "nike-001.jpg",
//     "name" => "Nike Air Force 1 Low",
//     "quantity" => 10,
//     "unit_price" => 75
// ];

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
            echo ($product_table);
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