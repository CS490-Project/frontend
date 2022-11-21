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
<section>
    <form action="teacher_release_grade.php" method="post">
        <input type="hidden" name="student_id" value="<?= $student_id?>">
        <input type="hidden" name="exam_id" value="<?= $exam_id?>">
        <?php foreach($answers as $ans): ?>
                <p><?= $ans["description"] ?></p>
                <textarea disabled ><?= $ans["student_answer"] ?></textarea>
                <br><br>
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
                        
                        <?php 
                            $total_possible = 0; 
                            $total_earned = 0; 
                        ?>
                        <?php foreach($ans["test_cases"] as $tc): ?>
                            <?php 
                                $total_possible += floatval($tc["pts_possible"]); 
                                $total_earned += floatval($tc["pts_earned"]); 
                            ?>
                            <tr>
                                <td><?= $tc["expected"]; ?> </td>
                                <td><?= $tc["actual"]; ?></td>
                                <td><?= $tc["pts_possible"]; ?></td>
                                <td><?= $tc["pts_earned"] ?></td>
                                <td><input type="number" name="override[]" step="any" min="0" 
                                onchange="change_override(<?= $ans['question_id'] ?>)" 
                                class="override_<?= $ans["question_id"] ?>" 
                                value="<?=$tc["pts_earned"] ?>" ></th>
                            </tr>
                        <?php endforeach; ?>
                            <tr>
                               <td colspan="2"><textarea name="comment[]" placeholder="Comment For Students Answer"></textarea> </td>
                               <td><b><?= $total_possible ?><b></td>
                               <td><b><?= $total_earned ?><b></td>
                               <td id="total_override_<?= $ans["question_id"] ?>"><?= $total_earned ?></td>
                            </tr>
                    </tbody>
                </table>
                <br>
                
                <br><br>

            <?php endforeach; ?>

            <input type="submit" value="Submit Grading" name="SubmitGrading">
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