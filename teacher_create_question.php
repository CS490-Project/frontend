<?php
// Start the session
session_start();


//check if button is set
if (isset($_POST["CreateQuestionButton"])) 
    {
    $test_ins = $_POST["test_in"];
    $test_outs = $_POST["test_out"];

    $params=['category'=>$_POST["category"], 
    'difficulty'=>$_POST["difficulty"], 
    'fname'=>$_POST["fname"], 
    'description'=>$_POST["description"], 
    'test_cases'=>[["test_in"=>$test_ins[0], "test_out" => $test_outs[0]], ["test_in"=>$test_ins[1], "test_out" => $test_outs[1]]],
    'teacher_id'=>'tt001'];
    $defaults = array(
        CURLOPT_URL => 'https://afsaccess4.njit.edu/~jc262/CS490/mid_create_question.php',
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => json_encode($params),
        CURLOPT_HTTPHEADER => array('Content-Type:application/json'),
        CURLOPT_RETURNTRANSFER => true
        );
    $ch = curl_init();
    curl_setopt_array($ch, $defaults);

    //results from middle
    $result = json_decode(curl_exec($ch), true);

    echo $result;
    
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
    }

    //refresh
    
?>