<?php
/*  Developer:   Beryon Clark
 *  File Name:   passStrength.php
 *  Description: Evaluates password strength as user enters in new password. Called through AJAX for evaluating updates.
 *  Date Start:  26/02/2020
 *  Date End:    TBD
 *  TODO:        -Establish check for alphanumeric/special characters
 *               -Test
 */
 // Setting up new variables.
$passStrength = 0;
$passLength = 0;
$password = $_POST['newPassword']; // Ideally, will be sanitized to allow PHP to safely read it.
$strength = '';
$passAlpha = false;
$passNum = false;
$passSym = false;

if ($password != '')
{
    $passLength = strlen($password);

    if ($passLength <= 8) // Checking password length. Above 8 characters, password strength is incremented.
    {
        // Output "Password is too short"
    }
    else
    {
        $passStrength = $passLength - 8;
    }

    // Check if string contains alphanumeric characters as well as symbols.

    if ((($passStrength >= 1) && ($passStrength <= 2)) && ($passAlpha == false) && ($passNum == false) && ($passSym == false))
    {
        $strength = 'Weak';
    }
    elseif (($passStrength >= 3) && ($passStrength <= 4)) // Moderate condition
    {
        $strength = 'Moderate';
    }
    else if (($passStrength >= 5) && ($passAlpha == true) && ($passNum == true) && ($passSym == true))
    {
        $strength == 'Strong';
    }
    echo $strength;
}


?>
