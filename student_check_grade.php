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

$total_possible=0;
$total_obtained=0;
$total_points=0;
    
?>


<section>
  
    <?php foreach($answers as $ans): ?>
            <p><?= $ans["description"] ?></p>
            <textarea disabled ><?= $ans["answer"] ?></textarea>
            <br><br>
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
                    <?php 
                        $total_possible = 0; 
                    ?>
                    <?php foreach($ans["test_cases"] as $tc): ?>
                        <?php 
                            $total_possible += floatval($tc["pts_possible"]); 
                        ?>
                        <tr>
                            <td><?= $tc["expected"]; ?> </td>
                            <td><?= $tc["actual"]; ?></td>
                            <td><?= $tc["pts_possible"]; ?></td>
                            <td><?= $tc["pts_override"] ?></td>
                        </tr>
                    <?php endforeach; ?>
                    <tr>
                        <td colspan="2"><?= $ans["comment"]; ?> </td>
                        <td><b><?= $total_possible ?><b></td>
                        <td><b><?= $ans["total_earned"]; ?></b></td>
                    </tr>
                </tbody>
            </table>
            <br>

            <?php
                $total_points+=intval($total_possible);
                $total_obtained+=intval($ans["total_earned"]);
            ?>

            <br><br>

        <?php endforeach; ?>

        Total Grade:
        <?=$total_obtained?>/<?=$total_points?>
    
    
</section>
 
