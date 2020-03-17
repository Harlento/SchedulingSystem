<?php
echo'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	        <title>View Department Information</title>
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
			
			
			$username = 'Coordinator';
			$password = 'Password1';
			$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
					
			$sql = $conn->prepare("SELECT * FROM DEPARTMENT");
				
			$sql->execute();
			
			$row = $sql->fetchAll();
			
			
			
			if(isset($_REQUEST['p']))
				echo "Department updated successfully.";
			
			echo
			"<table border='1'>
				<tr>
					<th>Department Code</th>
					<th>Department</th>
					<th>Department Description</th>
					<th></th>
				</tr>
			";
			
			foreach ($row as $data)
			{
				echo "<tr>";
				echo "<td>{$data['DEP_CODE']}</td>";
				echo "<td>{$data['DEP_NAME']}</td>";
				echo "<td>{$data['DEP_DESC']}</td>";
				echo "<td><a href='moddep.php?code={$data['DEP_CODE']}'>modify</a></td>";
				echo "</tr>";
			}
				
			echo "</table><br />\n";
			
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
	