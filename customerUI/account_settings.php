<?php
require_once 'include/autoload.php';
if (isset($_SESSION['customer_id'])) {

    $customer_id = $_SESSION['customer_id'];

    $GET_data = [
        "customer_id" => $customer_id,
    ];
    $data = CallAPI('GET', $customer_url, 'get_customer/', $GET_data);
    if ($data != false) {
        $customer = $data->{'customer'};
    } else {
        $customer = false;
    }
}

if ($customer == false){
    header('Location: login.php'); 
    exit(); 
}
?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';
?>
<main role="main" class="container">
    <!-- <div class="starter-template"> -->
    <p class="lead">Account Settings</p>
    <span class="error text-danger span-error" style="text-align: center"><?php outputError() ?></span>
    <form action="process_update_setting.php" method="post">
        <div class="form-group">
            <label for="email">Email address:</label>
            <input type="email" class="form-control" id="email" aria-describedby="emailHelp" name="email" value="<?php echo $customer->email ?>">
            <small id="emailHelp" class="form-text text-muted">We'll never share your email with anyone else.</small>
            <label for="address">Address:</label>
            <input type="text" class="form-control" id="address" aria-describedby="emailHelp" name="address" value="<?php echo $customer->address ?>">
            <small id="emailHelp" class="form-text text-muted"></small>
            <label for="postal_code">Postal Code:</label>
            <input type="text" class="form-control" id="postal_code" aria-describedby="emailHelp" name="postal_code" value="<?php echo $customer->postal_code ?>">
            <small id="emailHelp" class="form-text text-muted"></small>
            <label for="telegram_id">telegram_id:</label>
            <input type="text" class="form-control" id="telegram_id" aria-describedby="emailHelp" name="telegram_id" value="<?php echo $customer->telegram_id ?>">
            <small id="emailHelp" class="form-text text-muted"></small>
        </div>
        <p class="lead">Select mediums to be notified:</p>
        <div class="form-group form-check">
            <?php
                $email_setting = '';
                if ($customer->email_setting == true){
                    $email_setting = 'checked';
                }
            ?>
            <input type = "hidden" id="email_setting" name ="email_setting" value = false>
            <input type="checkbox" class="form-check-input" id="email_setting" value = true name ="email_setting" <?php echo $email_setting ?>>
            <label class="form-check-label" for="email_setting">Email</label>
        </div>
        <div class="form-check">
            <?php
                $telegram_setting = '';
                if ($customer->telegram_setting == true){
                    $telegram_setting = 'checked';
                }
            ?>
            <input type = "hidden" id="telegram_setting" name ="telegram_setting" value = false>
            <input type="checkbox" class="form-check-input" id="telegram_setting" value = true name ="telegram_setting" <?php echo $telegram_setting ?>>
            <label class="form-check-label" for="telegram_setting">Telegram</label>
        </div>
        <br>
        <button type="submit" class="btn btn-primary">Update settings</button>
    </form>
    <!-- </div> -->

</main>
<?php
require_once 'template/footer.php';
?>