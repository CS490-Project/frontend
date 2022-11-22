<?php require(__DIR__ . "/../partials/header.php"); ?>

<?php 

  $questions = [];
  $req = make_request("mid_receive_questions", ["teacher_id" => get_user_id()]);
  
  if($req["status"] == 200){
    $questions = $req["response"];
  }

  
  if(isset($_POST["create_exam"])){
     
    $params = [
      "title" => $_POST['title'],
      "total" => $_POST['total'],
      "teacher_id" => get_user_id(),
      "questions" => []
    ];
  
     $question_id=$_POST['question_id'];
     $value = $_POST['value'];
     
     $sum = 0;

     for($i=0;$i<count($question_id);$i++)
     {
        $sum+=intval($value[$i]);
        $question = ["q_id" => $question_id[$i], "val" => $value[$i]];
        array_push($params['questions'], $question);
     }
     
     if($sum != intval($_POST['total'])){
       flash("Questions don't add up to exam total!");
     } else {
       $req = make_request("mid_create_exam", $params);
       if($req['status'] == 200){
        flash("Exam successfuly created!");
       }
    }
     
 } 
 
?>


<section id="create_exam">

  <form method="post" id="exam_form">
      <div class="input-group">
        <input type="text" class="form-input" name="title" placeholder="Exam Title" required>
        <input type="number" class="form-input" name="total" placeholder="Total Points" min="0" step="0.01">
      </div>
      <table class="question-table" border="1">
        <thead>
          <tr>
            <th>Description</th>
            <th>Category</th>
            <th>Difficulty</th>
            <th>Value</th>
            <th>Remove</th>
          </tr>
        </thead>
        <tbody id="exam_questions_body"></tbody>
      </table>
      <br/>
      <input type="submit" class="btn btn-block" name="create_exam" value="Create Exam">
  </form>
    
  <div class="question-container">
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
      <table border="1" class="question-table">
          <thead>
            <tr>
              <th>Description</th>
              <th>Category</th>
              <th>Difficulty</th>
              <th>Add</th>
            </tr>
          </thead>
          <tbody id="question_table_body"></tbody>
      </table>
    </div>
      
</section>

<script type="text/javascript">

  const exam_questions = document.getElementById('exam_questions_body');
  const question_table_body = document.getElementById('question_table_body');
  const questions = <?=json_encode($questions) ?>

  var selected_questions = []

  render_table()
  
  function render_table(){
    const f_description = document.getElementById("f_description")
    const f_category = document.getElementById("f_category")
    const f_difficulty = document.getElementById("f_difficulty")

    const filteredQuestions = questions.filter(q => {
      return q["category"].includes(f_category.value) && 
             q["difficulty"].includes(f_difficulty.value) &&
             q["description"].includes(f_description.value);
    })

    let output = ""

    filteredQuestions.forEach(q => {

     
      const html = `<tr class="selected-question" id='question-${q['id']}'>
                  <td> ${q['description']} </td>
                  <td> ${q['category']} </td>
                  <td> ${q['difficulty']} </td>
                  <td> 
                    <button class="btn btn-small"
                    onClick="add_question(${q['id']}, '${q['description']}', '${q['category']}', '${q['difficulty']}')">
                     Add </button> 
                  </td>
              </tr>`

      output+=html

    })

    question_table_body.innerHTML = output
  }
  
  function add_question(id, description, category, difficulty){

      selected_questions.push({id, description, category, difficulty})

      const question = document.getElementById(`question-${id}`)
      question.children[3].children[0].disabled = true;

      render_selected_questions()
  } 

  function remove_question(id){
    selected_questions = selected_questions.filter(q => {
      return q['id']  != id
    })

    const question = document.getElementById(`question-${id}`)
    question.children[3].children[0].disabled = false;

    render_selected_questions()
  }

  
  function render_selected_questions(){
    let output = ""

    selected_questions.forEach(q => {
      const html = `<tr>
        <td>${q["description"]}</td>
        <td>${q["category"]}</td>
        <td>${q["difficulty"]}</td>
        <td><input type="number" class="form-input" name="value[]" placeholder="Enter Value" min="0" step="0.01"></td>
        <td><button class="btn btn-small" onclick="remove_question(${q['id']})" type="button"> Remove </button> </td>
        <input type="hidden" name="question_id[]" value="${q['id']}">
      </tr>`

      output+=html

    })
    
    exam_questions.innerHTML = output
      
  }

  
</script>
 
<?php require(__DIR__ . "/../partials/footer.php"); ?>