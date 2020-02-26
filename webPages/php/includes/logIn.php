<?php

    session_start();

    if(isset($_REQUEST['submit']))
    {
        $userName = $_POST['userName'];
        $password = $_POST['password'];

        $_SESSION['password'] = $password;
    }

    try
    {
        $conn = new PDO("mysql:host=localhost;dbname=", 'root', '');

        //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //echo "Connection successfull<br />";
        //phpinfo();

        $stm = $conn->prepare("SELECT USER_NAME, USER_PASS, TYPE_CODE, FROM staff WHERE USER_NAME = ? ");

        if (isset($userName))
        {
            $exeParams = array($userName);

            $stm->execute($exeParams);

            $row = $stm->fetch();

            $hash = $row['USER_PASS'];
        }

        if (isset($password))
        {
            if (password_verify($password, $hash))
            {
                $_SESSION['userType'] = $row['USER_TYPE_CODE'];
            }
            else
            {
                header("Location: index.php?message=invalidCredentials");
            }
        }
        else
        {
            header("Location: index.php?message=invalidCredentials");
        }
    }
    catch(PDOException $e)
    {
        echo "Connection failed: " . $e->getMessage();
    }

?>
