<?php 
  session_start();
  $user = $_SESSION["user"];
  $data = [];
  $questions = [];
  
  if(isset($_POST["create_exam"])){
 
     $data['title'] = $_POST['title'];
     $data['total'] = $_POST['total'];
     $data['teacher_id'] = $user["user_id"];
     $data['questions'] = [];
     $question_id=$_POST['question_id'];
     $value = $_POST['value'];
     
     $sum = 0;
     for($i=0;$i<count($question_id);$i++)
     {
        $sum+=intval($value[$i]);
        $question = ["q_id" => $question_id[$i], "val" => $value[$i]];
        array_push($data['questions'], $question);
     }
     
     if($sum != intval($_POST['total'])){
       echo "Questions don't add up to exam total!";
      
     } else {
     
       $options = array(
          CURLOPT_URL => 'https://afsaccess4.njit.edu/~jc262/CS490/mid_create_exam.php',
          CURLOPT_POST => true, 
          CURLOPT_POSTFIELDS => json_encode($data),
          CURLOPT_HTTPHEADER, array('Content-Type:application/json'),
          CURLOPT_RETURNTRANSFER => true
       );
      
      $ch = curl_init();  //initialize curl session
      curl_setopt_array($ch, $options); 
      
      
      //decode json from db.php
      $response = curl_exec($ch);
    }
     
 } 
    $data = ["teacher_id" => $user["user_id"]];
    $options = array(
        CURLOPT_URL => 'https://afsaccess4.njit.edu/~jc262/CS490/mid_receive_questions.php',
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
  
    $questions = NULL;
    
    if($status == 200){
      $questions = json_decode($response, true);
    }
 

?>

<html>
    <div class="topnav">
    <title> CREATE HOME </title>
    <link rel="stylesheet" type="text/css" href="styles.css">
        <a href="teacher_add_question.php">Add Question</a>
        <a href="teacher_create_exam.php">Make Exam</a>
        <a href="teacher_grade_exam.php">Grade Exams</a>
        <a href="teacher_release_exam.php">Release Exams</a>
        <a href="logout.php">Logout</a>
    </div>

    <head>
        <style>
            main{
              padding: 2rem;
              display: flex;
            }
            
            main div{
              margin: 1rem 2rem;
            }
            
            .question-table .question{
              margin: 1rem 0;
            }
        </style>
      </head>

    <body>
        <main>
            <div class="exam-form">
                <form method="post">
                    <input type="text" name="title" placeholder="Exam Title">
                    <input type="number" name="total" placeholder="Total Points">
                    <table id="exam_questions">
                    </table>
                    <br/>
                    <input type="submit" name="create_exam" value="Create Exam">
                </form>
            </div>
          
          <div class="question-container">
              <h1>Question Bank</h1>
              <table class="question-table">
  
                  <?php foreach($questions as $question): ?>
                  
                    <tr class="question" id=<?="question-".$question['id']; ?> >
                        <td> <?= $question['description']; ?> </td>
                        <td> 
                          <button onClick="add_question(<?=$question['id']?>,'<?=$question['description']?>')" > 
                              Add Question 
                          </button> 
                        <td>
                    </tr>
                    
                  <?php endforeach; ?>
                  
              </table>
            </div>
    </main>
      
    <script type="text/javascript">
          const exam_questions = document.getElementById('exam_questions');
          
          function add_question(id, description){
              const exam_question = `<tr>
                    <td>${description}</td>
                    <td><input type="number" name="value[]" min="0" placeholder="Enter Value"></td>
                    <td><button > X </button> </td>
                    <td><input type="hidden" name="question_id[]" value=${id}></td>
                </tr>`
                
                exam_questions.innerHTML += exam_question
                
                const question = document.getElementById(`question-${id}`)
                question.children[1].children[0].disabled = true;
          } 
        </script>
    </body>
</html>