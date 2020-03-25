<?php
require_once 'include/autoload.php';

require_once 'template/head.php';
require_once 'template/header.php';
$categories_data = CALLAPI('GET', $product_url, 'get_all_categories');

?>


<!doctype html>
  <html lang="en">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
  <body>

    <div class="container">
      <h2>Broadcast Message</h2>

      <ul class="nav nav-tabs">
        <li class="active"><a data-toggle="tab" href="#home">Broadcast Message to All</a></li>
        <li><a data-toggle="tab" href="#menu1">Broadcast by Subscription</a></li>
        
      </ul>

      <div class="tab-content">
        <div id="home" class="tab-pane fade in active">
          <h3>Broadcast Message to All</h3>
          <p><form class="form-signin" action="process_message.php" method="post">
            <div class="form-group">
            <center><label for="exampleInputPassword1"></label></center>
              <input type="text" class="form-control" name="message" id="message" placeholder="Enter Message">
            </div>
            <p>
            <button type="submit" name='submit1' class="btn btn-secondary btn-block"><i class="fas fa-paper-plane"></i> Broadcast Message</button>
          </form></p>
        </div>
        <div id="menu1" class="tab-pane fade">
          <h3>Broadcast by Subscription</h3>
          <p><form class="form-signin" action="process_message.php" method="post">
            <div class="form-group">
            <center><label for="exampleInputPassword1"></label></center>
            <select id="categories1" name="categories1">
                <?php
                    foreach ($categories as $category) {
                        echo "<option value='$category->id' name='$category->name' >{$category->name}</option>";
                    }
                    ?>
                    
              <p></p>
              <input type="text" class="form-control" name="message2" id="message" placeholder="Enter Message">
            </div>
            <p>
            <button type="submit" name='submit2' class="btn btn-secondary btn-block"><i class="fas fa-paper-plane"></i> Broadcast Message</button>
          </form></p>
        </div>
      </div>  
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
  </main>
</html>