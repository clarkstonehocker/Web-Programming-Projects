<?php
    
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    //variable for tracking whether or not to display form results
    $error = true;
    
    //variables for storing form input field values
    $username = $passWord = $nameFirst = $nameLast = $email = $phoneNumber = "";
    
    //variables for * error markings
    $unError = $passError = $fnError = $lnError = $emError = $phError = "";
    
    //variables for error messages a top the form
    $usernameError = $passwordError = $firstNameError = $lastNameError = $emailError = $phoneError = "";
    
    //remove any "extra" or unintended characters
    function removeExtras($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
    
    //when form is submitted, verify fields
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //set the error variable to false when the submit button is pressed 
        if(isset($_POST["confirm"]))
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
        else
        {
            //if not empty, verify and display errors if they exist
            $username = removeExtras($_POST["username"]);
            if(!preg_match("/^[a-zA-Z]+$/", $username))
            {
                $usernameError = "Invalid Username: username must consist of one or more of only the characters a-z and A-Z.";
                $unError ="*";
                $error = true;
            }
        }
        
        //validate password field
        if(empty($_POST["passWord"]))
        {   
            $passwordError = "The password field is required.";
            $passError = "*";
            $error = true;
        }
        else
        {
            //if not empty, verify and display errors if they exist
            $passWord = removeExtras($_POST["passWord"]);
            if(!preg_match("/^(?=.*\d).{8,}/", $passWord))
            {
                $passwordError = "Invalid Password: passwords must be at least 8 characters and contain at least 1 digit.";
                $passError ="*";
                $error = true;
            }
        }
        
        //validate first name field
        if(empty($_POST["nameFirst"]))
        {   
            $firstNameError = "The first name field is required.";
            $fnError = "*";
            $error = true;
        }
        else
        {
            //if not empty, verify and display errors if they exist
            $nameFirst = removeExtras($_POST["nameFirst"]);
            if(!preg_match("/^[a-zA-Z]+$/", $nameFirst))
            {
                $firstNameError = "Invalid First Name: first name must be one or more alphabetic characters.";
                $fnError ="*";
                $error = true;
            }
        }
        
        //validate last name field
        if(empty($_POST["nameLast"]))
        {   
            $lastNameError = "The last name field is required.";
            $lnError = "*";
            $error = true;
        }
        else
        {
            //if not emtpy, verify and display errors if they exist
            $nameLast = removeExtras($_POST["nameLast"]);
            if(!preg_match("/^[a-zA-Z]+$/", $nameLast))
            {
                $lastNameError = "Invalid Last Name: last name must be one or more alphabetic characters.";
                $lnError ="*";
                $error = true;
            }
        }
        
        //validate email field
        if(empty($_POST["email"]))
        {   
            $emailError = "The email field is required.";
            $emError = "*";
            $error = true;
        }
        else
        {
            //if not empty, verify and display errors if they exist
            $email = removeExtras($_POST["email"]);
            if(!preg_match("/([\w\-]+\@[\w\-]+\.[\w\-]+)/", $email))
            {
                $emailError = "Invalid email: email address must be of the form sampleName@email.com";
                $emError ="*";
                $error = true;
            }
        }
        
        //validate phone number field
        if(empty($_POST["phoneNumber"]))
        {   
            $phoneError = "The phone number field is required.";
            $phError = "*";
            $error = true;
        }
        else
        {
            //if not empty, verify and display errors if they exist
            $phoneNumber = removeExtras($_POST["phoneNumber"]);
            if(!preg_match("/^\d{3}-\d{3}-\d{4}$/", $phoneNumber))
            {
                $phoneError = "Invalid Phone Number: only phone numbers in the format XXX-XXX-XXXX are allowed.";
                $phError ="*";
                $error = true;
            }
        }
    }    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
<head>
    <title>Project 5-1</title>
    <style type="text/css">
        #actions
        {
            text-align:center;
        }
        .block
        {
            display: block;
        }
        body
        {
            font-family: Helvetica, Arial, sans-serif;
            background-color: #EEE;
            margin: 0;
        }
        #cancel
        {
            font-size: 12pt;
            background-color: #CCC;
            border: 1px ridge #000;
            border-radius: 5px;
            padding: 5px 10px 5px 10px;
            margin: 20px;
            color: #000;
        }
        #cancel:hover
        {
            background-color: #EEE;
        }
        .error
        {
            color: #FF0000;
        }
        form
        {
            width: 320px;
            margin:auto;
            text-align: left;
            margin-top: 15px;
            padding-bottom: 10px;
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
        input:focus
        {
            box-shadow: 1px 1px 1px 2px #003366;
        }
        label
        {
            display: inline-block;
            width: 108px;
        }
        #main
        {
            width: 750px;
            margin:auto;
            text-align: center;
            background-color: #FFF;
            padding-top: 1px;
            border: 1px solid #000;
            border-radius: 3px;
        }
        #messages
        {
            text-align: left;
            padding: 0 10px 0 10px;
        }
        #results
        {
            text-align: left;
        }
        #submit
        {
            font-size: 12pt;
            background-color: #223366;
            border: 1px ridge #000;
            border-radius:5px;
            padding: 5px 10px 5px 10px;
            margin: 20px;
            color: #FFF;
        }
        #submit:hover
        {
            background-color: #05afba;
        }
        
    </style>
</head>
<body>
    <div id="main">
        <h1> PHP Registration Form</h1>
        <div id="messages">
            <p>All fields are required. <br/>Username, first name, and last name must be only uppercase and lowercase characters. <br/>
            Password must be at least 8 characters long and contain at least one digit. <br/> Email must be of the form address@sample.com <br/>
            Phone number must be a US phone number (ddd-ddd-dddd).</p>
            <br/>
            <span class="error block" ><?php echo $usernameError; ?></span>
            <span class="error block" ><?php echo $passwordError; ?></span>
            <span class="error block" ><?php echo $firstNameError; ?></span>
            <span class="error block" ><?php echo $lastNameError; ?></span>
            <span class="error block" ><?php echo $emailError; ?></span>
            <span class="error block" ><?php echo $phoneError; ?></span>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <label for="userName">User Name:</label>
            <input type="text" id="userName" name="username" placeholder="A-Z and a-z only" value="<?php echo $username; ?>"/>
            <span class="error" id="uName"><?php echo $unError; ?></span>
            <br/>
            <label for="password">Password:</label>
            <input type="password" id="password" name="passWord" placeholder=">= 8 chars. and >= 1 digit" value="<?php echo $passWord; ?>"/>
            <span class="error" id="pass"><?php echo $passError; ?></span>
            <br/>
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="nameFirst" placeholder="Your given name" value="<?php echo $nameFirst; ?>"/>
            <span class="error" id="fname"><?php echo $fnError; ?></span>
            <br/>
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="nameLast" placeholder="Your family or sir name" value="<?php echo $nameLast; ?>"/>
            <span class="error" id="lname"><?php echo $lnError; ?></span>
            <br/>
            <label for="emailAddress">Email Address:</label>
            <input type="text" id="emailAddress" name="email" placeholder="name@provider.com" value="<?php echo $email; ?>" />
            <span class="error" id="Email"><?php echo $emError; ?></span>
            <br/>
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phoneNumber" placeholder="000-000-0000" value="<?php echo $phoneNumber; ?>" />
            <span class="error" id="phoneNum"><?php echo $phError; ?></span>
            <br/>
            <div id="actions">
                <input id="submit" type="submit" value="Submit" name="confirm"/>
            </div>
            <div id="results">
                <?php
                    if(!$error)
                    {
                        echo "<h3>Form results:</h3>";
                        echo "User name:  $username <br/>";
                        echo "Password:   $passWord <br/>";
                        echo "First name: $nameFirst <br/>";
                        echo "Last name:  $nameLast <br/>";
                        echo "Email:      $email <br/>";
                        echo "Phone #:    $phoneNumber <br/><br/>";
                    }
                ?>
                <?php echo "Programmed by Clark Stonehocker"; ?>
            </div>
        </form>
    </div>
</body>
</html>
