<?php
echo'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	        <title>View Recurring Shift Imformation</title>
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
					
			$sql = $conn->prepare("SELECT REC_ID, DEP_NAME, CLIENT_FNAME, CLIENT_LNAME, STAFF_FNAME, STAFF_LNAME, REC_DAY, REC_START, REC_END, REC_SUPER, REC_NOTES
			FROM REC_SHIFT
			LEFT JOIN DEPARTMENT
			ON REC_SHIFT.DEP_CODE = DEPARTMENT.DEP_CODE
			LEFT JOIN CLIENT
			ON REC_SHIFT.CLIENT_ID = CLIENT.CLIENT_ID
			LEFT JOIN STAFF
			ON REC_SHIFT.STAFF_ID = STAFF.STAFF_ID
			ORDER BY CLIENT_FNAME");
				
			$sql->execute();
			
			$row = $sql->fetchAll();
			
		
			
			if(isset($_REQUEST['p']))
				echo "Recurring shifts updated successfully.";
			
			echo
			"<table border='1'>
				<tr>
					<th>Client</th>
					<th>Staff</th>
					<th>Department</th>
					<th>Day</th>
					<th>Time</th>
					<th>Staff is the Supervisor</th>
					<th>Notes</th>
					<th></th>
				</tr>
			";
			
			foreach ($row as $data)
			{	
				echo "<tr>";
				echo "<td>{$data['CLIENT_LNAME']}, {$data['CLIENT_FNAME']}</td>";
				echo "<td>{$data['STAFF_LNAME']}, {$data['STAFF_FNAME']}</td>";
				echo "<td>{$data['DEP_NAME']}</td>";
				echo "<td>{$data['REC_DAY']}</td>";
				echo "<td>{$data['REC_START']} - {$data['REC_END']}</td>";
				if($data['REC_SUPER'] == 1)
					echo "<td>Yes</td>";
				else
					echo "<td>No</td>";
				echo "<td>{$data['REC_NOTES']}</td>";
				echo "<td><a href='modrecshift.php?id={$data['REC_ID']}'>modify</a></td>";
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
	