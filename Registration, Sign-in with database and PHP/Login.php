<?php header('Content-type: text/html; charset=utf-8'); ?>

<?php
    session_start();
    require_once("db_connection.php");
    require_once("helper_functions.php");
    
    //variables for storing form input field values
    $username = $passWord = "";

    //variables for * error markings
    $unError = $passError = "";
    
    //variables for error messages a top the form
    $usernameError = $passwordError = "";
    
    $error = true;
    
    $loginFeedback = "";
    
    //when form is submitted, verify fields
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //set the error variable to false when the submit button is pressed 
        if(isset($_POST["login"]))
        {
            $error=false;
        }
        //validate username field
        if(empty($_POST["username"]))
        {   
            $usernameError = "The username field is required.";
            $unError = "*";
            $error = true;
        }
        
        //validate password field
        if(empty($_POST["passWord"]))
        {   
            $passwordError = "The password field is required.";
            $passError = "*";
            $error = true;
        }
        
        if(!$error)
        {
            $username = removeExtras($_POST["username"]);
            $passWord = removeExtras($_POST["passWord"]);
            $user_set = attempt_login($username, $passWord);
            $connection->close();
            if($user_set)
            {
                $_SESSION["username"] = $username;
                redirect_to("p9_Account_Update.php");
            }
            else
            {
                $loginFeedback = "Username or password did not match.  Login failed.";
            }
        }
    }   
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
    
    <head>
        <title>Project 9 -- Login</title>
        <style type="text/css">
            #main
            {
                width: 400px;
                background-color: #FFF;
                border: 1px solid #000;
                border-radius: 8px;
                margin: auto;
                text-align: center;
            }
            #submission
            {
                padding: 5px;
                background-color: #008000;
                border: 1px solid #000;
                border-radius: 3px;
                margin: 10px;
            }
            #uName, #pWord
            {
                margin: 5px;
            }
            .error
            {
                color: #FF0000;
            }
            .hidden
            {
                display: none;
            }
            input
            {
                outline: none;
                border-radius: 5px;
                margin: 10px;
                padding: 3px;
                border: 1px solid #000;
                border-style: outset;
            }
            input:focus, textarea:focus
            {
                box-shadow: 1px 1px 1px 2px #003366;
            }
        </style>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
        <script type="text/javascript">
        function SubmitForm()
        {
            if(ValidateUserName())
            {
                $("#name, #userNameError").hide();
            }
            else
            {
                $("#uName").focus();
                $("#name").css("display", "inline");
                $("#userNameError").css("display", "block");
            }
            if(ValidatePassword())
            {
                $("#pass, #passwordError").hide();
            }
            else if(!ValidatePassword())
            {
                $("#pWord").focus();
                $("#pass").css("display", "inline");
                $("#passwordError").css("display", "block");
            }
        }
        function ValidateUserName()
        {
            var userName = $("#uName").val();
            var userNameRegEx=/^[a-zA-Z]+$/;
            return userNameRegEx.exec(userName);
        }
        function ValidatePassword()
        {
            var pass = $("#pWord").val();
            var passwordRegEx = /^(?=.*\d).{8,}/;
            return passwordRegEx.exec(pass);
        }
        
    </script>
    </head>
    <body>
        <div id="main">
            <h2>User log in page</h2>
            <div id="messages">
                <span id="notRegistered">Not registered? <a href="p9_Sign_Up.php">Click here.</a></span>
                <span class="error hidden" id="userNameError">Invalid Username: username must consist of one or more of only the characters a-z and A-Z.</span>
                <br/>
                <span class="error hidden" id="passwordError">Invalid Password: passwords must be at least 8 characters and contain at least 1 digit.</span>
            
                <span class="error block" ><?php echo $usernameError; ?></span>
                <br/>
                <span class="error block" ><?php echo $passwordError; ?></span>
                <br/>
                <span class="error block"><?php echo $loginFeedback; ?></span>
            </div>
            <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
                <label for="uName">Username:</label><input id="uName" type="text" name="username" value="<?php echo $username; ?>"/><span class="error" id="name"><?php echo $unError; ?></span>
                <br/>
                <label for="pWord">Password:</label><input id="pWord" type="password" name="passWord" autocomplete="off" value="<?php echo $passWord; ?>" /><span class="error" id="pass"><?php echo $passError; ?></span>
                <br/>
                <input type="submit" id="submission" value="Log In" name="login" onclick="if(SubmitForm()) this.form.submit()"/>
            </form>
        </div>
    </body>
    <script type="text/javascript">
      
        $("#uName").blur(function(){
            if(ValidateUserName())
            {
                $("#name, #userNameError").hide();
            }
            else
            {
                $("#uName").focus();
                $("#name").css("display", "inline");
                $("#userNameError").css("display", "block");
            }
        });
        
        $("#pWord").blur(function(){
            if(ValidatePassword())
            {
                $("#pass, #passwordError").hide();
            }
            else
            {
                $("#pWord").focus();
                $("#pass").css("display", "inline");
                $("#passwordError").css("display", "block");
            }
        });
    </script>
</html>