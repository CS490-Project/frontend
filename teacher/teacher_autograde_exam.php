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
        <?php foreach($answers as $ans): ?>
                <p><?= $ans["description"] ?></p>
                <textarea disabled ><?= $ans["student_answer"] ?></textarea>
                <br><br>
                <table border="1">
                    <thead>
                        <tr>
                            <th>Expected</th>
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
                <br><br>

            <?php endforeach; ?>

            <input type="submit" value="Submit Grading" name="SubmitGrading">
        </form>
    
        </section>