<!DOCTYPE html>
<html>
    <head>
        <title> LOGIN PAGE </title>
        <link rel="stylesheet" type="text/css" href="styles.css">
    </head>

    <body>
        <div id="LoginPage">
            <h2 class="Header">Login Page</h2><br>    
            <form action="index.php" method="post">  
                    <label for="UCID" id="Header2"><b>UCID</b></label>
                    <input type="text" placeholder="Enter UCID" name="UCID" id="Header3" required>
                    <label for="Password" id="Header2"><b>Password</b></label>
                    <input type="password" placeholder="Enter Password" name="Password" id="Header3" required><br>
                    <br><input type="submit" value="Login" name="LoginButton" id="Button"></br>
            </form>
        </div>
    </body>
</html>
