<?php
// Start the session
session_start();


//check if button is set
if (isset($_POST["LoginButton"])) 
    {
    $params=['user_id'=>$_POST["user_id"], 'password'=>$_POST['password']];
    $defaults = array(
        CURLOPT_URL => 'https://afsaccess4.njit.edu/~jc262/CS490/mid.php',
        CURLOPT_POST => true,
        CURLOPT_POSTFIELDS => $params,
        CURLOPT_RETURNTRANSFER => true
        );
    $ch = curl_init();
    curl_setopt_array($ch, $defaults);

    //results from middle
    $result = json_decode(curl_exec($ch), true);
    $status = curl_getinfo($ch, CURLINFO_HTTP_CODE);
	curl_close($ch);
    
    //check the status, 200=good
    if($status == 200) 
        {
        $_SESSION['user'] = $result;
        header("Location: index.php");
        exit();
        }
    else
        {
        $_SESSION['bad'] = true;
        header("Location: login.php");   
        exit();
        }
}

else
    header("Location: login.php");
?>