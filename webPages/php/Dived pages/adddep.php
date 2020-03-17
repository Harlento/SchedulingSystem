<?php
echo'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Add New Department</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/table.css" rel="stylesheet" type="text/css">

</head>
<body>
';
			#Starting a session and initilizing variables needed
			session_start(); 
			$userType = $_SESSION['userType'];
			
			include "../includes/scripts/headLinks2.0.php"; 
			include "../includes/scripts/navBar.php";
echo'
<div class="row justify-content-center">
<form class="form-con">
    <form>
';


		
			//level of authorization required to access page
			$authLevel = "C";
			
			#to verify the user 
			include "../includes/functions/verLogin.php";
			verLogin();
			
			#test!!!!!!!!!!!!!!!!!!!!!!!1
			#print($authLevel);
			
			#to verify the users type
			include "../includes/functions/valUserType.php";
			valUserType($authLevel);
			
			
			$code = '';
			$name = '';
			$desc = '';
			
			$coderr = '';
			$namerr = '';
		
			if(isset($_POST['submit']))
			{	
				$err = 0;
				$code = $_POST['code'];
				$name = $_POST['name'];
				$desc = $_POST['desc'];
				
				if($code == '' || strlen($code) > 3)
				{
					$coderr = 'Please enter a valid 3-character code.';
					$err ++;
				}
				
				if($name == '')
				{
					$namerr = 'Please enter a name for the department.';
					$err ++;
				}
				
				if($err == 0)
				{
					$username = 'Coordinator';
					$password = 'Password1';
					$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

					$sql = $conn->prepare("INSERT INTO 	department (DEP_CODE, DEP_NAME, DEP_DESC) VALUES ('$code', '$name', '$desc')");
					
					$sql->execute();
					
					//echo implode(":",$sql->errorInfo());
					
					header('Location: adddep.php?s=1');
				}
			}	
			
				
			if(isset($_REQUEST['s']))
				echo "Record added successfully.<br /><br />";	
			
			printf("

				<h1>Add New Department</h1>

				<form method='post' action='adddep.php'>
						
					Department Code:
						<input class='form-fan' type='text' name='code' value='$code'>$coderr<br /><br />\n	
						
					Department Name:
						<input class='form-fan' type='text' name='name' value='$name'>$namerr<br /><br />\n

					Department Description:
						<textarea name='desc'></textarea><br /><br />\n

					<input class='form-fan' type='submit' name='submit' value='Submit'>\n

				</form>

			");
			
echo'
            

    </form>
</form>
</div>';
	include "../includes/scripts/footer.php";
	echo'
</body>
</html>
    ';
	?>
	

</html>