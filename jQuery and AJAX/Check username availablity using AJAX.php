<!DOCTYPE>
<html>
    <head>
        <title>Project 7-1</title>
        
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
            #usernameError
            {
                font-weight: bold;
            }
        </style>
        <script type="text/javascript" src="//ajax.googleapis.com/ajax/libs/jquery/1.10.2/jquery.min.js"></script>
    </head>
    <body>
        <div id="main">
            <h2>User registration form</h2>
            
                <span id="usernameError"></span>
                <br/>
                <label for="uName">Username:</label><input id="uName" type="text" name="username" />
                <br/>
                <label for="pWord">Password:</label><input id="pWord" type="password" name="password" />
                <br/>
                <input type="submit" id="submission" value="Register" name="register"/>
            
        </div>
    </body>
    <script type="text/javascript">
        $("#uName").blur(function(){
            var requestedUsername = $(this).val();
            $.ajax({
                url: "check_username.php",
                type: "POST",
                data: {proposedUsername:requestedUsername},
                success: function(response) {
                    $("#usernameError").text(response);
                    if(response == "Username is available!")
                    {
                        $("#usernameError").css("color", "#008000");
                    }
                    else
                    {
                        $("#usernameError").css("color", "#DC143C");
                    }
                },
                error: function(response){
                    $("#usernameError").text(response);
                    $("#usernameError").css("color", "#DC143C");
                }
            });
        });
        
        $("#submission").click(function(){
           var submitUsername = $("#uName").val();
           var submitPassword = $("#pWord").val();
           $.ajax({
                url: "validate_registration.php",
                type: "POST",
                data: {submittedUsername:submitUsername, submittedPassword:submitPassword},
                success: function(response) {
                    $("#usernameError").text(response);
                    if(response == "User successfully registered!")
                    {
                        $("#usernameError").css("color", "#008000");
                    }
                    else
                    {
                        $("#usernameError").css("color", "#DC143C");
                    }
                
                },
                error: function(response){
                    $("#usernameError").text(response);
                    $("#usernameError").css("color", "#DC143C");
                }
           });
           $
        });
        
        
    </script>
</html>

