<?php
    $city = "";
    $output = "";
    if($_SERVER["REQUEST_METHOD"]== "POST")
    {
        $city = $_POST["city"];
    }
    
    $response = file_get_contents("http://api.openweathermap.org/data/2.5/weather?q=$city");
    $output = json_decode($response);
     
    //print_r ($output);
    
?>
<!DOCTYPE>
<html>
    <head>
        <title>Weather API Example</title>
        <script type="text/javascript" src="jquery-1.9.1.js"></script>
    </head>
    <body>
        <form action="<?php htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <label for="city">Enter city:</label><input id="city" type="text" name="city"/>
            <input id="search" type="submit" value="Get weather info" />
        </form>
        <pre>
            <?php
            print "Weather conditions for "."$city"."<br/>";
            echo "Sky conditions: ";
            print_r($output->weather[0]->description);
            echo "<br/>";
            echo "Temperature: ";
            print_r( $output->main->temp );
            echo "<br/>";
            echo "Humidity: ";
            print_r($output->main->humidity);
            echo "<br/>"?>
        </pre>
    </body>
    
</html>