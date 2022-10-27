<?php 
session_start();
$user = $_SESSION["user"];
$teacher_id=$user["user_id"];
$student_id=$_GET["student_id"];
$exam_id=$_GET["exam_id"];;

$params = ["student_id" => $student_id, "exam_id" => $exam_id];
$options = array(
    CURLOPT_URL => 'https://afsaccess4.njit.edu/~jc262/CS490/mid_autograde.php',
    CURLOPT_POST => true, 
    CURLOPT_POSTFIELDS => json_encode($params),
    CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
    CURLOPT_RETURNTRANSFER => true
);

$ch = curl_init();  //initialize curl session
curl_setopt_array($ch, $options); 


//decode json from db.php
$response = curl_exec($ch);
$status = curl_getinfo($ch, CURLINFO_HTTP_CODE);

$answers = json_decode($response, true);

function format_tc($tc){
    return implode(explode(' ', $tc), '<br>');
}

if(isset($_POST["SubmitGrading"])){
    $data = [];

    $overrides = $_POST["override"];
    $comments = $_POST["comment"];

    for($i=0;$i<count($overrides);$i++)
     {
        
        $graded_answer = [
            "expected" => $answers[$i]["tests"]["expected"],
            "run" => $answers[$i]["tests"]["run"],
            "pts_possible" => $answers[$i]["tests"]["ptspossible"],
            "pts_deducted" => $answers[$i]["tests"]["ptsdeducted"],
            "pts_override" => $overrides[$i],
            "comment" => $comments[$i],
            "student_id" => $student_id,
            "exam_id" => $exam_id,
            "question_id" => $answers[$i]["question_id"]
 
        ];
        array_push($data, $graded_answer);
     }
     //Put in back
    
    $options = array(
        CURLOPT_URL => 'https://afsaccess4.njit.edu/~jc262/CS490/mid_submit_grade.php',
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

    header("Location: teacher_grade_exam.php");
}


    
?>
<html lang="en">
<div class="topnav">
        <a href="teacher_add_question.php">Add Question</a>
        <a href="teacher_create_exam.php">Make Exam</a>
        <a href="teacher_grade_exam.php">Grade Exams</a>
        <!--<a href="teacher_release_exam.php">Release Exams</a>-->
        <a href="logout.php">Logout</a>
</div>

<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <form method="post">
        <?php foreach($answers as $ans): ?>
                <p><?= $ans["description"] ?></p>
                <textarea disabled ><?= $ans["student_answer"] ?></textarea>
                <br><br>
                <table>
                    <tr>
                        <th>Expected</th>
                        <th>Run</th>
                        <th>Pts Possible</th>
                        <th>Pts Deducted</th>
                        <th>Deduction Override</th>
                    </tr>
                    <tbody>
                        <tr>
                            <td><?= format_tc($ans["tests"]["expected"]) ?> </td>
                            <td><?= format_tc($ans["tests"]["run"]) ?></td>
                            <td><?= $ans["tests"]["ptspossible"] ?></td>
                            <td> - <?= $ans["tests"]["ptsdeducted"] ?></td>
                            <td><input type="number" name="override[]" value="<?=$ans["tests"]["ptsdeducted"] ?>" ></th>
                        </tr>
                    </tbody>
                </table>
                <br>
                <textarea name="comment[]" placeholder="Comment For Students Answer"></textarea>
                <br><br>

            <?php endforeach; ?>

            <input type="submit" value="Submit Grading" name="SubmitGrading">
        </form>
    

</body>
</html>