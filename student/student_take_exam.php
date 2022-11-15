<?php require(__DIR__ . "/../partials/header.php"); ?>
<?php 
$exam = NULL;

$params = ["exam_id" => $_GET['id']];
$req = make_request("mid_request_exam", $params);

if($req["status"] == 200){
    $exam = $req["response"];
} else {
    flash("This exam is not available or doesn't exist");
    die(header("Location: student_get_ungraded_exams.php"));
}

$questions=$exam["questions"];

?>

       
<form action="student_save_exam.php" method="post">
    <?php foreach($questions as $question): ?>
        <p><?=$question['description']?> <br> <?=$question['value']?> pts </p> 
        <textarea id="answer" name="answer[]" rows="4" cols="50"></textarea><br><br>
        <input type="hidden" name="question_id[]" value='<?=$question["question_id"]?>'>
    <?php endforeach; ?>
    <input type="hidden" name="exam_id" value='<?= $_GET['id']?>'>
    <input type="submit" value="Submit Exam" name="SaveExam"></br>
</form>


<?php require(__DIR__ . "/../partials/footer.php"); ?>