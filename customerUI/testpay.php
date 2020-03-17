<?php
  $_SESSION["cart"] = [
    [ 'id' => 223, "name" => "Snakeskin1","quantity"=>1, "unit_price"=>75],
    [ 'id' => 334, "name" => "Snakeskin2", "quantity"=>1, "unit_price"=>89]
                    ];

  $_total = 0;  
  foreach ($_SESSION['cart'] as $c_list){
        $product_price = $c_list['unit_price'];
        $_total += $product_price;
      }
?>

<!DOCTYPE html>

<head>
    <!-- Add meta tags for mobile and IE -->
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
</head>

<body>
    <!-- Set up a container element for the button -->
    <div id="paypal-button-container"></div>

    <!-- Include the PayPal JavaScript SDK -->
    
    <script src="https://www.paypal.com/sdk/js?client-id=sb&currency=SGD"></script>

    <script>
        // Render the PayPal button into #paypal-button-container
        var total = "<?php echo $_total ?>";
        paypal.Buttons({
            createOrder: function(data, actions) {
            // This function sets up the details of the transaction, including the amount and line item details.
            return actions.order.create({
                purchase_units: [{
                amount: {
                    value: total
                }
                }]
            });
            },
            onApprove: function(data, actions) {
            // This function captures the funds from the transaction.
            window.location.href="http://google.com";
            return actions.order.capture().then(function(details) {
                // This function shows a transaction success message to your buyer.
                alert('Transaction completed by ' + details.payer.name.given_name);
            });
            }
        }).render('#paypal-button-container');
    </script>
</body>
    