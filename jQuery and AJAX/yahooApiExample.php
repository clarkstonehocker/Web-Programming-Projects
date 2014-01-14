<?php
    $output = "";
    if($_SERVER["REQUEST_METHOD"]== "POST")
    {
        $city = $_POST["city"];
    }
    
    $response = file_get_contents("http://query.yahooapis.com/v1/public/yql");
    $output = json_decode($response);
    
    //'select * from answers.search where query=\"".$_POST['search']
    print_r($output);
?>
<!DOCTYPE>
<html>
<head>
        <title>Weather API Example</title>
        
    </head>
    <body>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <label for="city">Enter question:</label><input id="city" type="text" name="city"/>
            <input id="search" type="submit" value="Search" />
        </form>
        
</html>