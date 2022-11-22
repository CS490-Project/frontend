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
          <h1>Exams To Be Taken</h1><br>
          <table style="width:50%">
              <thead>
                  <tr>
                      <th>Exam Name</th>
                      <th>Take Exam</th>
                  </tr>
              </thead>
              <tbody>
              <?php foreach($exams as $exam): ?>
                <tr class="exam" id=<?="exam-".$exam['id']; ?> >
                    <td>  <b><?= $exam['title']; ?></b> </td> 
                    <td> <a class="btn" href="student_take_exam.php?id=<?=$exam['id'];?>"> Take </a></td>
                </tr>
                
              <?php endforeach; ?>
              </tbody>
              
          </table>
        </div>
</main>

<?php require(__DIR__ . "/../partials/footer.php"); ?>



