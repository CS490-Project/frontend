<?php require(__DIR__ . "/../partials/header.php"); ?>
<?php

    $exam_id = $_POST['exam_id'];

    $params = ["student_id" => get_user_id(), 'graded' => '1'];

    $req = make_request("mid_get_all_exams", $params);

    $exams = [];

    if($req["status"] == 200){
        $exams = $req["response"];
    }
    
?>

<section>
    <div class="exam-container">
      <h1>Graded Exams</h1><br>
      
        <table class="exam-table" style="width: 50%;">
                <thead>
                    <tr>
                        <th>Exam Name</th>
                        <th>Check Grade</th>
                    </tr>
                </thead>

                <tbody>
                    <?php foreach($exams as $exam): ?>
                        <tr class="exam" id=<?="exam-".$exam['id']; ?> >
                            <td> <b><?= $exam['title']; ?><b> </td> 
                            <td> <a class="btn" href="student_check_grade.php?id=<?=$exam['id'];?>"> Check Grade </a></td>
                        </tr>
                        
                    <?php endforeach; ?>
            </tbody>
        </table>
   
    </div>
</section>


