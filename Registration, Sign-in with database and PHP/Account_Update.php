<?php header('Content-type: text/html; charset=utf-8'); ?>

<?php
    session_start();
    
    require_once("helper_functions.php");
    require_once("db_connection.php");
    
    //variables for * error markings
    $unError = $passError = $fnError = $lnError = $emError = $phError = "";
    
    //variables for error messages a top the form
    $usernameError = $passwordError = $firstNameError = $lastNameError = $emailError = $phoneError = "";
    
    $feedback = "";
    
    $un = $_SESSION["username"];
    $un = removeExtras($un);
    $query  = "CALL findUsername('".$un."');";
    $result = mysqli_query($connection, $query);
    if(isset($result))
    {
        $row = $result->fetch_assoc();
    }
    //when form is submitted, verify fields
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        //set the error variable to false when the submit button is pressed 
        if(isset($_POST["confirm"]))
        {
            $error=false;
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
            else
            {
                $hashedPassword = password_encrypt($passWord);
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
            $phone_error = false;
            $phoneNumber = " ";
        }
        else
        {
            //if not empty, verify and display errors if they exist
            $phoneNumber = removeExtras($_POST["phoneNumber"]);
            if(!preg_match("/^\d{3}-\d{3}-\d{4}$/", $phoneNumber))
            {
                $phoneError = "Invalid Phone Number: only phone numbers in the format XXX-XXX-XXXX are allowed.";
                $phError ="*";
                $phone_error = true;
            }
            else
            {
                $phone_error = false;
            }
        }
        
        $bio = removeExtras($_POST["personal_bio"]);
        $bio = filter_var($bio, FILTER_SANITIZE_STRING);
        
        if(!$error && !$phone_error)
        {
            $mysqli = new mysqli('localhost', 'cs174_23', 'CGnjWYd8', 'cs174_23');
            $stmt = $mysqli->prepare("UPDATE UserAccounts SET password = ?, firstName = ?, lastName = ?, email = ?, phone = ?, bio = ? WHERE userName = ?");
            $stmt->bind_param("sssssss", $hashedPassword, $nameFirst, $nameLast, $email, $phoneNumber, $bio, $un);
            $stmt->execute();
            if($stmt->errno)//($queryResult)
            {
                $feedback = "Failed to add user to database.";
            }
            else
            {
                $feedback = "User information updated successfully.";
                
            }
            $mysqli->close();
        }
    }    
    
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
<head>
    <?php header('Content-type: text/html; charset=utf-8'); ?>
    <title>Project 9 -- Update Account</title>
    <style type="text/css">
        #actions
        {
            text-align:center;
        }
        #bio
        {
            width: 250px;
            height: 100px;
        }
        #bio_label
        {
            margin: 8px 0 5px 0;
        }
        .block
        {
            display: block;
        }
        body
        {
            font-family: Helvetica, Arial, sans-serif;
            font-size: 10pt;
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
        label
        {
            display: inline-block;
            width: 80px;
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
            font-size: 11pt;
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
    <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    <script type="text/javascript">
        function SubmitForm()
        {
            var firstError = true;
            if(ValidatePassword())
            {
                $("#pass, #passwordError").hide();
            }
            else if(!ValidatePassword())
            {
                if(firstError)
                {
                    $("#password").focus();
                    firstError = false;
                }
                $("#pass").css("display", "inline");
                $("#passwordError").css("display", "block");
            }
            if(ValidateFirstName())
            {
                $("#fname, #fName").hide();
            }
            else if(!ValidateFirstName())
            {
                if(firstError)
                {
                    $("#firstName").focus();
                    firstError = false;
                }
                $("fname").css("display", "inline");
                $("#fName").css("display", "block");
            }
            if(ValidateLastName())
            {
                $("#lname, #lName").hide();
            }
            else if(!ValidateLastName())
            {
                if(firstError)
                {
                    $("#lastName").focus();
                    firstError = false;
                }
                $("#lname").css("display", "inline");
                $("#lName").css("display", "block");
            }
            if(ValidatePhone())
            {
                $("#phoneNum, #phoneError").hide();
            }
            else if(!ValidatePhone())
            {
                if(firstError)
                {
                    $("#phone").focus();
                }
                $("#phoneNum").css("display", "inline");
                $("#phoneError").css("display", "block");
            }
            
            if(ValidateEmail())
            {
                $("#Email, #emailError").hide();
            }
            else if(!ValidateEmail())
            {
                if(firstError)
                {
                    $("#emailAddress").focus();
                    firstError = false;
                }
                $("#Email").css("display", "inline");
                $("#emailError").css("display", "block");
                
            }
            
        }
        
        function ValidatePassword()
        {
            var pass = $("#password").val();
            var passwordRegEx = /^(?=.*\d).{8,}/;
            return passwordRegEx.test(pass);
        }
        function ValidateFirstName()
        {
            var firstName = $("#firstName").val();
            var firstNameRegEx = /^[a-zA-Z]+$/;
            return firstNameRegEx.test(firstName);
        }
        function ValidateLastName()
        {
            var lastName = $("#lastName").val();
            var lastNameRegEx = /^[a-zA-Z]+$/;
            return lastNameRegEx.test(lastName);
        }
        function ValidatePhone()
        {
            var phoneNumber = $("#phone").val();
            if(phoneNumber.length == 0)
                return true;
            else
            {
                var phoneRegEx = /^\d{3}-\d{3}-\d{4}$/;
                return phoneRegEx.test(phoneNumber);
            }
            
        }
        
        function ValidateEmail()
        {
            var email = $("#emailAddress").val();
            var emailRegEx = /([\w\-]+\@[\w\-]+\.[\w\-]+)/;
            return emailRegEx.test(email);
        }
    </script>
</head>
<body>
    <div id="main">
        <h2>User Account Update Form</h2>
        <div id="messages">
            <p>All fields except phone and personal bio are required.
            <br/>First name and last name must be only uppercase and lowercase characters.
            <br/>Password must be at least 8 characters long and contain at least one digit.
            <br/>Email must be of the form address@sample.com
            <br/>If entered, phone number must be a US phone number (ddd-ddd-dddd).</p>
            <br/>
            <span class="error hidden" id="userNameError">Invalid Username: username must consist of one or more of only the characters a-z and A-Z.</span>
            <span class="error hidden" id="passwordError">Invalid Password: passwords must be at least 8 characters and contain at least 1 digit.</span>
            <span class="error hidden" id="fName">Invalid First Name: first name must be one or more alphabetic characters.</span>
            <span class="error hidden" id="lName">Invalid Last Name: last name must be one or more alphabetic characters.</span>
            <span class="error hidden" id="phoneError">Invalid Phone Number: only phone numbers in the format XXX-XXX-XXXX are allowed.</span>
            <span class="error block" ><?php echo $usernameError; ?></span>
            <span class="error block" ><?php echo $passwordError; ?></span>
            <span class="error block" ><?php echo $firstNameError; ?></span>
            <span class="error block" ><?php echo $lastNameError; ?></span>
            <span class="error block" ><?php echo $emailError; ?></span>
            <span class="error block" ><?php echo $phoneError; ?></span>
            <span class="error block"><?php echo $feedback; ?></span>
        </div>
        <form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <label for="password">Password:</label>
            <input type="password" id="password" name="passWord" autocomplete="off" placeholder=">= 8 chars. and >= 1 digit" value=""/>
            <span class="error" id="pass"><?php echo $passError; ?></span>
            <br/>
            <label for="firstName">First Name:</label>
            <input type="text" id="firstName" name="nameFirst" placeholder="Your given name" value="<?php echo $row["firstName"]; ?>"/>
            <span class="error" id="fname"><?php echo $fnError; ?></span>
            <br/>
            <label for="lastName">Last Name:</label>
            <input type="text" id="lastName" name="nameLast" placeholder="Your family or sir name" value="<?php echo $row["lastName"]; ?>"/>
            <span class="error" id="lname"><?php echo $lnError; ?></span>
            <br/>
            <label for="emailAddress">Email Address:</label>
            <input type="text" id="emailAddress" name="email" placeholder="name@provider.com" value="<?php echo $row["email"]; ?>" />
            <span class="error" id="Email"><?php echo $emError; ?></span>
            <br/>
            <label for="phone">Phone Number:</label>
            <input type="text" id="phone" name="phoneNumber" placeholder="000-000-0000" value="<?php echo $row["phone"]; ?>" />
            <span class="error" id="phoneNum"><?php echo $phError; ?></span>
            <br/>
            <label for="bio" id="bio_label">Personal Bio:</label>
            <br/>
            <textarea type="text" id="bio" name="personal_bio"><?php echo $row["bio"]; ?></textarea>
            <div id="actions">
                <input id="submit" type="submit" value="Update" name="confirm" onclick="if(SubmitForm()) this.form.submit()"/>
            </div>
        </form>
    </div>
    
    <script type="text/javascript">
        $("#userName").blur(function(){
            if(ValidateUserName())
            {
                $("#uName, #userNameError").hide();
            }
            else
            {
                $("#userName").focus();
                $("#uName").css("display", "inline");
                $("#userNameError").css("display", "block");
            }
        });
        
        $("#password").blur(function(){
            if(ValidatePassword())
            {
                $("#pass, #passwordError").hide();
            }
            else
            {
                $("#password").focus();
                $("#pass").css("display", "inline");
                $("#passwordError").css("display", "block");
            }
        });
        
        $("#firstName").blur(function(){
           if(ValidateFirstName())
            {
                $("#fname, #fName").hide();
            }
            else
            {
                $("#firstName").focus();
                $("fname").css("display", "inline");
                $("#fName").css("display", "block");
            } 
        });    
        
        $("#lastName").blur(function(){
            if(ValidateLastName())
            {
                $("#lname, #lName").hide();
            }
            else
            {
                $("#lastName").focus();
                $("#lname").css("display", "inline");
                $("#lName").css("display", "block");
            } 
        }); 
        
        $("#phone").blur(function(){
            if(ValidatePhone())
            {
                $("#phoneNum, #phoneError").hide();
            }
            else
            {
                $("#phone").focus();
                $("#phoneNum").css("display", "inline");
                $("#phoneError").css("display", "block");
            }
        });
        
        $("#emailAddress").blur(function(){
           if(ValidateEmail())
           {
                $("#email, #emailError").hide();
           }
           else
           {
                $("#emailAddress").focus();
                $("#Email").css("display", "inline");
                $("#emailError").css("display", "block");
           }
        });
            
    </script>
</body>
</html>
