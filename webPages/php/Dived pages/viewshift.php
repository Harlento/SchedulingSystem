<?php
echo'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>View Shift</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/table.css" rel="stylesheet" type="text/css">
</head>
<body>';
session_start(); 
	$userType = $_SESSION['userType'];
include "../includes/scripts/navBar.php";
echo '
<div class="row justify-content-center">
<form class="form-con">
    <form>
';

	#Starting a session and initilizing variables needed

	

	include "../includes/scripts/headLinks2.0.php";
echo '<link href="../css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="../css/table.css" rel="stylesheet" type="text/css">
</head>
<body>';
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
		
$sql = $conn->prepare("SELECT SHIFT_ID, STATUS_NAME, DEP_NAME, CLIENT_FNAME, CLIENT_LNAME, STAFF_FNAME, STAFF_LNAME, SHIFT_DATE, SCHEDULED_START, SCHEDULED_END, CLAIMED_START, CLAIMED_END, APPROVED_START, APPROVED_END, SHIFT_SUPER, SHIFT_NOTES
FROM SHIFT
LEFT JOIN SHIFT_STATUS
ON SHIFT.STATUS_CODE = SHIFT_STATUS.STATUS_CODE
LEFT JOIN DEPARTMENT
ON SHIFT.DEP_CODE = DEPARTMENT.DEP_CODE
LEFT JOIN CLIENT
ON SHIFT.CLIENT_ID = CLIENT.CLIENT_ID
LEFT JOIN STAFF
ON SHIFT.STAFF_ID = STAFF.STAFF_ID
ORDER BY SHIFT_DATE");
	
$sql->execute();

$row = $sql->fetchAll();
echo '<section class="container-fluid">
    <section class="row justify-content-center">
        <section class="col-24 col-lg-12 col-xl-33">
            <form class="form-con">
                <form>
                    <div>';

			echo
			"<table border='1'>
				<tr>
					<th>Client</th>
					<th>Staff</th>
					<th>Department</th>
					<th>Date</th>
					<th>Status</th>
					<th>Scheduled Time</th>
					<th>Claimed Time</th>
					<th>Approved Time</th>
					<th>Staff is the Supervisor</th>
					<th>Notes</th>
					<th></th>
				</tr>
			";
			
			include "../includes/functions/convertHours.php";
			
			foreach ($row as $data)
			{
			
				echo "<tr>";
				echo "<td>{$data['CLIENT_LNAME']}, {$data['CLIENT_FNAME']}</td>";
				echo "<td>{$data['STAFF_LNAME']}, {$data['STAFF_FNAME']}</td>";
				echo "<td>{$data['DEP_NAME']}</td>";
				echo "<td>{$data['SHIFT_DATE']}</td>";
				echo "<td>{$data['STATUS_NAME']}</td>";
				echo "<td>" . date('h:i a', strtotime($data['SCHEDULED_START'])) . '-' . date('h:i a', strtotime($data['SCHEDULED_END'])) . "</td>";
				echo "<td>" . date('h:i a', strtotime($data['CLAIMED_START'])) . '-' . date('h:i a', strtotime($data['CLAIMED_END'])) . "</td>";
				echo "<td>" . date('h:i a', strtotime($data['APPROVED_START'])) . '-' . date('h:i a', strtotime($data['APPROVED_END'])) . "</td>";
				if($data['SHIFT_SUPER'] == 1)
					echo "<td>Yes</td>";
				else
					echo "<td>No</td>";
				echo "<td>{$data['SHIFT_NOTES']}</td>";
				echo "<td><a href='modshift.php?id={$data['SHIFT_ID']}'>modify</a></td>";
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