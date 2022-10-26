<?php
// Start the session
session_start();
$user = $_SESSION["user"];
$data = [];
$questions = [];


if (isset($_POST["SaveExam"])) 
{
    $data['student_id'] = $user["user_id"];
    $data['exam_id'] = $_POST["exam_id"];
    $data['answers'] = [];
    $question_ids = $_POST['question_id']; //array of all the question ids
    $answers = $_POST['answer']; //array of the answers for the questions

    for($i=0;$i<count($question_ids);$i++)
     {
       
        $answer = ["answer" => $answers[$i], "question_id" => $question_ids[$i]]; //array of all the question ids

        array_push($data['answers'], $answer);
     }
}

$options = array(
    CURLOPT_URL => 'https://afsaccess4.njit.edu/~jc262/CS490/mid_save_exam.php',
    CURLOPT_POST => true, 
    CURLOPT_POSTFIELDS => json_encode($data),
    CURLOPT_HTTPHEADER, array('Content-Type:application/json'),
    CURLOPT_RETURNTRANSFER => true
 );

$ch = curl_init();  //initialize curl session
curl_setopt_array($ch, $options); 


//decode json from db.php
$response = curl_exec($ch);

header("Location: front_get_all_exams.php");
?>



