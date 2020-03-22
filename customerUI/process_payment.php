<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>

<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.6/umd/popper.min.js"
    integrity="sha384-wHAiFfRlMFy6i5SRaxvfOCifBUQy1xHdJ/yoi7FRNXMRBu5WHdZYu1hA6ZOblgut"
    crossorigin="anonymous"></script>

<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.2.1/js/bootstrap.min.js"
    integrity="sha384-B0UglyR+jN6CkvvICOB2joaf5I4l3gm9GU6Hc1og6Ls7i6U/mkkaduKaBhlAXv9k"
    crossorigin="anonymous"></script>

<?php
require_once 'include/autoload.php';
require_once 'template/head.php';
require_once 'template/header.php';
var_dump($_SESSION['cart']);
?>

<?php
$markers_data = CallAPI('GET', $delivery_url, 'get_all_markers');
$markers_status = checkSuccessOrFailure($markers_data);
if ($markers_status != false) {
    $markers = true;} else {
    $markers = false;}

$markers = $markers_data->{'markers'};

$marker_coords = array();
foreach($markers as $marker_object){
    $location_lat = $marker_object->{'lat'} ;
    $location_lng = $marker_object->{'lng'} ;

    $indv_coords = array($location_lat, $location_lng);
    array_push($marker_coords, $indv_coords);
    }
//var_dump($marker_coords);
?> 


<main role="main" class="container">
    <div class="starter-template">
        <?php
            $cart_total = 0;
            echo "<table class='table table-hover'>";
            echo "  <tr><td colspan='2'><h2>Confirmed Items</h2></td></tr>
                    <tr>
                        <th>Name</th>
                        <th>Price</th>
                        <th></th>
                    </tr>";

            foreach ($_SESSION['cart'] as $contentArray) {
                $id = $contentArray['id'];
                $name = $contentArray['name'];
                $unit_price = number_format($contentArray['unit_price'], 2, '.', ',');
                $quantity = $contentArray['quantity']; 

                echo "<tr>
                        <td>$name</td>
                        <td>$$unit_price</td>
                    </tr>";
                    $cart_total += $unit_price * $quantity;
                }
        ?>
        
        <tr>
            <th colspan='1'>Total</th>
            <th colspan = '1'><?php echo "\$$cart_total" ?></th>
        </tr>


        <tr><td><br><br></td></tr>
        <tr>
            <td colspan='2'><h2>Delivery Address</h2></td>
        </tr>
        <tr>
            <td colspan='2'>
                <meta name="viewport" content="initial-scale=1.0">
                <meta charset="utf-8">
                <style>      
                #map {
                    height:400px;
                    width:78%;
                    }
                </style>
                    <body>
                        <div id="map"></div>

                        <script>
                                // Initialize and add the map
                                function initMap() {
                                // The location of singapore
                                var locations = <?php echo json_encode($marker_coords)?>
                                // The map, centered at singapore
                                var map = new google.maps.Map(document.getElementById('map'), {
                                    zoom: 10,
                                    center: new google.maps.LatLng(1.3521, 103.8198),
                                    mapTypeId: google.maps.MapTypeId.ROADMAP
                                    });

                                var marker, i;
                                    for (i = 0; i < locations.length; i++) {  
                                    marker = new google.maps.Marker({
                                        position: new google.maps.LatLng(locations[i][0], locations[i][1]),
                                        map: map
                                    });
                                }
                            }
                        </script>
                        
                        <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyM4GQOCDrKyOUqS-Kc87Os2om92jSQS4&callback=initMap"
                        async defer>
                        </script>

                    </body>
                </td>
            </tr>

                     
            <tr><th>Address for Delivery</th><td>
        
        <form action="process_payment.php" method="post">
        <?php
                $markers = $markers_data->{'markers'};
                echo "<select id='location' name='location' size='1'>";
                foreach($markers as $marker_object){
                    $location_name = $marker_object->{'name'};
                    echo '<option name="location" , value="'.$location_name.'" selected>'.$location_name.'</option>';}                
        ?>
        <input type="submit">
            </td></tr>
        
        <?php 
            if (isset( $_POST["cart"])){
                $_SESSION['delivery'] = $_POST["location"];} 
                ?>
        
        <?php var_dump( $_SESSION['delivery']); ?>

        <tr><td><br><br></td></tr>
        <tr>
            <td colspan='2'><h2>Payment</h2></td>
        </tr>

        <tr>
            <td colspan = '2'>
            <meta http-equiv="X-UA-Compatible" content="IE=edge" /> <!-- Optimal Internet Explorer compatibility -->
            <script
            src="https://www.paypal.com/sdk/js?client-id=AbIxMLEzEKKNL3RneA8f1FmkHiXf178hxTJR7PLfL9qW1ZNKzElEKGUTj5-Ki3I-N53iH-oYBSUP4nY8"> // Required. Replace SB_CLIENT_ID with your sandbox client ID.
            </script>

    <div id="paypal-button-container"></div>

<?php
  $_total = 0;  
  foreach ($_SESSION['cart'] as $c_list){
        $product_price = $c_list['unit_price'];
        $_total += $product_price;
      }
?>

        <script>
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
            window.location.href="http://localhost/esd_project/customerUI/completed.php";
            return actions.order.capture().then(function(details) {
        // This function shows a transaction success message to your buyer.
            alert('Transaction completed by ' + details.payer.name.given_name);
                                                                });
                }
            }).render('#paypal-button-container');
        //This function displays Smart Payment Buttons on your web page.
  </script>
            </td>
        </tr>
</main>  

<?php
//require_once 'template/footer.php';
?>



<!-- <script>
// Initialize and add the map
function initMap() {
// The location of singapore
var singapore = {lat: 1.3521, lng: 103.8198};
var pasir_ris = {lat: 1.3692, lng: 103.9500};
// The map, centered at singapore
var map = new google.maps.Map(
document.getElementById('map'), {zoom: 12, center: singapore});

function addMarkers(coords){
var marker = new google.maps.Marker({position: coords, map: map});
}
addMarkers(singapore);
addMarkers(pasir_ris);
}
</script> -->