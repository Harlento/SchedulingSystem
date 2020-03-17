<?php
echo'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Client Information</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/table.css" rel="stylesheet" type="text/css">

</head>
<body>
';

			#Starting a session and initilizing variables needed
			session_start(); 
			$userType = $_SESSION['userType'];

include "../includes/scripts/headLinks2.0.php";
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
			
			#to verify the users type
			include "../includes/functions/valUserType.php";
			valUserType($authLevel);
			
			
			$username = 'Coordinator';
			$password = 'Password1';
			$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
					
			$sql = $conn->prepare("SELECT CLIENT_ID, C_S_STATUS_NAME, GH_NAME, CLIENT_FNAME, CLIENT_LNAME, CLIENT_PHONE, CLIENT_ADDRESS, CLIENT_CITY, CLIENT_MAX_HOURS, CLIENT_KM, CLIENT_NOTES
			FROM CLIENT
			LEFT JOIN C_S_STATUS
			ON CLIENT.CLIENT_STATUS = C_S_STATUS.C_S_STATUS_CODE
			LEFT JOIN GROUP_HOME
			ON CLIENT.GH_ID = GROUP_HOME.GH_ID
			ORDER BY CLIENT_LNAME");
				
			$sql->execute();
			
			$row = $sql->fetchAll();
			
			include "../includes/scripts/navBar.php";
			
			if(isset($_REQUEST['s']))
				echo "Client updated successfully.";
			
			echo
			"<table border='1'>
				<tr>
					<th>Client</th>
					<th>Status</th>
					<th>Group Home</th>
					<th>Phone Number</th>
					<th>Address</th>
					<th>City</th>
					<th>Max Hours per Month</th>
					<th>Distance (km)</th>
					<th>Notes</th>
					<th></th>
				</tr>
			";
			
			foreach ($row as $data)
			{	
				echo "<tr>";
				echo "<td>{$data['CLIENT_LNAME']}, {$data['CLIENT_FNAME']}</td>";
				echo "<td>{$data['C_S_STATUS_NAME']}</td>";
				echo "<td>{$data['GH_NAME']}</td>";
				echo "<td>{$data['CLIENT_PHONE']}</td>";
				echo "<td>{$data['CLIENT_ADDRESS']}</td>";
				echo "<td>{$data['CLIENT_CITY']}</td>";
				echo "<td>{$data['CLIENT_MAX_HOURS']}</td>";
				echo "<td>{$data['CLIENT_KM']}</td>";
				echo "<td>{$data['CLIENT_NOTES']}</td>";
				echo "<td><a href='modclient.php?id={$data['CLIENT_ID']}'>modify</a></td>";
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