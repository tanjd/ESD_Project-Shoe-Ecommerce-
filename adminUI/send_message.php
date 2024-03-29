<?php
require_once 'include/autoload.php';
require_once 'template/head.php';
require_once 'template/header.php';

if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'Admin'){
$categories_data = CALLAPI('GET', $product_url, 'get_all_categories');
$categories = $categories_data->categories;


?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.16.0/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
</head>
<body>


<main role="main" class="container">
<?php if(isset($_SESSION['message'])){ ?>
<div class="d" id="myDIV" > 
    <!-- Success Alert -->
    <div class="alert alert-success alert-dismissible fade show">
        <strong>Success!</strong> Your message has been sent successfully.
        <button type="button" class="close" data-dismiss="alert">&times;</button>
    </div>
</div>
<?php }
unset($_SESSION['message']); ?>
<h3>Broadcast Messages</h3>
  <div class="tab" style="color:red ">
    <button class="tablinks" onclick="openCity(event, 'to_all')">Broadcast to All</button>
    <button class="tablinks" onclick="openCity(event, 'subscription')">Broadcast by Subscription</button>
  </div>

  <div id="to_all" class="tabcontent">
    <h4>Broadcast to All</h4>
    <p><form class="form-signin" action="process_message.php" method="post">
        <div class="form-group">
        <center><label for="exampleInputPassword1"></label></center>
          <input type="text" class="form-control" name="message" id="message" placeholder="Enter Message" required>
        </div>
        <p>
        <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#exampleModal">
          <i class="fas fa-paper-plane"></i> Broadcast Message
        </button>

      <!-- Modal -->
      <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
        <div class="modal-dialog" role="document">
          <div class="modal-content">
            <div class="modal-header">
              <h5 class="modal-title" id="exampleModalLabel">Sending Message...</h5>
              <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                <span aria-hidden="true">&times;</span>
              </button>
            </div>
            <div class="modal-body">
              Sending this message to <b>ALL</b> customers. <br>
              Are you sure you want to continue? <br>
              Press 'OK' to continue, or Close to stay on current page.
            </div>
            <div class="modal-footer">
              <button type="submit" name='submit1' class="btn btn-primary">OK</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
              
            </div>
          </div>
        </div>
      </div>
      </form></p>
  </div>

  <div id="subscription" class="tabcontent">
    <h4>Broadcast by Subscription</h4>
    <p><form class="form-signin" action="process_message.php" method="post">
        <div class="form-group">
        <center><label for="exampleInputPassword1"></label></center>
        <select id="categories1" name="categories1" class="mdb-select md-form" searchable="Search here.." id="exampleFormControlSelect1" required>
        <option value="" disabled selected>Select a Brand to broadcast</option>
          
            <?php
                foreach ($categories as $category) {
                    var_dump($category);
                    echo "<option value='$category->id' name='$category->name' >{$category->name}</option>";
                }
                ?>
                
              </p>
          </select>
          <input type="text" class="form-control" name="message2" id="message" placeholder="Enter Message" required>
        </div>
        <p>
        <button type="button" class="btn btn-success btn-block" data-toggle="modal" data-target="#myModal">
        <i class="fas fa-paper-plane"></i> Broadcast Message
        </button>
        <div class="modal fade" id="myModal">
        <div class="modal-dialog">
          <div class="modal-content">
          
            <!-- Modal Header -->
            <div class="modal-header">
              <h4 class="modal-title">Sending Message...</h4>
              <button type="button" class="close" data-dismiss="modal">×</button>
            </div>
            
            <!-- Modal body -->
            <div class="modal-body">
              Sending this message to all relevant customers. <br>
              Are you sure you want to continue? <br>
              Press 'OK' to continue, or Cancel to stay on current page.
            </div>
            
            <!-- Modal footer -->
            <div class="modal-footer">
              <button type="submit" name='submit2' class="btn btn-primary " onclick="myFunction()">OK</button>
              <button type="button" class="btn btn-secondary" data-dismiss="modal">Cancel</button>
            </div>
            
          </div>
        </div>
      </div>
      </form></p> 
  </div>
  
</main>

<script>
function openCity(evt, cityName) {
  var i, tabcontent, tablinks;
  tabcontent = document.getElementsByClassName("tabcontent");
  for (i = 0; i < tabcontent.length; i++) {
    tabcontent[i].style.display = "none";
  }
  tablinks = document.getElementsByClassName("tablinks");
  for (i = 0; i < tablinks.length; i++) {
    tablinks[i].className = tablinks[i].className.replace(" active", "");
  }
  document.getElementById(cityName).style.display = "block";
  evt.currentTarget.className += " active";
}



</script>


<style>
body {font-family: Arial;}

/* Style the tab */
.tab {
  overflow: hidden;
  border: 1px solid #ccc;
  background-color: #f1f1f1;
}

/* Style the buttons inside the tab */
.tab button {
  background-color: inherit;
  float: left;
  border: none;
  outline: none;
  cursor: pointer;
  padding: 14px 16px;
  transition: 0.3s;
  font-size: 17px;
}
.hidden { display: none; }

/* Change background color of buttons on hover */
.tab button:hover {
  background-color: red;
}

/* Create an active/current tablink class */
.tab button.active {
  background-color: #ccc;
}

/* Style the tab content */
.tabcontent {
  display: none;
  padding: 6px 12px;
  -webkit-animation: fadeEffect 1s;
  animation: fadeEffect 1s;
}

/* Fade in tabs */
@-webkit-keyframes fadeEffect {
  from {opacity: 0;}
  to {opacity: 1;}
}

@keyframes fadeEffect {
  from {opacity: 0;}
  to {opacity: 1;}
}
input[type=text], select {
  width: 100%;
  padding: 12px 20px;
  margin: 8px 0;
  display: block;
  border: 1px solid #ccc;
  border-radius: 4px;
  box-sizing: border-box;
}
</style>

<?php }
else {
    header('Location: login.php');
    exit();
}

if (isset($_SESSION['message'])) {
  
}
?>
</body>
</html> 