<html>
  <head>
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">
    <style>
      /* Always set the map height explicitly to define the size of the div
       * element that contains the map. */
      #map {
        height:400px;
        width:25%;
      }
      /* Optional: Makes the sample page fill the window. */
      /* html, body {
        height: 100%;
        margin: 0;
        padding: 0;
      } */
    </style>
  </head>
  <body>
    <div id="map"></div>
    <script>
      var map;
      function initMap() {
        map = new google.maps.Map(document.getElementById('map'), {
          center: {lat: 1.3521, lng: 103.8198},
          zoom:12
        });
      }
    </script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyM4GQOCDrKyOUqS-Kc87Os2om92jSQS4&callback=initMap"
    async defer></script>
  </body>
</html>

<!-- <!DOCTYPE html>
<html>
  <head>
  
    <title>Simple Map</title>
    <meta name="viewport" content="initial-scale=1.0">
    <meta charset="utf-8">

  </head>
  <body>
  <style>
  #map{
      height:400px;
      width:100%;
  }
  </style>

    
    <div id="map"></div>
    <script>
      function initMap() {
        var options = {
            zoom:8,
            center:{lat:1.3521, lng:103.8198}
        }

       var map = new 
       google.maps.MAP(document.getElementbyID('map'), options); 
      }
    </script>
    
    <script async defer src="https://maps.googleapis.com/maps/api/js?key=AIzaSyAyM4GQOCDrKyOUqS-Kc87Os2om92jSQS4&callback=initMap"
    ></script>
  </body>
</html> -->
