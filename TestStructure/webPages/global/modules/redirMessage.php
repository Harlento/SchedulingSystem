<?php
/*  Developer:   Beryon Clark
 *  File Name:   redirMessage.php
 *  Description: Pulls error codes from previous page and outputs error message.
 *  Date Start:  25/02/2020
 *  Date End:    TBD
 *  TODO:        -Pull error code
 *               -Switch Case for codes
 *               -Inject error message in form page is included in
 */

/*  <from action=(destination page here) method='get'
 *
 *
 */
function displayMessage($errCode) // Processes error code with switch statement
{
    switch ($errCode) {
        case "invalCred": { // Case specified for invalid credential errors
            $message = "Insufficent privileges to view page.";
            echo "<script type='text/javascript'> alert($message); </script>";
        }
        case "noLogin": { // Case specified for user not being logged in
            $message = "Please log in to view pages.";
            echo "<script type='text/javascript'> alert($message); </script>";
        }
        case "sessTimeout": { // Case specified for session timing out
            $message = "Session has timed out.";
            echo "<script type='text/javascript'> alert($message); </script>";
        }
        case "badLogin": { // Case specified for a bad login - login page only.
            $message = "Login information is incorrect. Please review information and log in again.";
            echo "<script type='text/javascript'> alert($message); </script>";
        }
        case "badType": { // Control and countermeasure for bad user type.
            $message = "User type is bad. Please log in again.";
            echo "<script type='text/javascript'> alert($message); </script>";
        }
        case "connErr": { // Case specified for database connection error.
            $message = "Error in database connection, please try again in 3 minutes.";
            echo "<script type='text/javascript'> alert($message); </script>";
        }
        case "connTimeout": { // Case specified for database connection timing out.
            $message = "Connection to database has timed out, please try again.";
            echo "<script type='text/javascript'> alert($message); </script>";
        }
        case "": {
            $message = "Login information is incorrect. Please review information and log in again.";
            echo "<script type='text/javascript'> alert($message); </script>";
        }
        default: {
            $message = "Undefined error.";
            echo "<script type='text/javascript'> alert($message); </script>";
        }
    }
}

function checkError() // Main module, triggers on an error message being set.
{
    if (isset($_GET['message']))
    {
        $errorCode = $_GET['message'];
        displayMessage($errorCode);
    }
}
?>
