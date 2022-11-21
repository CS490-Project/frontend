<?php
require_once(__DIR__ . "/../utils/helpers.php"); 

if(isset($_POST["SubmitGrading"])){

    $student_id=$_POST["student_id"];
    $exam_id=$_POST["exam_id"];;

    $params = ["student_id" => $student_id, "exam_id" => $exam_id];

    $req = make_request("mid_autograde", $params);

    $answers = [];
    
    if($req["status"] == 200){
        $answers = $req["response"];
    }

    $comments = $_POST["comment"];
    $overrides = $_POST["override"];
    $over_id = 0;

    for($i=0;$i<count($answers);$i++)
    {
        
        $total_earned = 0;
        for($j=0;$j<count($answers[$i]["test_cases"]);$j++){

            $total_earned+=floatval($overrides[$over_id]);
            $answers[$i]["test_cases"][$j]["pts_override"] = floatval($overrides[$over_id]);
            $over_id += 1;
        }

        $answers[$i]["total_earned"] = $total_earned;
        $answers[$i]["comment"] = $comments[$i];
    }


    $params = [
        "student_id" => $student_id, 
        "exam_id" => $exam_id,
        "answers" => $answers
    ];
   
    $req = make_request("mid_submit_grade", $params);
    
    if($req["status"] == 200){
        flash("Successfuly Graded Exam");
    } else{
        flash("Exam Grading Error");
    }

    die(header("Location: teacher_grade_exams.php"));

}
?>