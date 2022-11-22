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

        <form method="post" id="question_form">  
          <h1>Create Question </h1><br>
          <div class="input-group">
            <select class="form-input" name="category" id="category">
                <option value="" disabled selected>Category</option>
                <option value="variables">Variables</option>
                <option value="conditionals">Conditionals</option>
                <option value="for loops">For Loops</option>
                <option value="while loops">While Loops</option>
                <option value="lists">Lists</option>
            </select>
                  
            <select class="form-input" name="difficulty" id="difficulty">
              <option value="" disabled selected>Difficulty</option>
                <option value="easy">Easy</option>
                <option value="medium">Medium</option>
                <option value="hard">Hard</option>
            </select>
          </div>
                
          
          <input type="text" name="fname" class="form-input" placeholder="Function Name" />
                
   
          <textarea name="description" class="form-input" rows="5" placeholder="Description"></textarea>

          <label>
            <input type="checkbox" onclick="toggle_constraints(this);"/> <b>Constraints</b> 
          </label>
        
          <select name="constraints" class="form-input" id="constraints" disabled>
              <option value="" disabled selected>None</option>
              <option value="for">For Loop</option>
              <option value="while">While Loop</option>
              <option value="recursion">Recursion</option>
          
          </select>
              
             
            
          <div style="display: flex; justify-content: space-between;">
            <p><b>Test Cases</b><p>
            <button id="add_test_case" type="button" class="btn btn-small">Add Test Case</button><br>
          </div>
            

            <div id="test_cases">
                
                <div class="input-group">
                  <input class="form-input" type="text" placeholder="Arguments" name="test_in[]"/>
                  <input class="form-input" type="text" placeholder="Expected Output" name="test_out[]"/>
                </div>
                <div class="input-group">
                  <input class="form-input" type="text" placeholder="Arguments" name="test_in[]"/>
                  <input class="form-input" type="text" placeholder="Expected Output" name="test_out[]"/>
                </div>
            </div>
            <br/>

            
            <input type="submit" class="btn btn-block" value="Create Question" name="CreateQuestionButton"/>
                    
        </form>


    <div id="question_container">
      <h1>Question Bank</h1><br>
      <div class="input-group">
        <input type="text" value="" class="filter form-input" onkeyup="render_table()" id="f_description" placeholder="Keyword"/>
        
        <select id="f_category" class="filter form-input" onchange="render_table()">
          <option value="">All Topics</option>
          <option value="variables">Variables</option>
          <option value="conditionals">Conditionals</option>
          <option value="for loops">For Loops</option>
          <option value="while loops">While Loops</option>
          <option value="lists">lists</option>
        </select>

        <select id="f_difficulty" class="filter form-input" onchange="render_table()">
          <option value="">All Difficulties</option>
          <option value="easy">Easy</option>
          <option value="medium">Medium</option>
          <option value="hard">Hard</option>
        
        </select>
        
      </div>
      <table border="2" class="question-table">
          <thead>
            <tr>
              <th>Description</th>
              <th>Category</th>
              <th>Difficulty</th>
            </tr>
          </thead>
          <tbody class="question-table-body"></tbody>
      </table>
    </div>
</section>

<script>

  let tc_count = 2;
  const questions = <?=json_encode($questions) ?>

  const question_table_body = document.querySelector('.question-table-body');
  const btn_test_case_add = document.getElementById('add_test_case');

  render_table()

  function toggle_constraints(cb){
    const constraints_select = document.getElementById("constraints")
    constraints_select.disabled = !cb.checked
  }

  function add_test_case(e){
      if(tc_count < 5){
        const test_case = `<div class="input-group">
                  <input class="form-input" type="text" placeholder="Arguments" name="test_in[]"/>
                  <input class="form-input" type="text" placeholder="Expected Output" name="test_out[]"/>
                </div>
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

    question_table_body.innerHTML = output
  }

  btn_test_case_add.addEventListener("click", add_test_case)
</script>


    
<?php require(__DIR__ . "/../partials/footer.php"); ?>
