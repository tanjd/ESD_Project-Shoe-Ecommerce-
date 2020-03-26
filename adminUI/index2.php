<?php
require_once 'template/head.php';
require_once 'template/header.php';
require_once 'include/autoload.php';
?>

<!DOCTYPE html>
<html lang="en">
<style>
.text-small {
  font-size: 0.75rem;
}
</style>
<body>
<main role="main" class="container">
    <!-- Grid row -->
<div class="row">

<!-- Grid column -->
<div class="col-lg-4 col-md-12">

  <!--Card-->
  <div class="card">

    <!--Card image-->
    <div class="view">
      <img src="https://www.serverless360.com/wp-content/uploads/2015/09/Messaging-Capabilities.jpg" class="card-img-top"
        alt="photo">
      <a href="#">
        <div class="mask rgba-white-slight"></div>
      </a>
    </div>

    <!--Card content-->
    <div class="card-body">
      <!--Title-->
      <h4 class="card-title">Delivery</h4>
      <!--Text-->
      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
        card's content.</p>
      <a href="view_delivery.php"><button type="button" class="btn btn-outline-warning btn-rounded waves-effect"><i class="fas fa-truck"></i>
        </i>View Delivery</button></a>
    </div>

  </div>
  <!--/.Card-->
  <br>
  <div class="card p-3">
    <blockquote class="blockquote mb-0 card-body">
      <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Integer posuere erat a ante.</p>
      <footer class="blockquote-footer">
        <small class="text-muted">
          Someone famous in <cite title="Source Title">Source Title</cite>
        </small>
      </footer>
    </blockquote>
  </div>
  <br>
</div>
<!-- Grid column -->

<!-- Grid column -->
<div class="col-lg-4 col-md-6">

  <!--Card-->
  <div class="card">

    <!--Card image-->
    <div class="view">
      <img src="https://braze-marketing-assets.s3.amazonaws.com/images/1400x700-API-Campaigns-Featured.png" class="card-img-top"
        alt="photo">
      <a href="#">
        <div class="mask rgba-white-slight"></div>
      </a>
    </div>

    <!--Card content-->
    <div class="card-body">
      <!--Title-->
      <h4 class="card-title">Messaging</h4>
      <!--Text-->
      <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
        card's content.</p>
        <a href="send_message.php"><button type="button" class="btn btn-outline-warning btn-rounded waves-effect"><i class="fas fa-mail-bulk"></i>
        </i>View Messaging</button></a>
    </div>
  </div>
  <!--/.Card-->

</div>
<!-- Grid column -->
<div class="col-lg-4 col-md-6">
<div class="card">

<!--Card image-->
<div class="view">
  <img src="https://cdn0.tnwcdn.com/wp-content/blogs.dir/1/files/2016/04/Computer_Science_2-796x401.jpg" class="card-img-top"
    alt="photo">
  <a href="#">
    <div class="mask rgba-white-slight"></div>
  </a>
</div>

<!--Card content-->
<div class="card-body">
  <!--Title-->
  <h4 class="card-title">Orders</h4>
  <!--Text-->
  <p class="card-text">Some quick example text to build on the card title and make up the bulk of the
    card's content.</p>
    <a href="view_delivery.php"><button type="button" class="btn btn-outline-warning btn-rounded waves-effect"><i class="fas fa-shopping-cart"></i>
        </i>View Orders</button></a>
    </div>
</div>
<br>
<div class="card text-center"">
        <div class=" card-header success-color white-text">
        Featured
        </div>
        <div class="card-body">
        <h4 class="card-title">Special title treatment</h4>
        <p class="card-text">With supporting text below as a natural lead-in to additional content.</p>
        <a class="btn btn-success btn-sm">Go somewhere</a>
        <br>

        <p class="card-text"><small class="text-muted">Last updated 3 mins ago</small></p>
        </div>
    </div>
    <br>
</div>


</div>

<!-- Grid column -->
<div class="col-lg-4 col-md-6">
    
  <!--Panel-->
    
</div>
<!-- Grid column -->

  
</div>
 
</main>
</body>
</html>
