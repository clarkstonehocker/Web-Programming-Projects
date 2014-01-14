<?php
    //only run program if variable is set
    if(isset($_GET["pw"]))
    {    $password = $_GET["pw"]; //get password value from GET array
        
        //open file, read contents, and transfer passwords to array
        $file = fopen("most_common_passwords.txt", "r");
        $listOfPasswords = array();
        while(!feof($file))
        {
          $listOfPasswords[] = trim(fgets($file));
        }
        fclose($file);
        
        //formulate output array, first checking if password is in the file (if it's in the array) and second checking password strength
        $output = array();
        $output = searchArray($password, $listOfPasswords);
        $output[] = getPasswordStrength($password);
        
        //return json encoded array    
        echo json_encode($output);
    }
    
    //see if the password is found in the array.  return an array of two elements: true/false for the first and -1/fileLine for the second.
    //the first element indicates whether or not the password is found in the array.
    //the second element indicates the most popular ranking (via line of file it is) of the password or -1 if it is not found.
    function searchArray($item, $array)
    {
        $tempArray = array();
        $row = array_search($item, $array);
        if($row === false)
        {
            $row = -1;
            $tempArray[0] = false;
            $tempArray[1] = $row;
        }
        else
        {
            $tempArray[0] = true;
            $tempArray[1] = $row + 1;
        }
        return $tempArray;
    }
    
    //get the password strength in a scale of 0 - 5.  The strength will be 5 if all 5 tests pass.  Basically the password earns one point for each test passed.
    function getPasswordStrength($value)
    {
        $strength = 0;
        if(strlen($value) >= 8)
            $strength++;
        if(preg_match("/[A-Z]/", $value))
           $strength++;
        if(preg_match("/[a-z]/", $value))
           $strength++;
        if(preg_match("/[0-9]/", $value))
           $strength++;
        if(!preg_match("#^[a-zA-Z0-9]+$#", $value))
           $strength++;
           
        return $strength;
    }
    
?>