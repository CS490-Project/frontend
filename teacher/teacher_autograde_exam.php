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
<<<<<<< HEAD
    
    
?>
<section>
    <form action="teacher_release_grade.php" method="post">
        <input type="hidden" name="student_id" value="<?= $student_id?>">
        <input type="hidden" name="exam_id" value="<?= $exam_id?>">
=======

    if(isset($_POST["SubmitGrading"])){

        $comments = $_POST["comment"];
        $overrides = $_POST["override"];
        $over_id = 0;
        for($i=0;$i<count($answers);$i++)
        {
            
            $pts_earned = floatval($answers[$i]["value"]);
            for($j=0;$j<count($answers[$i]["test_cases"]);$j++){

                $pts_earned-=floatval($overrides[$over_id]);
                $answers[$i]["test_cases"][$j]["pts_override"] = floatval($overrides[$over_id]);
                $over_id += 1;
            }

            $answers[$i]["pts_earned"] = $pts_earned;
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

        header("Location: teacher_grade_exam.php");
    }


    
?>
<section>
    <form method="post">
>>>>>>> 627cf4eec17a545c1d3786526bc9912696f8e610
        <?php foreach($answers as $ans): ?>
                <p><?= $ans["description"] ?></p>
                <textarea disabled ><?= $ans["student_answer"] ?></textarea>
                <br><br>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Expected</th>
<<<<<<< HEAD
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
                
=======
                            <th>Run</th>
                            <th>Pts Possible</th>
                            <th>Pts Deducted</th>
                            <th>Deduction Override</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php foreach($ans["test_cases"] as $tc): ?>
                            <tr>
                                <td><?= $tc["expected"]; ?> </td>
                                <td><?= $tc["run"]; ?></td>
                                <td><?= $tc["pts_possible"]; ?></td>
                                <td><?= $tc["pts_deducted"] ?></td>
                                <td><input type="number" name="override[]" step="0.01" min="0" value="<?=$tc["pts_deducted"] ?>" ></th>
                            </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <br>
                <textarea name="comment[]" placeholder="Comment For Students Answer"></textarea>
>>>>>>> 627cf4eec17a545c1d3786526bc9912696f8e610
                <br><br>

            <?php endforeach; ?>

            <input type="submit" value="Submit Grading" name="SubmitGrading">
        </form>
<<<<<<< HEAD

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
=======
>>>>>>> 627cf4eec17a545c1d3786526bc9912696f8e610
    
        </section>