<?php
session_start();
//if session is not set then redirect to login
if (!isset($_SESSION["user"])) 
    {
     header("Location: login.php");
    }

$user = $_SESSION["user"];
//unset ($_SESSION["user"]);


//redirect home page based on role
if($user["role"] == 'student')
    {
        header("Location: student_home.php");
    }
else if($user["role"] == 'teacher') 
    {
        header("Location: teacher_home.php");
    }
else
    {
        header("Location: login.php");
    }
?>
