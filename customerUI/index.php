<?php
require_once 'include/autoload.php';

?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';
?>
<main role="main" class="container">
    <div class="starter-template">
        <p class="lead">
            <?php
            if ($products != false) {
                echo "<table class='table'>
                    <thead class='thead-dark'>
                    <tr>
                        <th scope='col' colspan='2'>Shoe</th>
                        <th scope='col'>Description</th>
                        <th scope='col'>Price</th>
                        <th scope='col'>Add to Cart</th>
                    </tr>";
                foreach ($products as $product) {
                    echo "<tr>
                        <td><img src='../image/{$product->image}' style='width:150px;height:100px'></td>
                        <td><a href='product.php?product_id={$product->id}'>{$product->name}</a></td>
                        <td>{$product->description}</td>
                        <td>{$product->unit_price}</td>
                        <td><button></button></td>
                    </tr>";
                }
                echo "</table>";
            }
            ?>
        </p>
    </div>
</main>
<?php
require_once 'template/footer.php';
?>