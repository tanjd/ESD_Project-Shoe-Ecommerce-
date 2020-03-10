<?php
require_once 'include/autoload.php';
// if (isset($_SESSION['customer_id'])) {

//     $customer_id = $_SESSION['customer_id'];

//     $POST_data = [
//         "customer_id" => $customer_id,
//     ];
//     $data = CallAPI('GET', $customer_url, 'get_customer/', $POST_data);
//     if ($data != false) {
//         $customer = $data->{'customer'};
//     } else {
//         $customer = false;
//     }
?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';
?>
<main role="main" class="container">
    <!-- <div class="starter-template"> -->
    <p class="lead">Account Settings</p>
    <form>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="tanjd@hotmail.com" readonly>
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
        </div>
        <div class="form-group">
            <label for="password">Password</label>
            <input type="password" class="form-control" id="password" name="password">
        </div>
        <div class="form-group">
            <label for="confirm_password">Confirm Password</label>
            <input type="password" class="form-control" id="confirm_password" name="confirm_password">
        </div>
        <div class="form-group form-check">
            <input type="checkbox" class="form-check-input" id="exampleCheck1">
            <label class="form-check-label" for="exampleCheck1">Check me out</label>
        </div>
        <div class="form-check">

            <input class="form-check-input" type="checkbox" value="" id="defaultCheck1">
            <label class="form-check-label" for="defaultCheck1">
                Default checkbox
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
    <!-- </div> -->

</main>
<?php
require_once 'template/footer.php';
?>