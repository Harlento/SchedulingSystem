<?php
echo'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	        <title>Add New Group Home</title>
    <title>Table</title>
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
			
			
			$super = '';
			$name = '';
			$phone = '';
			$address = '';
			$city = '';
			
			$superr = '';
			$namerr = '';
		
			$username = 'Coordinator';
			$password = 'Password1';
			$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
		
			if(isset($_POST['submit']))
			{	
				$err = 0;
				$super = $_POST['super'];
				$name = $_POST['name'];
				$phone = $_POST['phone'];
				$address = $_POST['address'];
				$city = $_POST['city'];
				
				if($name == '')
				{
					$namerr = 'Please enter a name to identify the group home.';
					$err++;
				}
				
				if($super == '')
				{
					$superr = 'Please select a supervisor for the group home.';
					$err++;
				}

				if($err == 0)
				{
					$sql = $conn->prepare("INSERT INTO 	group_home (STAFF_ID, GH_NAME, GH_PHONE, GH_ADDRESS, GH_CITY) VALUES ('$super', '$name', '$phone', '$address', '$city')");
					
					$sql->execute();

					$id = $conn->lastInsertId();
					$code = 'G' . $id;
					$desc = 'The department for ' . $name . '.';
					
					$depsql = $conn->prepare("INSERT INTO department (DEP_CODE, GH_ID, DEP_NAME, DEP_DESC) VALUES ('$code', '$id', '$name', '$desc')");
					$depsql->execute();
					
					//echo implode(":",$sql->errorInfo());
					
					header('Location: addgh.php?s=1');
				}
			}
					
			$sql = $conn->prepare("SELECT STAFF_ID, STAFF_FNAME, STAFF_LNAME FROM staff WHERE TYPE_CODE = 'S'");
				
			$sql->execute();
			//echo implode(":",$sql->errorInfo());
			
			$row = $sql->fetchAll();
			

			
			if(isset($_REQUEST['s']))
				echo "Record added successfully.<br /><br />";	
			
			printf("

				<h1>Add New Group Home</h1>

				<form method='post' action='addgh.php'>

					Supervisor:
						<select class='fanc' name='super'>
							<option value=''>Select a supervisor:</option>");
			foreach($row as $data)
				echo "<option value='{$data['STAFF_ID']}'>{$data['STAFF_FNAME']} {$data['STAFF_LNAME']}</option>";
			printf("
						</select>$superr<br /><br />\n
						
					Group Home Name:
						<input class='form-fan' type='text' name='name' value=''>$namerr<br /><br />\n	
					
					Group Home Phone Number:
						<input class='form-fan' type='text' name='phone' value=''><br /><br />\n
												
					Group Home Address:
						<input class='form-fan' type='text' name='address' value=''><br /><br />\n
						
					Group Home City:
						<input class='form-fan' type='text' name='city' value=''><br /><br />\n
					
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