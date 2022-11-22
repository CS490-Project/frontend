<?php
//check if button is set
require_once(__DIR__ . "/utils/helpers.php");

if(is_logged_in()){
 die(header("Location: index.php"));
}

if (isset($_POST["login"])) {
    $params=['user_id'=>$_POST["user_id"], 'password'=>$_POST['password']];
    //check the status, 200=good
    $req = make_request("mid", $params);
 
    if($req["status"] == 200) {
        $_SESSION['user'] = $req["response"];
        die(header("Location: index.php"));
    }
    else {
        flash("Bad Credentials");
        
    }
}
?>


<?php require(__DIR__ . "/partials/header.php"); ?>

<section id="LoginPage">

    <h2 class="header">Login</h2><br>    

    <form method="POST" class="login-form">  
         
            <input type="text" placeholder="Enter UCID" name="user_id" class="form-input" required>
           
            <input type="password" placeholder="Enter Password" name="password" class="form-input" required><br>

            <br><input type="submit" value="Login" name="login" class="btn"></br>
    </form>
</section>


<?php require(__DIR__ . "/partials/footer.php"); ?>

