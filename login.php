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

<div id="LoginPage">
    <h2 class="Header">Login Page</h2><br>    

    <form method="POST">  
            <label for="user_id" id="Header2"><b>UCID</b></label>
            <input type="text" placeholder="Enter UCID" name="user_id" id="Header3" required>
            <label for="password" id="Header2"><b>Password</b></label>
            <input type="password" placeholder="Enter Password" name="password" id="Header3" required><br>
            <br><input type="submit" value="Login" name="login" id="Button"></br>
    </form>
</div>


<?php require(__DIR__ . "/partials/footer.php"); ?>

