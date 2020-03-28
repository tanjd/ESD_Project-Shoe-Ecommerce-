<?php
require_once 'template/head.php';
require_once 'template/header.php';
require_once 'include/autoload.php';
?>
<?php
if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'Admin'){ ?>
<!DOCTYPE html>
<html lang="en">
<style>
.text-small {
  font-size: 0.75rem;
}
.card {
  box-shadow: 0 4px 8px 0 rgba(0, 0, 0, 0.2);
}

</style>
<body>
<main role="main" class="container">
<div class="card mb-4 wow fadeIn" style="visibility: visible; animation-name: fadeIn;">

        <!--Card content-->
        <div class="card-body d-sm-flex justify-content-between">

          <h4 class="mb-2 mb-sm-0 pt-1">
            <a target="_blank">Home Page</a>
            <span>/</span>
            <span>Dashboard</span>
          </h4>

          <form class="d-flex justify-content-center">
            <!-- Default input -->
            <input type="search" placeholder="Type your query" aria-label="Search" class="form-control">
            <button class="btn btn-danger btn-sm my-0 p waves-effect waves-light" type="submit">
              <i class="fas fa-search"></i>
            </button>

          </form>

        </div>

      </div>
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
      <p class="card-text">Click to view all deliveries.</p>
      <a href="view_delivery.php"><button type="button" class="btn btn-outline-warning btn-rounded waves-effect"><i class="fas fa-truck"></i>
        </i>View Delivery</button></a>
    </div>

  </div>
  <!--/.Card-->
  <br>
  <div class="card p-3">
    <blockquote class="blockquote mb-0 card-body">
      <p>We Love ESD. </p>
      <footer class="blockquote-footer">
        <small class="text-muted">
          Team G2T3 in <cite title="Source Title">Paradise</cite>
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
      <p class="card-text">Click here to send messages.</p>
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
  <div class="card-header">
    <b>Featured Brands</b>
  </div>
  <ul class="list-group list-group-flush">
    <li class="list-group-item">Nike</li>
    <li class="list-group-item">Adidas</li>
    <li class="list-group-item">Puma</li>
    <li class="list-group-item">Saucony</li>
    <li class="list-group-item">Vans</li>
  </ul>
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
<?php }
else {
    header('Location: login.php');
    exit();
}
?>