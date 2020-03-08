<?php
    require_once '../../include/autoload.php';
    require_once '../../include/protect.php';
    require_once '../../templates/view_template.php';

    $display = 0;
    if (isset($_SESSION['cart']))
    {
        $cart = $_SESSION['cart'];
        $display = 1;
    }

    $round = false;
    $result = isAnyRoundActive();
    if ($result != false){
        $round = $result;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
</head>
<body>
    <div>
    <?php if ($display) { ?>
        <form action="process_bid_validation.php" method="POST" onsubmit="preventEmpty()">
            <?php
                echo "<h2>Your cart content: </h2>";
                if (!$round)
                {
                    echo "<span class='error text-danger span-error'><h5 style='margin-left: 8px;'>There are no active round - Checkout disabled!</h3></span>";
                }

                $error = 0;
                $success = 0;

                if (isset($_GET['error']))
                {
                    $error_type = $_GET['error'];
                    if ($error_type == 1)
                    {
                        echo "<span class='error text-danger span-error'><h5 style='margin-left: 8px;'>Please select a section before submitting!</h3></span>";
                    }
                }
                elseif (isset($_SESSION['cart_error']))
                {
                    $error = 1;
                }   
                
                if (isset($_SESSION['success_bids']))
                {
                    $success = 1;
                }

                echo "<table class='table table-hover'>";
                    echo "<tr>
                            <th>School</th>
                            <th>Course</th>
                            <th>Section</th>
                            <th>Exam date & time</th>
                            <th>Lesson day & time</th>
                            <th>Instructor</th>
                            <th> Bid amount</th>
                            <th></th>
                            <th>Actions</th>
                    </tr>"; 
                foreach($cart as $course_section => $sectionArray)
                {
                    $school = $sectionArray['school'];
                    $course = $sectionArray['course'];
                    $section = $sectionArray['section'];
                    $exam = $sectionArray['exam'];
                    $lesson = $sectionArray['lesson'];
                    $instr = $sectionArray['instr'];

                    echo "<tr>
                            <td>$school</td>
                            <td>{$course}</td>
                            <td>{$section}</td>
                            <td>$exam</td>
                            <td>$lesson</td>
                            <td>$instr</td>
                            <td><input type='text' placeholder='0.00' name='$course-$section-amt' size='1' class='amt_box'></td>
                            <td><input type='hidden' name='bidding_items[]' value='$course, $section, $school, $exam, $lesson, $instr'></td>
                            <td><a href = 'process_remove_section.php?course={$sectionArray['course']}&title=&section={$sectionArray['section']}&location=cart&school={$school}'>Remove</a></td>
                    </tr>";
                }
                    echo "<tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
                            ";
                            ?>

                            <td><input class='btn btn-primary btn-sm' type='submit' value='Checkout' <?php if (!$round) {echo "disabled";} ?>></td>

                            <?php
                    echo "
                            <td></td>
                            <td></td>
                    </tr>
                </table>";
                
                if ($success)
                {
                    outputCart_success();
                    $success = 0;
                    unset($_SESSION['success_bids']);
                }
                
                if ($error)
                {
                    outputCart_error();
                    $error = 0;
                    unset($_SESSION['cart_error']);
                }
            
            ?>        
        </form>
    <?php }
        else
        {
            //cart is empty
            echo "<h2>Your cart content: </h2>";
            echo "<table class='table table-hover'>";
            echo "<tr>
                    <th>Actions</th>
                    <th>School</th>
                    <th>Course</th>
                    <th>Section</th>
                    <th>Exam date & time</th>
                    <th>Lesson day & time</th>
                    <th>Instructor</th>
                    <th> Bid amount</th>
                    <th><input type='checkbox' onClick='toggle(this)' disabled/> Select all</th>
            </tr></table>";
            echo '
                <div style="margin-left: 8px; font-size: 1.75em;">
                <span class="error text-danger span-error"> Your cart is empty!</span>
            </div> ';
        }

        function outputCart_error()
        {
            $errors = $_SESSION['cart_error'];
            foreach ($errors as $arr)
            {
                echo "<div style='margin-left: 8px; font-size: 1.75em;'>";
                foreach ($arr as $key=>$value)
                {
                    echo "Your bid on $key: <b>Unsuccessful</b> <br>";
                    echo "<ul>";
                    foreach ($value as $item)
                    {
                        echo "<li><span class='error text-danger span-error'>$item<br></span></li>";
                        
                    }
                    echo "</ul>";
                }
                echo "</div>";
            }
        }

        function outputCart_success()
        {
            $success = $_SESSION['success_bids'];
            foreach ($success as $arr)
            {
                echo "<div style='margin-left: 8px; font-size: 1.75em;'>";
                foreach ($arr as $key=>$value)
                {
                    echo "Your bid on $key: <b>Successful</b><br>";
                    echo "<ul>";
                    echo "<li><span class='error text-danger span-error'>You have being deducted $value edollar!<br></span></li>";
                    echo "</ul>";
                }
                echo "</div>";
            }
        }
        
    ?>
    </div>
</body>

<script language="JavaScript">
    function setInputFilter(textbox, inputFilter) {
    ["input", "keydown", "keyup", "mousedown", "mouseup", "select", "contextmenu", "drop"].forEach(function(event) {
        textbox.addEventListener(event, function() {
        if (inputFilter(this.value)) {
            this.oldValue = this.value;
            this.oldSelectionStart = this.selectionStart;
            this.oldSelectionEnd = this.selectionEnd;
        } else if (this.hasOwnProperty("oldValue")) {
            this.value = this.oldValue;
            this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
        }
        });
    });
    }
    
    // Restrict input to digits and '.' by using a regular expression filter.
    var box = document.getElementsByClassName('amt_box');
    for (var i = 0; i < box.length; i++) {
        setInputFilter(box[i], function(value) {
            return /^\d*[.]?\d{0,2}$/.test(value); 
        });
    }

</script>

</html>