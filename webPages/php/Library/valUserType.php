<?php
session_start();
/*  Developer:   Beryon Clark
 *  File Name:   valUserType.php
 *  Description: Verifies the user type of any user, second phase of restricting access to pages.
 *  Date Start:  20/02/2020
 *  Date End:    TBD
 *  TODO:        -Implement redirect w/ invalid entry
 *               -Test functionality
 */

function checkType($authLevel)
{


    switch ($authLevel) {
        case "worker": { // Case specified for worker-only pages.
         if ($_SESSION['loginType'] != 'WORKER') {
            $prevPage = $_SESSION['page'] . "?message=invalCred";
             header('Location: ' . $prevPage);
         }
        }
        case "coordinator": { // Case specified for coordinator-only pages.
            /* Redirect through hidden form with previous page information, append to end of URL error message for
             * invalid user type.
             */
            if ($_SESSION['loginType'] != 'COORDINATOR') {
                $prevPage = $_SESSION['page'] . "?message=invalCred";
                header('Location: ' . $prevPage);
            }
        }
        case "supervisor": { // Case specified for supervisor-only pages.
            /* Redirect through hidden form with previous page information, append to end of URL error message for
             * invalid user type.
             */
            if ($_SESSION['loginType'] != 'SUPERVISOR') {
                $prevPage = $_SESSION['page'] . "?message=invalCred";
                header('Location: ' . $prevPage);
            }
        }
        case "bookkeeper": { // Case specified for bookkeeper-only pages.
            /* Redirect through hidden form with previous page information, append to end of URL error message for
             * invalid user type.
             */
            if ($_SESSION['loginType'] != 'BOOKKEEPER') {
                $prevPage = $_SESSION['page'] . "?message=invalCred";
                header('Location: ' . $prevPage);
            }
        }
        case "admin": { // Case specified for administrator-only pages. Not used elsewhere presently.
            /* Redirect through hidden form with previous page information, append to end of URL error message for
             * invalid user type.
             */
            if ($_SESSION['loginType'] != 'ADMIN') {
                $prevPage = $_SESSION['page'] . "?message=invalCred";
                header('Location: ' . $prevPage);
            }
        }
        default: { // Case specified for when no match to the user type is found. Control module in event of session poisoning.
            session_unset();
            session_destroy();
            header('Location: http://schedule.edenbridge.com/index.php?message=badType');
        }
    }
}
header('Location: http://schedule.edenbridge.com/index.php');  // Holder segment

?>