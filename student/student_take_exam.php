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


<section id="take_exam">
    <div id="question_select">
        <?php for($i = 0; $i < count($questions); $i++): ?>
            <button class="btn" onClick="change_question('exam_question_<?= $questions[$i]["question_id"] ?>', <?= $i+1 ?>)"> 
            Question <?= $i+1 ?> </button>
        <?php endfor; ?>
    </div>
    <div id="question_window">
        <form action="student_save_exam.php" method="post">
            <?php foreach($questions as $question): ?>
                <div class="exam-question" id="exam_question_<?=$question["question_id"]?>">
                    <div style="display: flex; justify-content: space-between">
                        <p> <b>Question <span class="current_position"></span> of <?= count($questions) ?></b></p> 
                        <p> <b><?=$question['value']?> pts</b></p> 
                    </div>
                     <br>

                    <p><?=$question['description']?></p> 
                    
                    <br>
                    <textarea class="form-input" id="answer" name="answer[]" rows="17"></textarea><br><br>
                    <input type="hidden" name="question_id[]" value='<?=$question["question_id"]?>'>
                </div>
            <?php endforeach; ?>
            <input type="hidden" name="exam_id" value='<?= $_GET['id']?>'>
            <br><br>
            <input type="submit" class="btn btn-block" value="Submit Exam" name="SaveExam"></br>
        </form>
    </div>

</section>

<script>

const exam_questions = document.querySelectorAll(".exam-question")

var current_question  = exam_questions[0].id

function change_question(id, position){
    document.querySelectorAll(".current_position").forEach(pos => pos.textContent = position)
    document.getElementById(current_question).style.display = "none"
    document.getElementById(id).style.display = "block"
    current_question = id
}

change_question(current_question, 1)

</script>

<?php require(__DIR__ . "/../partials/footer.php"); ?>