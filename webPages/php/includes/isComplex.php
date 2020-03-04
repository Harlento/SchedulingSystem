<?php

    function isComplex(string $password)
    {

        $upper = false;
        $lower = false;
        $number = false;
        $special = false;
        $length = "";

        //the password they want to use is passed to this which splits it into an array of single character strings
        $passwordArray = str_split($password);

        //How many characters in length the string is
        $length = count($passwordArray);

        foreach($passwordArray as $ph)
        {
            if(ctype_upper($ph))
            {
                $upper = true;
            }
            if(ctype_lower($ph))
            {
                $lower = true;
            }
            if(ctype_digit($ph))
            {
                $number = true;
            }
            if(isSpecial($ph))
            {
                $special = true;
            }
        }

        if( ($upper) && ($lower) && ($number) && ($special) && ($length >= 8) )
        {
            return true;
        }
        else
        {
            return false;
        }

    }

?>
