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


<section id="create-exam">
    <div class="exam-form">
        <form method="post">
            <input type="text" name="title" placeholder="Exam Title" required>
            <input type="number" name="total" placeholder="Total Points" min="0" step="0.01">
            <table id="exam_questions"></table>
            <br/>
            <input type="submit" name="create_exam" value="Create Exam">
        </form>
    </div>
          
  <div class="question-container">
      <h1>Question Bank</h1>
      <table class="question-table" border="1">
          <thead>
            <tr>
              <th>Description</th>
              <th>Category</th>
              <th>Difficulty</th>
              <th>Add</th>
            </tr>
          </thead>
          <tbody>
            <?php foreach($questions as $question): ?>
              <tr class="question" id=<?="question-".$question['id']; ?> >
                  <td> <?= $question['description']; ?> </td>
                  <td> <?= $question['category']; ?> </td>
                  <td> <?= $question['difficulty']; ?> </td>
                  <td> 
                    <button onClick="add_question(<?=$question['id']?>,'<?=$question['description']?>')" > 
                        Add Question 
                    </button> 
                  <td>
              </tr>
            <?php endforeach; ?>
          </tbody>
      </table>
    </div>
      
</section>

<script type="text/javascript">

  const exam_questions = document.getElementById('exam_questions');
  
  function add_question(id, description){
      const exam_question = `<tr>
            <td>${description}</td>
            <td><input type="number" name="value[]" placeholder="Enter Value" min="0" step="0.01"></td>
            <td><button > X </button> </td>
            <td><input type="hidden" name="question_id[]" value=${id}></td>
        </tr>`
        
        exam_questions.innerHTML += exam_question
        
        const question = document.getElementById(`question-${id}`)
        question.children[3].children[0].disabled = true;
  } 

</script>
 
<?php require(__DIR__ . "/../partials/footer.php"); ?>