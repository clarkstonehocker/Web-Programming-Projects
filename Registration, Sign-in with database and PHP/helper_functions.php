<?php

    require_once('recaptchalib.php');
    
    function redirect_to($new_location)
    {
        header("Location: " . $new_location);
        exit;
    }
    
    //remove any "extra" or unintended characters
    function removeExtras($input)
    {
        global $connection;
        $input = trim($input);
        $input = stripslashes($input);
        $input = htmlspecialchars($input);
        $input = mysqli_real_escape_string($connection, $input);
        return $input;
    }
    
    function password_encrypt($password)
    {
        return crypt($password);
    }

    function validate_captcha()
    {
        $privatekey = "Your private key";
        $resp = recaptcha_check_answer ($privatekey,
                                $_SERVER["REMOTE_ADDR"],
                                $_POST["recaptcha_challenge_field"],
                                $_POST["recaptcha_response_field"]);

        if (!$resp->is_valid)
        {
            return true;
        }
        else
        {
            return false;
        }
    }
    
    function confirm_query($result_set)
    {
	if (!$result_set)
        {
            print("Database query failed.");
	}
    }
    
    function find_username($username)
    {
	global $connection;
	$safe_username = mysqli_real_escape_string($connection, $username);
        $query  = "CALL findUsername('".$safe_username."');";
	$user_set = mysqli_query($connection, $query);
	confirm_query($user_set);
	if($user = mysqli_fetch_assoc($user_set))
        {   
	    return $user;
	}
        else
        {
	    return null;
	}
    }
    function attempt_login($user, $pass)
    {
        $username = find_username($user);
	if ($username)
        {
            // found username, now check password
            if (password_check($pass, $username["password"]))
            {
                // password matches
                return $username;
	    }
            else
            {
		// password does not match
		return false;
            }
        }
        else
        {
            // admin not found
            return false;
	}
    }

    function password_check($password, $existing_hash)
    {
	// existing hash contains format and salt at start
	$hash = crypt($password, $existing_hash);
        return $hash === $existing_hash;
    }
?>