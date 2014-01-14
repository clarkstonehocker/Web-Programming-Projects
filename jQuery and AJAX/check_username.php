<?php
    $mysqli = new mysqli('localhost', 'cs174_23', 'CGnjWYd8', 'cs174_23');
    
    if($mysqli->connect_errno)
    {
        print("Error connecting: " + $mysqli->connect_error);
    }
    $userName;
    $passWord;
    $error;
    $querySuccess;
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $userName = $_POST["proposedUsername"];
        $query = $mysqli->query("SELECT * FROM Users WHERE Username = '$userName'");
        if(mysqli_num_rows($query) == 0)
        {   $error = "Username is available!";
            print("$error");
        }
        else
        {
            $error = "Username is already taken!";
            print("$error");
        }
    }
        
    $mysqli->close();
?>