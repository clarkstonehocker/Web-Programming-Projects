<?php
    $mysqli = new mysqli('localhost', 'cs174_23', 'CGnjWYd8', 'cs174_23');
    
    if($mysqli->connect_errno)
    {
        print("Error connecting" + $mysqli->connect_error);
    }
    $userName;
    $passWord;
    $querySuccess;
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $userName = $_POST["submittedUsername"];
        $passWord = $_POST["submittedPassword"];
            
        $querySuccess = $mysqli->query("INSERT INTO Users(Username, Password) VALUES('$userName', '$passWord')");
        
        if($querySuccess)
        {   
            print "User successfully registered!";
            
        }
        else
        {
            print "Error with registration.";
        }
    }
    
    $mysqli->close();
?>