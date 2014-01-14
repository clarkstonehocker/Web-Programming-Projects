<?php
    $connection = mysqli_connect('localhost', 'cs174_23', 'CGnjWYd8', 'cs174_23');
    if($connection->connect_errno)
    {
        print("Error connecting: " + $mysqli->connect_error);
    }
?>