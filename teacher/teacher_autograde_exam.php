<?php require(__DIR__ . "/../partials/header.php"); ?>
<?php 
    $teacher_id=get_user_id();
    $student_id=$_GET["student_id"];
    $exam_id=$_GET["exam_id"];;

    $params = ["student_id" => $student_id, "exam_id" => $exam_id];

    $req = make_request("mid_autograde", $params);

    $answers = [];
    
    if($req["status"] == 200){
        $answers = $req["response"];
    }

    function format_tc($tc){
        return implode(explode(' ', $tc), '<br>');
    }
    
    
?>
<section id="exam_grading">
    <form action="teacher_release_grade.php" method="post">
        <input type="hidden" name="student_id" value="<?= $student_id?>">
        <input type="hidden" name="exam_id" value="<?= $exam_id?>">
        
            <?php foreach($answers as $ans): ?>
                <div class="exam-answers" >
                    <div class="student-answer">
                        <p><b><?= $ans["description"] ?></b></p><br>
                        <textarea class="form-input" rows="15" disabled><?= $ans["student_answer"] ?></textarea>
                    </div>

                    <div class="grading-table">
                        <table border="1">
                            <thead>
                                <tr>
                                    <th>Expected</th>
                                    <th>Actual</th>
                                    <th>Pts Possible</th>
                                    <th>Pts Earned</th>
                                    <th>Pts Override</th>
                                </tr>
                            </thead>
                            <tbody>
                                
                                <?php $total_earned = 0; ?>
                                <?php foreach($ans["test_cases"] as $tc): ?>
                                    <?php $total_earned += floatval($tc["pts_earned"]); ?>
                                    <tr>
                                        <td><?= $tc["expected"]; ?> </td>
                                        <td><?= $tc["actual"]; ?></td>
                                        <td><?= $tc["pts_possible"]; ?></td>
                                        <td><?= $tc["pts_earned"] ?></td>
                                        <td><input type="number" name="override[]" step="any" min="0" 
                                            onchange="change_override(<?= $ans['question_id'] ?>)" 
                                            class="override_<?= $ans["question_id"] ?>" 
                                            value="<?=$tc["pts_earned"] ?>" >
                                        </td>
                                    </tr>
                                <?php endforeach; ?>
                                    <tr>
                                        <td colspan="2">
                                            <p><b>Instructor Comment: </b></p><br>
                                            <textarea name="comment[]" class="form-input"
                                                placeholder="Comment For Students Answer"></textarea> 
                                        </td>
                                        <td><b><?= $ans["value"] ?><b></td>
                                        <td><b><?= $total_earned ?><b></td>
                                        <td id="total_override_<?= $ans["question_id"] ?>"><?= $total_earned ?></td>
                                    </tr>
                            </tbody>
                        </table>
                    </div>

                 </div>
                 

                <?php endforeach; ?>

            <br>
            <input type="submit" class="btn btn-block" value="Submit Grading" name="SubmitGrading">
        </form>

        <script>
        

            function change_override(id){
                
                const overrides = document.querySelectorAll(`.override_${id}`)

                let total = 0
                overrides.forEach(override => {
                    total+=Number(override.value)
                    console.log(override)
                })
        
                document.getElementById(`total_override_${id}`).textContent = total
            }

        </script>
    
        </section>