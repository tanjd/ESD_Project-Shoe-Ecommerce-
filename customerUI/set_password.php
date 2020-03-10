<?php
require_once 'include/autoload.php';
if (isset($_SESSION['customer_id'])) {

    $customer_id = $_SESSION['customer_id'];

    $GET_data = [
        "customer_id" => $customer_id,
    ];
    $data = CallAPI('GET', $customer_url, 'get_customer/', $GET_data);
    var_dump($data);
    if ($data != false) {
        $customer = $data->{'customer'};
    } else {
        $customer = false;
    }
}
?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';
?>
<main role="main" class="container">
    <!-- <div class="starter-template"> -->
    <p class="lead">Set Password</p>
    <form>
        <div class="form-group">
            <label for="exampleInputEmail1">Email address</label>
            <input type="email" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" value="" readonly>
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
        <button type="submit" class="btn btn-primary">Submit</button>
    </form>
</main>

<?php
require_once 'template/footer.php';
?>