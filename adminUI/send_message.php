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
    <div class = "container" id="centre">
      <div class="row">
      <div class="dropdown">
                <a class="nav-link dropdown-toggle" id="dropdown01" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">Shop By Brand</a>
                <div class="dropdown-menu" aria-labelledby="dropdown01">
                    <?php
                    foreach ($categories as $category) {
                        echo "<a class='dropdown-item' style='text-transform:capitalize' href='#'>{$category->name}</a>";
                    }
                    ?>
                </div>
            </li>
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