<?php
session_start();
/*  Developer:   Beryon Clark
 *  File Name:   verLogin.php
 *  Description: Verifies that user is logged in upon entering page restricted to authenticated users.
 *  Date Start:  20/02/2020
 *  Date End:    TBD
 *  TODO:        -Test functionality
 */

function verLogin(){
    if(isset($_SESSION['loginID']) == false) {
        header('Location: http://schedule.edenbridge.com/index.php');
    }
}






?>