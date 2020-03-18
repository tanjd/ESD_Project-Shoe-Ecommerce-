<?php



require_once 'template/head.php';
require_once 'template/header.php';
require_once 'include/autoload.php';

include_once 'connection.php';

$categories_data = CALLAPI('GET', $product_url, 'get_all_categories');


?>


<!doctype html>
<html lang="en">
  <head></head>

  <body>
  
  <main role="main" class="container">
    <!-- <div class="starter-template"> -->
    
    <div id="logreg-forms">
        <form class="form-signin" action="process_message.php" method="post">
            <div class="form-group">
            <center><label for="exampleInputPassword1">Message</label></center>
              <input type="text" class="form-control" name="message" id="message" placeholder="Enter Message">
            </div>
            <p>
            <button type="submit" class="btn btn-secondary btn-block"><i class="fas fa-paper-plane"></i> Broadcast Message</button>
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

    
  </body>
</html>