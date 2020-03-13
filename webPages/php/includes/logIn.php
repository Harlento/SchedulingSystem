<?php


    if(isset($_REQUEST['userName']))
    {
        $userName = $_POST['userName'];
        $password = $_POST['password'];
		
    }
	else
	{
		//echo "There was no userName post";
	}

    try
    {
		$username = 'Coordinator';
		$dbPassword = 'Password1';
		$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $dbPassword);

        //$conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

        //echo "Connection successfull<br />";
        //phpinfo();

        $stm = $conn->prepare("SELECT USER_NAME, USER_PASS, TYPE_CODE, STAFF_ID FROM staff WHERE USER_NAME = ? ");

        if (isset($userName))
        {
            $exeParams = array($userName);

            $stm->execute($exeParams);

            $row = $stm->fetch();

            $hash = $row['USER_PASS'];
        }
		else
		{
			//echo "There is no userName variable";
		}

        if (isset($password))
        {
            if (password_verify($password, $hash))
            {
                $_SESSION['userType'] = $row['TYPE_CODE'];
                $_SESSION['staffID'] = $row['STAFF_ID'];
				
				date_default_timezone_set("US/Mountain");
				//F j, Y, g:i a
				$dateString = date("r");
				file_put_contents("./logs/loginLog.txt", "\n" . $row['USER_NAME'] . " logged in on: " . $dateString, FILE_APPEND | LOCK_EX);
				header('Location: /land.php');
				//echo $_row['STAFF_ID'];
            }
            else
            {
				
				//test
				//$array = array(1,2,3,4,5,6,7,8,9);
				//print_r($row);
				//print($hash);
				
				//test
				echo "Password not valid";
                //header("Location: index.php?message=invalidCredentials");
            }
        }
        else
        {
			//echo "Password variable not set.";
            //header("Location: index.php?message=invalidCredentials");
        }
    }
    catch(PDOException $e)
    {
		//This is development only it must be made ambiguous for users
        echo "Connection failed: " . $e->getMessage();
    }

?>
