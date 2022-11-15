<?php require(__DIR__ . "/../partials/header.php"); ?>

<?php

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
    'teacher_id'=> get_user_id()];
    
     $req = make_request("mid_create_question", $params);

     if($req["status"] == 200){
        flash("Question successfuly created");
     } else {
        flash("Failed to create question");
     }
    }
    
?>


<section>

    <h2 class="Header">Create Question </h2><br>
   
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
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
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
</section>
    
<?php require(__DIR__ . "/../partials/footer.php"); ?>