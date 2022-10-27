<?php
    session_start();
    $user = $_SESSION["user"];
    $data = [];
    $exams = [];

    //if(isset($_POST["get_exam"])){

        $exam_id = $_POST['exam_id'];
    
        $data = ["student_id" => $user["user_id"], 'graded' => '0'];
        $options = array(
        CURLOPT_URL => 'https://afsaccess4.njit.edu/~jc262/CS490/mid_get_all_exams.php',
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
        <a href="student_get_ungraded_exams.php">Take Exam</a>
        <a href="student_get_graded_exams.php">Graded Exams</a>
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
        <div class="exam-container">
              <h1>Exams To Be Taken</h1>
              <table class="exam-table">
                  <?php foreach($exams as $exam): ?>
                    <tr class="exam" id=<?="exam-".$exam['id']; ?> >
                        <td>  <?= $exam['title']; ?> </td> 
                        <td> 
                        <a href="student_take_exam.php?id=<?=$exam['id'];?>"> Take Exam </a>
                        <td>
                    </tr>
                    
                  <?php endforeach; ?>
                  
              </table>
            </div>
    </main>
</html>


