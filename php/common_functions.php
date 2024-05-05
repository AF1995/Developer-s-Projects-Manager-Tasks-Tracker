<?php
    // Checks if a given character is numeric and returns true if so, false otherwise.
    function isNumeric($char)
    {
        $ascii = ord($char);
        return ($ascii >= 48 && $ascii <= 57);
    }
    
    // Checks if a given character is alpha-numeric and returns true if so, false otherwise.
    function isAlphaNumeric($char)
    {
        $ascii = ord($char);
        return (($ascii >= 48 && $ascii <= 57) || ($ascii >= 65 && $ascii <= 90) || ($ascii >= 97 && $ascii <= 122));
    }

    // Checks if a given character is alphabetic and returns true if so, false otherwise.
    function isAlphabetic($char)
    {
        $ascii = ord($char);
        return (($ascii >= 65 && $ascii <= 90) || ($ascii >= 97 && $ascii <= 122));
    }

    // Checks if a given string is alphabetic or a space, then returns true if so, false otherwise.
    function isAlphaNumericOrSpace($str)
    {
        foreach(str_split($str) as $char)
            if(!isAlphaNumeric($char) && ord($char) != 32)
                return false;
        return true;
    }

    // Checks if a given string is alpha-numeric or a space, then returns true if so, false otherwise.
    function isAlphabeticOrSpace($str)
    {
        foreach(str_split($str) as $char) // Excluding start and end
        {
            $ascii = ord($char);
            if(!(($ascii >= 65 && $ascii <= 90) || ($ascii >= 97 && $ascii <= 122) || $ascii == 32))
                return false;
        }
        return true;
    }

    // Checks if a given string contains only characters allowed in an email, then returns true if so, false otherwise.
    // characters are: alphanumric, dots and '@'.
    function isEmailCharactersOnly($str)
    {
        foreach(str_split($str) as $char) // Excluding start and end
        {
            $ascii = ord($char);
            if(!(($ascii >= 48 && $ascii <= 57) || ($ascii >= 65 && $ascii <= 90) || ($ascii >= 97 && $ascii <= 122)) && $ascii != 64 && $ascii != 46)
                return false;
        }
        return true;
    }

    // Checks if a given string contains only characters allowed in a date, then returns true if so, false otherwise.
    // characters are: numbers, dashes, spaces and forward slashes.
    function isDateCharactersOnly($str)
    {
        foreach(str_split($str) as $char) // Excluding start and end
        {
            $ascii = ord($char);
            if(!($ascii >= 48 && $ascii <= 57) && $ascii != 32  && $ascii != 45 && $ascii != 47)
                return false;
        }
        return true;
    }

    // Checks if a given string contains only characters allowed in a time, then returns true if so, false otherwise.
    // characters are: numbers and colons.
    function isTimeCharactersOnly($str)
    {
        foreach(str_split($str) as $char) // Excluding start and end
        {
            $ascii = ord($char);
            if(!($ascii >= 48 && $ascii <= 57) && $ascii != 58)
                return false;
        }
        return true;
    }

    // Checks if a given string contains only characters allowed in a phone number, then returns true if so, false otherwise.
    // characters are: numbers, spaces, dashes, forward slashes, plus sign and parenthesis.
    function isPhoneCharactersOnly($str)
    {
        foreach(str_split($str) as $char) // Excluding start and end
        {
            $ascii = ord($char);
            if(!($ascii >= 48 && $ascii <= 57) && $ascii != 32 && $ascii != 47 && $ascii != 45 && $ascii != 40 && $ascii != 41 && $ascii != 43)
                return false;
        }
        return true;
    }

    // Takes a string and checks if it is a valid email format wise. Returns true if valid, false otherwise.
    function validateEmail($str)
    {
        /*
         * Email must contain exactly one @. Which separates username from domain name.
         * Also, the seconds part should include a dot(.) that seperates subdomain from domain.
         * Moreover, There must not be 2 successive dots without characters between them.
         * Last, Other than dots and '@', an email may contain alpha-numeric characters only.
         * Example of a valid domain format: username@sub.domain
         */

        $user_domain = explode("@", $str);
        
        // Email must contain 2 parts. Which are: username part and domain name part. 
        if(sizeof($user_domain) != 2)
            return false;

        /* Username part of the email: */
        $user = $user_domain[0];

        // username part must not be empty:
        if(empty($user))
            return false;

        // First and last characters of the username part must only be alpha-numberic:
        $start = substr($user, 0, 1);
        $end = substr($user, strlen($user) - 1, 1);

        if(!isAlphaNumeric($start) || !isAlphaNumeric($end))
            return false;
        
        #region Must contain alpha-numeric or dots only:
        $isDot = false;
        foreach(str_split(substr($user, 1, strlen($user) - 2)) as $char) // Excluding start and end
        {
            $ascii = ord($char);
            if(!isAlphaNumeric($char) && $ascii != 46)
                return false;
            
            #region no 2 successive dots:
            if($ascii == 46)
            {
                if($isDot)
                    return false;
                $isDot = true;
            }
            else $isDot = false;
            #endregion
        }
        #endregion

        /* Domain name part of the email: */
        $domains = $user_domain[1];
        $domains = explode(".", $domains);

        // There must be at least 1 sub domain and 1 domain. eg: @sub.com
        if(sizeof($domains) < 2)
            return false;

        #region domains must be separated by a dot(.) and must only contains alpha-numberical characters:
        foreach($domains as $domain)
        {
            // No empty domains (in other words, no more than 1 dot successively without other chacaters between them). eg: @..com <-- invalid case.
            if(empty($domain))
                return false;
            
            // A domain must contain alpha-numerical characters only. 
            foreach(str_split($domain) as $char)
                if(!isAlphaNumeric($char))
                    return false;
        }
        #endregion
        return true;
    }

    // Takes a string and returns a new one after removing all the extra whitespaces from the given one.
    // Extra whitespaces are: Spaces at the start, end, and more than one space in between successively.
    function removeExtraWhitespaces($str)
    {
        $res = trim($str);
        while(strpos($str, "  "))
            $str = str_replace("  ", " ", $str);
        return $res;
    }

    // Checks if a given string is alphabetic that may contain spaces in the middle Must be at least 3 characters. Return true if so, false otherwise.
    function validateName($str)
    {
        // Must be at least 3 characters.
        if(strlen($str) < 3)
            return false;

        // First and last characters of the name part must only be alphabetic:
        $start = substr($str, 0, 1);
        $end = substr($str, strlen($str) - 1, 1);

        if(!isAlphabetic($start) || !isAlphabetic($end))
            return false;
        
        // Rest of the name may also contain spaces.
        foreach(str_split(substr($str, 1, strlen($str) - 2)) as $char) // Excluding start and end
        {
            $ascii = ord($char);
            if(!isAlphabeticOrSpace($char) && $ascii != 46)
                return false;
        }
        return true;
    }

    // For now, we will assume Lebanese numbers only... might add support for other countries at a later state.
    // A phone must contain 8 numbers.
    function validatePhone($str)
    {
        // if(strlen($str) != 8)
        //     return false;
        foreach(str_split($str) as $char)
            if(!isNumeric($char))
                return false;
        return true;
    }

    // Secure user input.
    function cleanInput($str)
    {
        $str = Escapeshellcmd($str);
        $str = htmlspecialchars($str, ENT_QUOTES);
        return $str;
    }

    // Takes a number of seconds and gets how many days, minutes and seconds are in it with an optional value defining the number hours for a day.
    function seperateDateTime($seconds, $hoursPerDay = 24){
        $minutes = $seconds / 60;
        $seconds %= 60;
        $hours = $minutes / 60;
        $minutes %= 60;
        $days = (int)($hours / $hoursPerDay);
        $hours %= $hoursPerDay;
        return array("days" => $days, "hours" => $hours, "minutes" => $minutes, "seconds" => $seconds);
    }

    // Takes 2 arrays returned by seperateDateTime function and adds their time together with an optional value defining the number hours for a day.
    function addTwoSeperatedDateTime($arr1, $arr2, $hoursPerDay = 24){
        $seconds = $arr1['seconds'] + $arr2['seconds'];
        $minutes = $arr1['minutes'] + $arr2['minutes'] + ($seconds / 60);
        $seconds %= 60;
        $hours = $arr1['hours'] + $arr2['hours'] + ($minutes / 60);
        $minutes %= 60;
        $days = $arr1['days'] + $arr2['days'] + (int)($hours / $hoursPerDay);
        $hours %= $hoursPerDay;
        return array("days" => $days, "hours" => $hours, "minutes" => $minutes, "seconds" => $seconds);
    }

    // Generates a password of a given length if given. If length wasn't given it generates a random length between 8 and 50.
    function generatePassowrd($length = 0){
        if ($length <= 0)
            $length = rand(8, 50);

        $characters = array(
            array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9'),
            array('a', 'b', 'c', 'd', 'e', 'f', 'g', 'h', 'i', 'j', 'k', 'l', 'm', 'n', 'o', 'p', 'q', 'r', 's', 't', 'u', 'v', 'w', 'x', 'y', 'z'),
            array('A', 'B', 'C', 'D', 'E', 'F', 'G', 'H', 'I', 'J', 'K', 'L', 'M', 'N', 'O', 'P', 'Q', 'R', 'S', 'T', 'U', 'V', 'W', 'X', 'Y', 'Z'),
            array('!', '#', '$', '%', '&', '(', ')', '*', '-', '.', '/', ':', ';', '<', '=', '>', '?', '@', '[', ']', '^', '_', '{', '|', '}')
        );

        $password = "";

        while(strlen($password) < $length){
            $charType = $characters[rand(0, 3)];
            $password .= $charType[rand(0, sizeof($charType) - 1)];
        }

        return $password;
    }
?>