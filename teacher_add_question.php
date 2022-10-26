<?php
// Start the session
session_start();
$user = $_SESSION["user"];

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
    'teacher_id'=> $user["user_id"]];
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
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
    }
    
?>

<html>
    <div class="topnav">
        <a href="teacher_add_question.php">Add Question</a>
        <a href="teacher_create_exam.php">Make Exam</a>
        <a href="teacher_grade_exam.php">Grade Exams</a>
        <a href="teacher_release_exam.php">Release Exams</a>
        <a href="logout.php">Logout</a>
    </div>

    <head>
        <title> CREATE QUESTION </title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>

    <body>
        <h2 class="Header">Create Question </h2><br>
        <h2 class="Header"> </h2>
    </body>
    
    <form method="post">  
        <label for="category" id="HeaderQuestions"><b>Category&nbsp&nbsp</b></label>
            <select name="category" id="category">Select
                <option value="variables">Variables</option>
                <option value="conditionals">Conditionals</option>
                <option value="for loops">For Loops</option>
                <option value="while loops">While Loops</option>
                <option value="lists">Lists</option>
            </select></br></br>
         
        <label for="difficulty" id="HeaderQuestions"><b>Difficulty&nbsp&nbsp</b></label>
            <select name="difficulty" id="difficulty">Select
                <option value="0">Easy</option>
                <option value="1">Medium</option>
                <option value="2">Hard</option>
            </select>  </br></br>
          
        <label for="fname" id="HeaderQuestions"><b>Function Name&nbsp&nbsp</b></label>
            <input type="text" name="fname"/></br></br>
          
        <label for="description" id="HeaderQuestions"><b>Description&nbsp&nbsp</b></label>
            <input type="text" name="description"/></br></br>
            
        <label for="test_cases" id="HeaderQuestions"><b>Test Cases&nbsp&nbsp</b></label></br></br>
            <input type="text" placeholder="Arguments" name="test_in[]"/>
            <input type="text" placeholder="Expected Output" name="test_out[]"/><br/></br>
	        <input type="text" placeholder="Arguments" name="test_in[]"/>
            <input type="text" placeholder="Expected Output" name="test_out[]"/><br/></br>
        
        <br/>
        <input type="submit" value="Create Question" name="CreateQuestionButton"/>
                    
     </form>
    
</html>