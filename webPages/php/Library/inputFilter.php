<?php
/*  Developer:   Beryon Clark
 *  File Name:   inputFilter.php
 *  Description: Extends multiple functions to validate input.
 *  Date Start:  26/02/2020
 *  Date End:    TBD
 */

function validateInput($str, $type)
{
// Date format being used is yyyy-mm-dd
    $filtString = filter_var($str, FILTER_SANITIZE_STRING, FILTER_FLAG_STRIP_LOW);
    switch ($type)
    {
        case "date":
        {
            $dateArr  = explode('-', $filtString);
            if (count($dateArr) == 3) {
                if (checkdate($dateArr[0], $dateArr[1], $dateArr[2])) {
                    // valid date ...
                }
                else {
                    // problem with dates ...
                }
            }
            else {
                // problem with input ...
            }
        }
        case "string":
        {
            return $str;
        }
        case "email":
        {
            $emailString = filter_var($filtString, FILTER_VALIDATE_EMAIL);
            return $emailString;
        }
        case "phone":
        {
            filter_var($filtString, FILTER_VALIDATE_REGEXP);
            return $str;
        }
    }
}

?>