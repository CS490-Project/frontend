<?php
session_start();
$user = $_SESSION["user"];
?>

<html>
<div class="topnav">
        <a href="front_get_all_exams.php">Take Exam</a>
        <a href="">Graded Exams</a>
        <a href="logout.php">Logout</a>
    </div>    

    <head>
        <title> STUDENT HOME </title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>

    <body>
        <h2 class="Header">Welcome <?php echo $user["role"]; ?> </h2><br>
        <h2 class="Header"> <?php echo $user["user_id"]; ?> </h2>
    </body>
</html>