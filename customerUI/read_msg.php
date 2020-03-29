<?php
require_once 'include/autoload.php';

require_once 'template/head.php';
require_once 'template/header.php';

if($is_loggedin){
    $POST_data = [
        "customer_id" => $_SESSION['customer_id']
    ];
    $msg_data = CallAPI('POST', $message_url, 'get_messages_by_customer', $POST_data);
    
    if($msg_data->status!='fail'){
        $message = $msg_data->{'messages'};
    }
    
    
}

?>
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.4.1/jquery.min.js"></script>
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>
<style>
.media:hover {
  background-color: #F5F5F5;
}
.media {border-bottom: 1px solid grey };
</style>

<main role="main" class="container">
    <center><i class="fas fa-inbox" style="font-size: 100px;"></i>
    <?php if($is_loggedin){ ?>
    <h2>My Inbox </h2></center>
  
<div class="my-3 p-3 bg-white rounded shadow-sm">
    <h5>Keep up with latest updates</h5>  
    <input class="form-control" id="myInput" type="text" placeholder="Search current inbox...">
    <br>
    <h6 class="border-bottom border-gray pb-2 mb-0" style="color: blue">Recent updates</h6>
    <ul class="list-group" id="myList">
    <?php
     $count=0;
     if($msg_data->status!='fail'){
     foreach ($message as $msg) {
         if($msg->status ==0){
            
        echo "
        <ul class='list-unstyled' id='myList'>
        <li class='media' style='padding-top: 10px'>
        <svg class='bd-placeholder-img mr-2 rounded align-self-start' width='32' height='32' xmlns='http://www.w3.org/2000/svg' preserveAspectRatio='xMidYMid slice' focusable='false' role='img' aria-label='Placeholder: 32x32'><title></title><rect width='100%' height='100%' fill='#10499A'></rect><text x='50%' y='50%' fill='#10499A' dy='.3em'>32x32</text></svg>
            <p class='media-body pb-3 mb-0 small lh-125 border-bottom border-gray'>
            <strong class='d-block text-gray-dark' style=' font-size: 15px;'>Python shoes</strong>
            <span class='badge badge-pill badge-warning' style='padding-left: 5px'>New  </span><a style='font-size: 15px; color: black'>     {$msg->content_message}</a>
            </p>

        <strong style='font-size: 10px; color:grey; padding-right: 30px;'>{$msg->created_at}</strong>
        <a href='delete.php?message_id={$msg->id}&from=read_msg.php'> <i id='testing' class='fas fa-trash' style='color:red; padding-right: 30px; padding-top: 10px;'></i></a>
        <a href='seen.php?message_id={$msg->id}&from=read_msg.php' padding-right: 40px; font-size: 15px; padding-top: 50px;'> Mark as read</a>
        </li>";
        $count++;
         }
         else{
            echo "<ul class='list-unstyled' id='myList'>
            <li class='media' style='padding-top: 10px'>
            <svg class='bd-placeholder-img mr-2 rounded align-self-start' width='32' height='32' xmlns='http://www.w3.org/2000/svg' preserveAspectRatio='xMidYMid slice' focusable='false' role='img' aria-label='Placeholder: 32x32'><title></title><rect width='100%' height='100%' fill='#DEDEDE'></rect><text x='50%' y='50%' fill='#DEDEDE' dy='.3em'>32x32</text></svg>
                <p class='media-body pb-3 mb-0 small lh-125 border-bottom border-gray'>
                <strong class='d-block text-gray-dark' style=' font-size: 15px; color: grey'>Python shoes</strong>
                <a style='font-size: 15px; color: grey'> {$msg->content_message}</a>
                </p>
    
            <strong style='font-size: 10px; color:grey; padding-right: 30px;'>{$msg->created_at}</strong>
            <a href='delete.php?message_id={$msg->id}&from=read_msg.php'> <i id='testing' class='fas fa-trash' style='color:red; padding-right: 53px; padding-top: 10px;'></i></a>
            <a style='color:grey; padding-right: 40px; font-size: 15px; padding-top: 7px;' ><i style=''> read </i></a>
            </li>";
        $count++;
        
        }
    }
    echo "</ul>";
    }
    if ($count==0){
        echo "<p></p><tr><center><td colspan='4' ><h4><b style='color: black';>No new messages</b></h4></td></center></tr>";
        }
        }
        else{
        echo "<p></p>Please login to view messages in inbox
                <p></p>";
        }

    ?>
        
</main>
<script>
$(document).ready(function(){
  $("#myInput").on("keyup", function() {
    var value = $(this).val().toLowerCase();
    $("#myList li").filter(function() {
      $(this).toggle($(this).text().toLowerCase().indexOf(value) > -1)
    });
  });
});
</script>

<?php


require_once 'template/footer.php';
?>