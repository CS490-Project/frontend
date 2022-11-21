<?php
require_once(__DIR__ . "/../utils/helpers.php"); 

if (isset($_POST["SaveExam"])) 
{
    $params = [
        "student_id" => get_user_id(),
        "exam_id" => $_POST["exam_id"],
        "answers" => []
    ];

    $question_ids = $_POST['question_id'];//array of all the question ids
    $answers = $_POST['answer']; //array of the answers for the questions

    for($i=0;$i<count($question_ids);$i++)
    {
        $answer = ["answer" => $answers[$i], "question_id" => $question_ids[$i]]; //array of all the question ids
        array_push($params['answers'], $answer);
    }

    $req = make_request("mid_save_exam", $params);
    
    flash("Submitted Exam!");
    die(header("Location: student_get_ungraded_exams.php"));
}
?>