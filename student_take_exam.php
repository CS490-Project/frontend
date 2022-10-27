<?php 
    session_start();
    $user = $_SESSION["user"];

    $exam = NULL;

    $questions=[]; 

        $data = ["exam_id" => $_GET['id']];

        $options = array(
            CURLOPT_URL => 'https://afsaccess4.njit.edu/~jc262/CS490/mid_request_exam.php',
            CURLOPT_POST => true, 
            CURLOPT_POSTFIELDS => json_encode($data),
            CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
            CURLOPT_RETURNTRANSFER => true
        );

        $ch = curl_init();  //initialize curl session
        curl_setopt_array($ch, $options); 

        //decode json from db.php
        $response = curl_exec($ch);
        $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        
        if($status == 200){
            $exam = json_decode($response, true);
        }

        $questions=$exam["questions"];
    ?>

    <html>
    <h1> <? echo "Exam"?> <?= $exam['id']; ?> </h1>
    <body>
        <form action=student_save_exam.php method="post">
            <?php foreach($questions as $question): ?>
                <p><?=$question['description']?> <br> <?=$question['value']?> pts </p> 
                <textarea id="answer" name="answer[]" rows="4" cols="50"></textarea><br><br>
                <input type="hidden" name="question_id[]" value='<?=$question["question_id"]?>'>
            <?php endforeach; ?>
            <input type="hidden" name="exam_id" value='<?= $_GET['id']?>'>
            <input type="submit" value="Submit Exam" name="SaveExam"></br>
        </form>
    </body>
    </html>