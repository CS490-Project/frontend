<?php require(__DIR__ . "/../partials/header.php"); ?>
<?php

$questions = [];
$req = make_request("mid_receive_questions", ["teacher_id" => get_user_id()]);

if($req["status"] == 200){
$questions = $req["response"];
}

//check if button is set
if (isset($_POST["CreateQuestionButton"])) 
    {

    $params=[
        'category'=>$_POST["category"], 
        'difficulty'=>$_POST["difficulty"], 
        'constraints'=>$_POST["constraints"], 
        'fname'=>$_POST["fname"], 
        'description'=>$_POST["description"], 
        'teacher_id'=> get_user_id(),
        'test_cases'=>[]
    ];

    $test_ins = $_POST["test_in"];
    $test_outs = $_POST["test_out"];

    for($i = 0; $i < count($test_ins); $i++){
        $tc = ["test_in"=>$test_ins[$i], "test_out" => $test_outs[$i]];

        array_push($params['test_cases'], $tc);
   
    }
    
    $req = make_request("mid_create_question", $params);

    if($req["status"] == 200){
        print_r($req["response"]);
        flash("Question successfuly created");
    } else {
        flash("Failed to create question");
    }
}
    
?>


<section id="add_question_form">
    <div class="question-form">
        <h1 class="Header">Create Question </h1>
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
                <textarea name="description"></textarea></br></br>

            <label for="constraints" id="HeaderQuestions"><b>Constraints&nbsp&nbsp</b></label>
                <select name="constraints" id="constraints">Select
                    <option value="">None</option>
                    <option value="for">For Loop</option>
                    <option value="while">While Loop</option>
                    <option value="recursion">Recursion</option>
                
                </select></br></br>
            <label for="test_cases" id="HeaderQuestions"><b>Test Cases&nbsp&nbsp</b>
                <button id="add_test_case" type="button">Add Test Case</button>
            </label></br></br>
            <div id="test_cases">
                
                <input type="text" placeholder="Arguments" name="test_in[]"/>
                <input type="text" placeholder="Expected Output" name="test_out[]"/><br/></br>
                <input type="text" placeholder="Arguments" name="test_in[]"/>
                <input type="text" placeholder="Expected Output" name="test_out[]"/><br/></br>
            </div>
            <br/>

            
            <input type="submit" value="Create Question" name="CreateQuestionButton"/>
                    
        </form>
    </div>

    <div class="question-container">
      <h1>Question Bank</h1>
      <div>
        <input type="text" value="" class="filter" onkeyup="render_table()" id="f_description" placeholder="Keyword"/>
        
        <select id="f_category" class="filter" onchange="render_table()">
          <option value="">All Topics</option>
          <option value="variables">Variables</option>
          <option value="conditionals">Conditionals</option>
          <option value="for loops">For Loops</option>
          <option value="while loops">While Loops</option>
          <option value="lists">lists</option>
        </select>

        <select id="f_difficulty" class="filter" onchange="render_table()">
          <option value="">All Difficulties</option>
          <option value="easy">Easy</option>
          <option value="medium">Medium</option>
          <option value="hard">Hard</option>
        
        </select>
        
      </div>
      <table border="1">
          <thead>
            <tr>
              <th>Description</th>
              <th>Category</th>
              <th>Difficulty</th>
            </tr>
          </thead>
          <tbody id="question_table_body"></tbody>
      </table>
    </div>
</section>

<script>

  let tc_count = 2;

  const exam_questions = document.getElementById('exam_questions_body');
  const question_table = document.getElementById('question_table_body');
  const questions = <?=json_encode($questions) ?>

  const btn_test_case_add = document.getElementById('add_test_case');

  render_table()

  function add_test_case(e){
      if(tc_count < 5){
        const test_case = `
            <input type="text" placeholder="Arguments" name="test_in[]"/>
            <input type="text" placeholder="Expected Output" name="test_out[]"/><br/></br>
        `
        
        document.getElementById('test_cases').innerHTML += test_case
        tc_count += 1
      } 

      if(tc_count == 5){
        btn_test_case_add.disabled = true;
      }
      

  } 
  
  function render_table(){
    const f_description = document.getElementById("f_description")
    const f_category = document.getElementById("f_category")
    const f_difficulty = document.getElementById("f_difficulty")

    const filteredQuestions = questions.filter(q => {
      return q["category"].includes(f_category.value) && 
             q["difficulty"].includes(f_difficulty.value) &&
             q["description"].includes(f_description.value);
    })

    console.log(filteredQuestions)

    let output = ""

    filteredQuestions.forEach(q => {

      const html = `<tr class="selected-question" id='question-${q['id']}'>
                    <td> ${q['description']} </td>
                    <td> ${q['category']} </td>
                    <td> ${q['difficulty']} </td>
                    </tr>`

      output+=html

    })

    question_table.innerHTML = output
  }

  btn_test_case_add.addEventListener("click", add_test_case)
</script>


    
<?php require(__DIR__ . "/../partials/footer.php"); ?>
