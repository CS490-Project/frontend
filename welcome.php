<?php
session_start();
//if session is not set then redirect to login
if (!isset($_SESSION["user"])) 
    {
     header("Location: login.php");
    }

$user = $_SESSION["user"];
unset ($_SESSION["user"]);

?>

<html>
    <head>
        <title> WELCOME PAGE </title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>

    <body>
        <h2 class="Header">Welcome <?php echo $user["role"]; ?> </h2><br>
        <h2 class="Header"> <?php echo $user["ucid"]; ?> </h2>
    </body>
</html>