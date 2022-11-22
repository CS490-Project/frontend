<?php require(__DIR__ . "/../partials/header.php"); ?>
<?php 

$student_id=$user["user_id"];
$exam_id=$_GET["id"];;

$params = ["student_id" => get_user_id(), "exam_id" => $exam_id];

$req = make_request("mid_get_grades", $params);

$answers = [];
if($req["status"] == 200){
    $answers = $req["response"];
} else {
    flash("Error retrieving exam grades");
    die(header("Location: index.php"));
}


function format_tc($tc){
    return implode(explode(' ', $tc), '<br>');
}

$exam_possible=0;
$exam_earned=0;

foreach($answers as $ans){
    $exam_possible+=floatval($ans["total_possible"]);
    $exam_earned+=floatval($ans["total_earned"]);
}
    
?>


<section id="exam_grading">
    <h2 style="text-align: right">Final Score: <?= $exam_earned ?>/<?= $exam_possible ?></h2>
    <br><br>
    <?php foreach($answers as $ans): ?>
        <div class="exam-answers" >
            <div class="student-answer">
                <p><b><?= $ans["description"] ?></b></p><br>
                <textarea class="form-input" rows="15" disabled ><?= $ans["answer"] ?></textarea>
            </div>

            <div class="grading-table">
                <table border="1">
                    <thead>
                        <tr>
                            <th>Expected</th>
                            <th>Actual</th>
                            <th>Pts Possible</th>
                            <th>Pts Earned</th>
                        </tr>
                    </thead>
                    <tbody>
                       
                        <?php foreach($ans["test_cases"] as $tc): ?>
                            <tr>
                                <td><?= $tc["expected"]; ?> </td>
                                <td><?= $tc["actual"]; ?></td>
                                <td><?= $tc["pts_possible"]; ?></td>
                                <td><?= $tc["pts_override"] ?></td>
                            </tr>
                        <?php endforeach; ?>
                        <tr>
                            <td colspan="2">
                                <p><b>Instructor Comment: </b></p><br>
                                <textarea class="form-input">
                                    <?php if(strlen($ans["comment"]) > 0 ): ?>
                                        <?= $ans["comment"] ?>
                                    <?php else: ?>
                                        No commment from instructor
                                    <?php endif ?>
                                </textarea> 
                            </td>
                            <td><b><?= $ans["total_possible"] ?><b></td>
                            <td><b><?= $ans["total_earned"]; ?></b></td>
                        </tr>
                    </tbody>
                </table>
            
            </div>

        </div>

        <?php endforeach; ?>

        
    
    
</section>
 