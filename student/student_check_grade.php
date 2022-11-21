<<<<<<< HEAD
<?php require(__DIR__ . "/../partials/header.php"); ?>
=======

>>>>>>> 627cf4eec17a545c1d3786526bc9912696f8e610
<?php 

$student_id=$user["user_id"];
$exam_id=$_GET["id"];;

<<<<<<< HEAD
$params = ["student_id" => get_user_id(), "exam_id" => $exam_id];

$req = make_request("mid_get_grades", $params);

$answers = [];
if($req["status"] == 200){
    $answers = $req["response"];
} else {
    flash("Error retrieving exam grades");
    die(header("Location: index.php"));
}

=======
$params = ["student_id" => ge_user_id(), "exam_id" => $exam_id];
$options = array(
    CURLOPT_URL => 'https://afsaccess4.njit.edu/~jc262/CS490/mid_get_grades.php',
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
>>>>>>> 627cf4eec17a545c1d3786526bc9912696f8e610

function format_tc($tc){
    return implode(explode(' ', $tc), '<br>');
}

$total_possible=0;
$total_obtained=0;
    
?>
<<<<<<< HEAD


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
           
            <br><br>

        <?php endforeach; ?>

        
    
    
</section>
 
=======
<html lang="en">
<div class="topnav">
        <a href="student_get_ungraded_exams.php">Take Exam</a>
        <a href="student_get_graded_exams.php">Graded Exams</a>
        <a href="logout.php">Logout</a>
</div>   


<head>
    <link rel="stylesheet" type="text/css" href="styles.css">
</head>
<body>
    <form method="post">
        <?php foreach($answers as $ans): ?>
                <p><?= $ans["description"] ?></p>
                <textarea disabled ><?= $ans["answer"] ?></textarea>
                <br><br>
                <table>
                    <tr>
                        <th>Expected</th>
                        <th>Run</th>
                        <th>Pts Possible</th>
                        <th>Pts Deducted</th>
                        <th>Pts Total</th>
                    </tr>
                    <tbody>
                        <tr>
                            <td><?= format_tc($ans["expected"]) ?> </td>
                            <td><?= format_tc($ans["run"]) ?></td>
                            <td><?= $ans["pts_possible"] ?></td>
                            <td><?=$ans["pts_override"] ?></th>
                            <td><?=$ans["pts_total"] ?></th>
                        </tr>
                    </tbody>
                </table>
                <br>
                <textarea disabled ><?= $ans["comment"] ?></textarea>
                <?php
                    $total_possible+=intval($ans["pts_possible"]);
                    $total_obtained+=intval($ans["pts_total"]);
                ?>
                <br><br>

            <?php endforeach; ?>
            Total Grade:
            <?=$total_obtained?>/<?=$total_possible?>

        </form>
    

</body>
</html>
>>>>>>> 627cf4eec17a545c1d3786526bc9912696f8e610
