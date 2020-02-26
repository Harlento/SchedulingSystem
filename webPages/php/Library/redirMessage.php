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
function checkMessage($errCode) // checks for error code and processes w/ switch statement
{
    switch ($errCode) {
        case "invalCred": { // Case specified for invalid credential errors

        }
        case "noLogin": { // Case specified for user not being logged in

        }
        case "sessTimeout": { // Case specified for session timing out

        }
        case "badLogin": { // Case specified for a bad login - login page only.

        }
        case "badType": { // Control and countermeasure for bad user type.

        }
        case "connErr": { // Case specified for database connection error.

        }
        case "connTimeout": { // Case specified for database connection timing out.

        }
        case "": {

        }
        default: {
            /* Undefined Error.
             */
        }
    }
}
header('Location: http://schedule.edenbridge.com/index.php');  // Holder segment

?>
