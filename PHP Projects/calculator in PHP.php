<?php
    
    //variables for storing input field values
    $result = $firstNumber = $secondNumber = $op = $answer ="";
    
    //remove any undesired characters from input
    function removeExtras($input)
    {
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        return $input;
    }
    
    //perform calculations after grabbing input field values
    if($_SERVER["REQUEST_METHOD"] == "POST")
    {
        $firstNumber = $_POST["first"];
        $firstNumber = removeExtras($firstNumber);
        $secondNumber = $_POST["second"];
        $secondNumber = removeExtras($secondNumber);
        $op = $_POST["operator"];
        $answer = calculate($firstNumber, $op, $secondNumber);
        
    }
    
    //perform calculations based on operator
    function calculate($arg1, $operator, $arg2)
    {
        switch($operator)
        {   case "+":
               $result = $arg1 + $arg2;
               return $result;
            case "-":
                $result = $arg1 - $arg2;
                return $result;
            case "*":
                $result = $arg1 * $arg2;
                return $result;
            case "/":
                if($arg2 == 0)
                    $result = "Division by 0 is not allowed.  Enter a different value for number 2.";
                else
                    $result = $arg1 / $arg2;
                return $result;
            default:
                $result = "Invalid input or other error.  Please try again.";
                return $result;
        }
    }
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html lang="en">
<head>
    <style>
        input
        {
            display: block;
            margin: 5px 0 20px 0;
        }
        body
        {
            background-color: #AAA;
        }
        #main
        {
            width: 500px;
            background-color: #FFF;
            margin: auto;
            text-align: center;
            padding: 1px 0 10px 0;
        }
        #content
        {
            width: 150px;
            margin: auto;
            text-align: left;
        }
        #secondLabel
        {
            display: block;
            margin-top: 20px;
        }
        #calculate
        {
            margin-left: 40px;
        }
    </style>
</head>
<body>
    <div id="main">
        <h1>PHP Calculator</h1>
        <form id="content" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>" method="POST">
            <label for="firstOperand">Number 1:</label><input type="text" id="firstOperand" name="first" />
            <label for="operators">Operator:</label>
                <select id="operators" name="operator">
                    <option>+</option>
                    <option>-</option>
                    <option>*</option>
                    <option>/</option>
                </select>
            <label id = "secondLabel" for="secondOperand">Number 2:</label><input type="text" id="secondOperand" name="second"/>
            <input id="calculate" type="submit" value="Calculate" name="calculatedValue"/>
        </form>
    <div id="answer">
        <?php
            print("The result is: $answer<br/><br/>");
        ?>
        <?php echo "Programmed by Clark Stonehocker"; ?>
    </div>
    </div>
    
</body>
</html>