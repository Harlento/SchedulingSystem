<?php
session_start();
/*  Developer:   Beryon Clark
 *  File Name:   valUserType.php
 *  Description: Verifies the user type of any user, second phase of restricting access to pages.
 *  Date Start:  20/02/2020
 *  Date End:    TBD
 *  TODO:        -Pull user type
 *               -Check against passed variable/authorization level
 *               -Implement redirect w/ invalid entry
 *               -Test functionality
 */

function checkType($authLevel)
{


    switch ($authLevel) {
        case "worker": { // Case specified for worker-only pages.
         if ($_SESSION['loginType'] != 'WORKER') {
            $prevPage = $_SESSION['page'] . "?message=invalCred";

         }
        }
        case "coord": { // Case specified for coordinator-only pages.
            /* Redirect through hidden form with previous page information, append to end of URL error message for
             * invalid user type.
             */
        }
        case "superv": { // Case specified for supervisor-only pages.
            /* Redirect through hidden form with previous page information, append to end of URL error message for
             * invalid user type.
             */
        }
        case "bookeeper": { // Case specified for bookkeeper-only pages.
            /* Redirect through hidden form with previous page information, append to end of URL error message for
             * invalid user type.
             */
        }
        case "admin": { // Case specified for administrator-only pages. Not used elsewhere presently.
            /* Redirect through hidden form with previous page information, append to end of URL error message for
             * invalid user type.
             */
        }
        default: {
            /* Force logout with error saying that invalid user type was detected. Include administrator contact.
             */
        }
    }
}
header('Location: http://schedule.edenbridge.com/index.php');  // Holder segment

?>