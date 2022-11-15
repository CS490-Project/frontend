<?php require(__DIR__ . "/../partials/header.php"); ?>
<?php
  
    $exams = [];
    
    $params = ["teacher_id" => get_user_id()];
    $req = make_request("mid_get_ungraded_exam", $params);

    if($req["status"] == 200){
      $exams = $req["response"];
    }

?>

<section>
  <div class="ungraded_exam-container">
    <h1>Exams To Be Graded</h1>
    <table class="ungraded-exam-table">
        <?php foreach($exams as $exam): ?>
          <tr class="exam" id=<?="exam-".$exam['id']; ?> >
              <td>  <?=$exam["student_id"];?> <?= $exam['title']; ?> </td> 
              <td> 
              <a href="teacher_autograde_exam.php?student_id=<?=$exam['student_id'];?>&exam_id=<?=$exam['exam_id'];?>"> Grade Exam </a>
              <td>
          </tr>
        <?php endforeach; ?>
        
    </table>
  </div>
</section>