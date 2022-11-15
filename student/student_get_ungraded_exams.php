<?php require(__DIR__ . "/../partials/header.php"); ?>

<?php
  
    $params = ["student_id" => get_user_id(), 'graded' => '0'];

    $req = make_request("mid_get_all_exams", $params);

    $exams = [];

    if($req["status"] == 200){
      $exams = $req["response"];
    }
//}
?>

<main>
    <div class="exam-container">
          <h1>Exams To Be Taken</h1>
          <table class="exam-table">
              <?php foreach($exams as $exam): ?>
                <tr class="exam" id=<?="exam-".$exam['id']; ?> >
                    <td>  <?= $exam['title']; ?> </td> 
                    <td> 
                    <a href="student_take_exam.php?id=<?=$exam['id'];?>"> Take Exam </a>
                    <td>
                </tr>
                
              <?php endforeach; ?>
              
          </table>
        </div>
</main>

<?php require(__DIR__ . "/../partials/footer.php"); ?>



