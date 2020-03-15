<?php



require_once 'template/head.php';
require_once 'template/header.php';
require_once 'include/autoload.php';

include_once 'connection.php';

if(isset($_POST['send'])){
  $name = $_POST['name'];
  $msg = $_POST['msg'];
  $date = date('y-m-d h:i:s');

  $sql_insert = mysqli_query($con, "INSERT INTO message(name,content_message,scheduled_date_time) VALUES ('$name','$msg','$date')");
  if($sql_insert){

    echo "<script>alert('message send successfully');</script>";
  }
  else{
    echo mysqli_error($con);
    exit;
  }
};
?>


<!doctype html>
<html lang="en">
  <head></head>

  <body>
    <div class = "container" id="centre">
      <div class="row">
          <form method="post">
            <div class="form-group">
              <label for="exampleInputEmail1">Name</label>
              <input type="text" class="form-control" id="exampleInputEmail1" aria-describedby="emailHelp" name="name" value="Admin">
              
            </div>
              <div class="form-group">
                <label for="exampleFormControlTextarea1">Enter Message</label>
                <textarea class="form-control" id="exampleFormControlTextarea1" rows="3" name="msg"></textarea>
              </div>
            <button type="submit" name='send' class="btn btn-primary">Submit</button>
          </form>
      </div>
    </div>
    
  </body>
</html>