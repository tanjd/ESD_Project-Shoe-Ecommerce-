<?php
require_once 'include/autoload.php';
require_once 'template/head.php';
require_once 'template/header.php';

if (isset($_SESSION['admin']) && $_SESSION['admin'] == 'Admin'){
$categories_data = CALLAPI('GET', $product_url, 'get_all_categories');
$categories = $categories_data->categories

?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">

</head>
<body>



<main role="main" class="container">
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
          <input type="text" class="form-control" name="message" id="message" placeholder="Enter Message">
        </div>
        <p>
        <button type="submit" name='submit1' class="btn btn-success btn-block"><i class="fas fa-paper-plane"></i> Broadcast Message</button>
      </form></p>
  </div>

  <div id="subscription" class="tabcontent">
    <h4>Broadcast by Subscription</h4>
    <p><form class="form-signin" action="process_message.php" method="post">
        <div class="form-group">
        <center><label for="exampleInputPassword1"></label></center>
        <select id="categories1" name="categories1" class="mdb-select md-form" searchable="Search here.." id="exampleFormControlSelect1" >
        <option value="" disabled selected>Select a Brand to broadcast</option>
          
            <?php
                foreach ($categories as $category) {
                    var_dump($category);
                    echo "<option value='$category->id' name='$category->name' >{$category->name}</option>";
                }
                ?>
                
              </p>
          </select>
          <input type="text" class="form-control" name="message2" id="message" placeholder="Enter Message">
        </div>
        <p>
        <button type="submit" name='submit2' class="btn btn-success btn-block"><i class="fas fa-paper-plane"></i> Broadcast Message</button>
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
?>
</body>
</html> 