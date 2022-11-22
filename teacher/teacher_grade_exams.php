<?php require(__DIR__ . "/../partials/header.php"); ?>
<?php
  
    $exams = [];
    
    $params = ["teacher_id" => get_user_id()];
    $req = make_request("mid_get_ungraded_exam", $params);

    if($req["status"] == 200){
      $exams = $req["response"];
    }

?>

<section id="ungraded_exams">
  <h1>Exams To Be Graded</h1><br>

  <table style="width: 50%;">
        <thead>
            <tr>
                <th>Exam</th>
                <th>Student</th>
                <th>Grade</th>
            </tr>
        </thead>
        <tbody>
        <?php foreach($exams as $exam): ?>
          <tr class="exam" id=<?="exam-".$exam['id']; ?> >
              <td><b><?= $exam['title']; ?></b></td>
              <td><b><?=$exam["student_id"];?></b></td> 
              <td> 
              <a href="teacher_autograde_exam.php?student_id=<?=$exam['student_id'];?>&exam_id=<?=$exam['exam_id'];?>"
                class="btn"> Grade Exam </a>
              </td>
          </tr>
        <?php endforeach; ?>
      </tbody>
      
  </table>
  
</section>