<?php
    session_start();
    $user = $_SESSION["user"];
    $data = [];
    $exams = [];

    //if(isset($_POST["get_exam"])){

    
        $data = ["teacher_id" => $user["user_id"]];
        $options = array(
        CURLOPT_URL => 'https://afsaccess4.njit.edu/~jc262/CS490/mid_get_ungraded_exam.php',
        CURLOPT_POST => true, 
        CURLOPT_POSTFIELDS => json_encode($data),
        CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
        CURLOPT_RETURNTRANSFER => true
        );

        $ch = curl_init();  //initialize curl session
        curl_setopt_array($ch, $options); 
    
        //decode json from db.php
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

        $exams = NULL;
    
        if($status == 200){
        $exams = json_decode($response, true);
        }

    //}
?>

<html>
    <div class="topnav">
        <a href="teacher_add_question.php">Add Question</a>
        <a href="teacher_create_exam.php">Make Exam</a>
        <a href="teacher_grade_exam.php">Grade Exams</a>
        <!--<a href="teacher_release_exam.php">Release Exams</a>-->
        <a href="logout.php">Logout</a>
    </div>

    <head>
        <link rel="stylesheet" type="text/css" href="styles.css">
        <style>
            main{
              padding: 2rem;
              display: flex;
            }
            main div{
              margin: 1rem 2rem;
            }
            .exam-table{
              margin: 1rem 0;
            }
        </style>
    </head>

    <body>
        <main>
        <div class="ungraded_exam-container">
              <h1>Exams To Be Graded</h1>
              <table class="ungraded-exam-table">
                  <?php foreach($exams as $exam): ?>
                    <tr class="exam" id=<?="exam-".$exam['id']; ?> >
                        <td>  <?=$exam["student_id"];?> <?= $exam['title']; ?> </td> 
                        <td> 
                        <a href="teacher_autograde_exam.php?student_id=<?=$exam['student_id'];?>&exam_id=<?=$exam['exam_id'];?>"> Grade Exam </a>
                        <td>
                    </tr>
                  <?php endforeach; ?>
                  
              </table>
            </div>
    </main>
    
</html>