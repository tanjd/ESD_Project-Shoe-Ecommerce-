<?php
    require_once '../../include/autoload.php';
    require_once '../../include/protect.php';
    require_once '../../templates/view_template.php';

    if (isset($_GET['course']) and isset($_GET['section']) and isset($_GET['title'])) {
        $school = $_GET['school'];
        $course = $_GET['course'];
        $section = $_GET['section'];
        $title = $_GET['title'];
        $exam = $_GET['exam'];

        $exam_date = trim(explode("|", $exam)[0]);
        $exam_start = trim(explode("-",explode("|", $exam)[1])[0]);
        $exam_end = trim(explode("-",explode("|", $exam)[1])[1]);

        $lesson = $_GET['lesson'];
        $instr = $_GET['instr'];
        $venue = $_GET['venue'];
        $size = $_GET['size'];
        
        $sectionArray[]= [
            'school'=>$school,
            'course'=>$course,
            'section'=>$section,
            'title'=>$title,
            'exam'=>$exam,
            'lesson'=>$lesson,
            'instr'=>$instr,
            'venue'=>$venue,
            'size'=>$size
        ];
        
        if (isset($_SESSION['cart']))
        {
            if (!isEmpty($_SESSION['cart'])) //not empty
            {
                //add to session
                $_SESSION["cart"] = array_merge($_SESSION["cart"],$sectionArray);
                header("Location: course_sections.php?course={$course}&title={$title}&school={$school}");
                return;
                exit();
            }
            else 
            {
                $_SESSION["cart"] = $sectionArray;
                header("Location: course_sections.php?course={$course}&title={$title}&school={$school}");
                exit();
            }
        }
        else
        {
            $_SESSION['cart'] = $sectionArray;
            //echo '$_SESSION[cart doesnt exist]';
            //var_dump($_SESSION);
            header("Location: course_sections.php?course={$course}&title={$title}&school={$school}");
            exit();
        }
    }
?>
