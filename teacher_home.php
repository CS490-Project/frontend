<?php
session_start();
$user = $_SESSION["user"];
?>

<html>
    <div class="topnav">
        <a href="teacher_add_question.php">Add Question</a>
        <a href="teacher_create_exam.php">Make Exam</a>
        <a href="teacher_grade_exam.php">Grade Exams</a>
        <!--<a href="teacher_release_exam.php">Release Exams</a>-->
        <a href="logout.php">Logout</a>
    </div>

    <head>
        <title> TEACHER HOME </title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>

    <body>
        <h2 class="Header">Welcome <?php echo $user["role"]; ?> </h2><br>
        <h2 class="Header"> <?php echo $user["user_id"]; ?> </h2>
    </body>
</html>