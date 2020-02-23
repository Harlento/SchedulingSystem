<?php

    //Backup directory here
    $dir = "C:/www/backup";

    //Scanning backup directory for an array of file names
    $dirArray = scandir($dir,1);

    //Natural sort of the directory array which makes the last position in the array the name of the most recent backup with the biggest number
    natsort($dirArray);

    //This is the name of the most recent backup file
    $fileName = end($dirArray);

    //Making an array of characters out of the file name string
    $fileNameArray = str_split($fileName);

    $fileNumber = "";

    //Getting the number of the current file so it may be incremented
    foreach($fileNameArray as $ph)
    {

        if(is_numeric($ph) )
        {
            $fileNumber = $fileNumber . $ph;
        }

    }

    //File number being incremented
    $fileNumber = $fileNumber + 1;

    //Constructing the name of the new backup file
    $newBackupFileName = "backup" . $fileNumber . ".sql";

    //exec argument one "mysqldump -u [userName] -p[password] mydatabase > www/backup/" . $newBackupFileName . ".sql"

    exec("mkdir dir", $output, $return);

    //This could be an issue in certain scenarios this can be inproved if time permits
    //If there is no return value the exec function worked properly
    if(!$return)
    {
        $succeeded = true;
    }
    else
    {
        $succeeded = false;
    }

    //Log failure
    if(!$succeeded)
    {
        $dateString = date("r");
        file_put_contents("C:/Users/lento/source/repos/Index.php/Index.php/backupLog/BackupLog.txt", "\nBackup unsuccessful. Date: " . $dateString, FILE_APPEND | LOCK_EX);
    }

?>