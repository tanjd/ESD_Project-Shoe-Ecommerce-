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


<main role="main" class="container" id="text_msg">
    <div class="starter-template">
        <p class="lead">
            <i class="fas fa-inbox" style="font-size: 100px;"></i>
            <?php if($is_loggedin){ ?>
            <h2>My Inbox </h2>


            <div class = "container" id="table1">
            <div class = "row">
            <table class="table table-hover">
            <thead class="thead-dark bg-danger">
            <h6 class="border-bottom border-gray pb-2 mb-0">Recent updates</h6>
                <tr>
                <th scope="col">Message</th>
                <th scope="col">Date</th>
                <th scope="col"></th>
                <th scope="col"></th>
                </tr>
            </thead>
            <tbody>
            <?php   
                
                    $count=0;
                    if($msg_data->status!='fail'){
                    foreach ($message as $msg) {
                        if($msg->status ==0){
                        echo "<tr>
                        
                        <td><h6><b><font color='blue'>{$msg->content_message}</font></b></h6></td>
                        <td>{$msg->created_at}</td>
                        <td ><a href='delete.php?message_id={$msg->id}&from=read_msg.php'> <i class='fas fa-trash' style='color:red;'></i></a></td>
                        <td ><a href='seen.php?message_id={$msg->id}&from=read_msg.php'> <i class='far fa-eye' style='font-size: 20px; color:#4ee44e;'></i></a></td>
                        </tr>";
                        $count++;
                        }
                        else{
                            echo "<tr>
                        
                            <td><h6><font color='black'>{$msg->content_message}</font></h6></td>
                            <td>{$msg->created_at}</td>
                            <td ><a href='delete.php?message_id={$msg->id}&from=read_msg.php'> <i class='fas fa-trash' style='color:red;'></i></a></td>
                            <td ><font color='grey'><i>Read</i></font></td>
                            </tr>";
                        $count++;
                        }
                    }
                    }
                    if ($count==0){
                        echo "<tr><td colspan='4'><h4><b>No new messages</b></h4></td></tr>";
                    }
                }
                else{
                    echo "<p></p>Please login to view messages in inbox";
                }
                
                
                ?>
               

               
            </tbody>
            </table>
            </div>
            </div>


        </p>
    </div>

</main>
<main role="main" class="container" id="d">
<div class="my-3 p-3 bg-white rounded shadow-sm">
    <h6 class="border-bottom border-gray pb-2 mb-0">Recent updates</h6>
    <?php
     $count=0;
     if($msg_data->status!='fail'){
     foreach ($message as $msg) {
         if($msg->status ==0){
    
        echo "<div class='media text-muted pt-3'>
                <svg class='bd-placeholder-img mr-2 rounded' width='32' height='32' xmlns='http://www.w3.org/2000/svg' preserveAspectRatio='xMidYMid slice' focusable='false' role='img' aria-label='Placeholder: 32x32'><title>Placeholder</title><rect width='100%' height='100%' fill='#007bff'></rect><text x='50%' y='50%' fill='#007bff' dy='.3em'>32x32</text></svg>
            <p class='media-body pb-3 mb-0 small lh-125 border-bottom border-gray'>
            <strong class='d-block text-gray-dark'>Python shoes</strong>
            <span class='badge badge-pill badge-warning'>New</span>
            {$msg->content_message}
            
        </p>
        <a href='delete.php?message_id={$msg->id}&from=read_msg.php'> <i id='testing' class='fas fa-trash' style='color:red; padding-right: 30px;'></i></a>
        <a href='seen.php?message_id={$msg->id}&from=read_msg.php'> <i id='testing' class='far fa-eye' style='font-size: 20px; color:#4ee44e; padding-right: 30px;'></i></a>
        </div>";
         }
        
        }
    }

    ?>
        
</main>
  

<?php


require_once 'template/footer.php';
?>