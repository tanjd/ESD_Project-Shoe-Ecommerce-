<?php
require_once('fb_login/config.php');

if (!isset($_SESSION))
{
    session_start();
}


$redirectTo = "http://localhost/ESD_project/customerUI/fb_login/callback.php";
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

<body>

  <nav class="navbar navbar-expand-md navbar-dark bg-dark fixed-top">
    <a class="navbar-brand" href="#">Python_Shoes</a>
    <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarsExampleDefault" aria-controls="navbarsExampleDefault" aria-expanded="false" aria-label="Toggle navigation">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarsExampleDefault">
      <ul class="navbar-nav mr-auto">
        <li class="nav-item active">
          <a href="login.php">Home <span class="sr-only">(current)</span></a>
        </li>
      </ul>
      <!-- <ul class="navbar-nav right">

        <li><a id="logout" href="#" onclick="logout()">Logout</a></li>

        
      </ul> -->
      <!-- <form class="form-inline my-2 my-lg-0">
        <input class="form-control mr-sm-2" type="text" placeholder="Search" aria-label="Search">
        <button class="btn btn-outline-success my-2 my-sm-0" type="submit">Search</button>
      </form> -->
    </div>
  </nav>

  <div class="container">
    <h3 id="heading">Log in to continue</h3>
    <div id="profile"></div>
    <div id="feed"></div>

    <div id="logreg-forms">

      <form class="form-signin" action="process_login.php" method="post">
        <span class="error text-danger span-error" style="text-align: center"><?php outputError() ?></span>
        <h1 class="h3 mb-3 font-weight-normal" style="text-align: center"> Sign in</h1>
        <div class="social-login">
          <button class="btn facebook-btn social-btn" type="button"><span>
              <fb:login-button id="fb-btn" scope="public_profile,email, user_birthday, user_location" onlogin="checkLoginState();">
              </fb:login-button>
            </span></button>
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
          <input type="button" onclick= "window.location = '<?php echo $fullURL ?>'" value="Sign up with Faceboo" class="btn facebook-btn social-btn"> 
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
  </div>



</body>


<main role="main" class="container">
  <!-- <div class="starter-template"> -->

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