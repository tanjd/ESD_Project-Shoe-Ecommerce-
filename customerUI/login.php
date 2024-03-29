<?php
require_once('fb_login/config.php');

if (isset($_SESSION['customer_id'])){
    header('Location: index.php');
    exit();
}

$redirectTo = "http://localhost/ESD_Project/customerUI/fb_login/callback.php";
$data = ['email'];
$fullURL = $handler->getLoginUrl($redirectTo, $data);
?>

<?php
require_once 'template/head.php';
require_once 'template/header.php';
require_once 'include/autoload.php';
?>
<link rel="stylesheet" href="css/login_style.css">
<link rel="stylesheet" href="css/use.fontawesome.comv5.3.1cssall" \ integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">


<main role="main" class="container">
    <!-- <div class="starter-template"> -->
    <div id="logreg-forms">
        <form class="form-signin" action="process_login.php" method="post">
            <span class="error text-danger span-error" style="text-align: center"><?php outputError() ?></span>
            <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Sign in</h1>
            <div class="social-login">
                <input type="button" onclick="window.location = '<?php echo $fullURL ?>'" value="Login with Facebook" class="btn facebook-btn social-btn">
                <button class="btn google-btn social-btn" type="button"><span><i class="fab fa-google-plus-g"></i> Sign in with Google+</span> </button>
            </div>
            <p style="text-align:center"> OR </p>
            <input type="email" name="input_email" id="inputEmail" class="form-control" placeholder="Email address" required="" autofocus="">
            <input type="password" name="input_password" id="inputPassword" class="form-control" placeholder="Password" required="">

            <button class="btn btn-success btn-block" type="submit"><i class="fas fa-sign-in-alt"></i> Sign in</button>
            <a href="#" id="forgot_pswd">Forgot password?</a>
            <hr>
            <!-- <p>Don't have an account!</p>  -->
            <button class="btn btn-primary btn-block" type="button" id="btn-signup"><i class="fas fa-user-plus"></i> Sign up New Account</button>
        </form>

        <form action="/reset/password/" class="form-reset">
            <input type="email" id="resetEmail" class="form-control" placeholder="Email address" required="" autofocus="">
            <button class="btn btn-primary btn-block" type="submit">Reset Password</button>
            <a href="#" id="cancel_reset"><i class="fas fa-angle-left"></i> Back</a>
        </form>

        <form action="/signup/" class="form-signup">
            <div class="social-login">
                <input type="button" onclick="window.location = '<?php echo $fullURL ?>'" value="Sign up with Faceboo" class="btn facebook-btn social-btn">
            </div>
            <div class="social-login">
                <button class="btn google-btn social-btn" type="button"><span><i class="fab fa-google-plus-g"></i> Sign up with Google+</span> </button>
            </div>

            <p style="text-align:center">OR</p>

            <input type="text" id="user-name" class="form-control" placeholder="Full name" required="" autofocus="">
            <input type="email" id="user-email" class="form-control" placeholder="Email address" required autofocus="">
            <input type="password" id="user-pass" class="form-control" placeholder="Password" required autofocus="">
            <input type="password" id="user-repeatpass" class="form-control" placeholder="Repeat Password" required autofocus="">

            <button class="btn btn-primary btn-block" type="submit"><i class="fas fa-user-plus"></i> Sign Up</button>
            <a href="#" id="cancel_signup"><i class="fas fa-angle-left"></i> Back</a>
        </form>
        <br>

    </div>
    <p style="text-align:center">
        <a href="http://bit.ly/2RjWFMfunction toggleResetPswd(e){
                    e.preventDefault();
                    $('#logreg-forms .form-signin').toggle() // display:block or none
                    $('#logreg-forms .form-reset').toggle() // display:block or none
                }

                function toggleSignUp(e){
                    e.preventDefault();
                    $('#logreg-forms .form-signin').toggle(); // display:block or none
                    $('#logreg-forms .form-signup').toggle(); // display:block or none
                }

                $(()=>{
                    // Login Register Form
                    $('#logreg-forms #forgot_pswd').click(toggleResetPswd);
                    $('#logreg-forms #cancel_reset').click(toggleResetPswd);
                    $('#logreg-forms #btn-signup').click(toggleSignUp);
                    $('#logreg-forms #cancel_signup').click(toggleSignUp);
                })g" target="_blank" style="color:black"></a>
    </p>
    <!-- </div> -->
</main>
<?php
require_once 'template/footer.php';
?>