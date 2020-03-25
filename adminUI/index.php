<?php
require_once 'template/head.php';
require_once 'template/header.php';
require_once 'include/autoload.php';
?>





<link rel="stylesheet" href="css/login_style.css">
<link rel="stylesheet" href="css/use.fontawesome.comv5.3.1cssall" \ integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
<?php
if (isset($_SESSION['Admin']) && $_SESSION['Admin'] == 'Admin'){ ?>

<main role="main" class="container">
<div class="container-fluid">
<h1 class="mt-4">Dashboard</h1>
<ol class="breadcrumb mb-4">
<li class="breadcrumb-item active">Dashboard</li>
</ol>
<div class="row">
<div class="col-xl-3 col-md-6">
    <div class="card bg-danger text-white mb-4">
        <div class="card-body">Broadcast Message</div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="send_message.php">View Details</a>
            <div class="small text-white"><svg class="svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right"></i> --></div>
        </div>
    </div>
</div>
<div class="col-xl-3 col-md-6">
    <div class="card bg-warning text-white mb-4">
        <div class="card-body">View Delivery</div>
        <div class="card-footer d-flex align-items-center justify-content-between">
            <a class="small text-white stretched-link" href="view_delivery.php">View Details</a>
            <div class="small text-white"><svg class="svg-inline--fa fa-angle-right fa-w-8" aria-hidden="true" focusable="false" data-prefix="fas" data-icon="angle-right" role="img" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 256 512" data-fa-i2svg=""><path fill="currentColor" d="M224.3 273l-136 136c-9.4 9.4-24.6 9.4-33.9 0l-22.6-22.6c-9.4-9.4-9.4-24.6 0-33.9l96.4-96.4-96.4-96.4c-9.4-9.4-9.4-24.6 0-33.9L54.3 103c9.4-9.4 24.6-9.4 33.9 0l136 136c9.5 9.4 9.5 24.6.1 34z"></path></svg><!-- <i class="fas fa-angle-right"></i> --></div>
        </div>
    </div>
</div>

</div>
</main>
<?php }

else{
    $_SESSION['message'] = 'Please log in to continue.'; 
    $_SESSION['header_display'] = TRUE;
    header('Location: login.php'); 
    exit(); 
}

                       