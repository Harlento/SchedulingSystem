<?php
echo'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	        <title>Scedule Recurring Shift</title>
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

			//schedule shifts for one rec id
			if(isset($_POST['submit']) && isset($_POST['id']))
			{
				$id = $_POST['id'];
				$start = strtotime($_POST['start']);
				$end = strtotime($_POST['end']);

				$sql = $conn->prepare("SELECT * FROM REC_SHIFT
				WHERE REC_ID = '$id'");
					
				$sql->execute();
				
				echo implode(":",$sql->errorInfo()) . "<br>";
				
				$row = $sql->fetch();
				
				$dep = $row['DEP_CODE'];
				$client = $row['CLIENT_ID'];
				$staff = $row['STAFF_ID'];
				$timeSt = $row['REC_START'];
				$timeEnd = $row['REC_END'];
				$super = $row['REC_SUPER'];
				$notes = $row['REC_NOTES'];
				
				$day = $row['REC_DAY'];
				
				$date = $start;
				$last = $end;
				
				//While the date isn't the correct day of the week, add 1 day
				while(date('D', $date) != $day)
				{
					$date = strtotime('+1 day', $date);
				}
				//until the end date, schedule shifts
				while($date < $end)
				{
					$shDate = date('y-m-d', $date);
					$shsql = $conn->prepare("INSERT INTO SHIFT (REC_ID, DEP_CODE, CLIENT_ID, STAFF_ID, SHIFT_DATE, SCHEDULED_START, SCHEDULED_END, SHIFT_SUPER, SHIFT_NOTES)
					VALUES ('$id', '$dep', '$client', '$staff', '$shDate', '$timeSt', '$timeEnd', '$super', '$notes')");

					$shsql->execute();
					
					//echo implode(":",$shsql->errorInfo()) . "<br>";
					
					$date = strtotime('+7 days', $date);
				}
				
				header("Location: schedshift.php?r=1");
			}
			
			//schedule shifts for a department
			else if(isset($_POST['submit']) && isset($_POST['dep']))
			{	
				$dep = $_POST['dep'];
				$start = strtotime($_POST['start']);
				$end = strtotime($_POST['end']);

				$sql = $conn->prepare("SELECT * FROM REC_SHIFT
				WHERE DEP_CODE = '$dep'");
					
				$sql->execute();
				
				$row = $sql->fetchAll();
				
				foreach($row as $data)
				{
					$id = $data['REC_ID'];
					$dep = $data['DEP_CODE'];
					$client = $data['CLIENT_ID'];
					$staff = $data['STAFF_ID'];
					$timeSt = $data['REC_START'];
					$timeEnd = $data['REC_END'];
					$super = $data['REC_SUPER'];
					$notes = $data['REC_NOTES'];
					
					$day = $data['REC_DAY'];
					
					$date = $start;
					$date . "<br>";
					$last = $end;
					$last . "<br>";
					
					//While the date isn't the correct day of the week, add 1 day
					while(date('D', $date) != $day)
					{
						$date = strtotime('+1 day', $date);
					}
					//until the end date, schedule shifts
					while($date < $end)
					{
						$shDate = date('y-m-d', $date);
						$shsql = $conn->prepare("INSERT INTO SHIFT (REC_ID, DEP_CODE, CLIENT_ID, STAFF_ID, SHIFT_DATE, SCHEDULED_START, SCHEDULED_END, SHIFT_SUPER, SHIFT_NOTES)
						VALUES ('$id', '$dep', '$client', '$staff', '$shDate', '$timeSt', '$timeEnd', '$super', '$notes')");

						$shsql->execute();
						
						//echo implode(":",$shsql->errorInfo()) . "<br>";
						
						$date = strtotime('+7 days', $date);
					}
				}
				
				header("Location: schedrecshift.php?s=1");
			}
			

			if(isset($_REQUEST['recid']) && isset($_REQUEST['st']))
			{
				$id = $_REQUEST['recid'];
				$start = $_REQUEST['st'];

				printf("
				<h1>Schedule Recurring Shifts</h1>

					<form method='post' action='schedrecshift.php'>
						<input class='form-fan' type='hidden' name='id' value='$id'>
						
						Schedule Shifts From Start Date:
							<input class='form-fan' type='date' name='start' value='$start'><br /><br />\n

						To End Date:
							<input class='form-fan' type='date' name='end' value=''><br /><br />\n

						<input class='form-fan' type='submit' name='submit' value='Submit'>

					</form>

				");
				
				include "../includes/scripts/footer.php";
				die();
			}
			
			$depsql = $conn->prepare("SELECT DEP_CODE, DEP_NAME FROM DEPARTMENT");
			
			$depsql->execute();
			
			$deprow = $depsql->fetchAll();
			
			if(isset($_REQUEST['s']))
				echo "Shift Scheduled successfully.<br /><br />";
			
			printf("
			<h1>Schedule Recurring Shifts</h1>

				<form method='post' action='schedrecshift.php'>

					Select a Department to Schedule Shifts For:
						<select class='fanc' name='dep'>
							<option value=''>Choose a Department</option>");
			foreach($deprow as $data)
				echo "<option value='{$data['DEP_CODE']}'>{$data['DEP_NAME']}</option>";
			printf("
						</select><br /><br />\n
					
					From Start Date:
						<input class='form-fan' type='date' name='start' value=''><br /><br />\n

					To End Date:
						<input class='form-fan' type='date' name='end' value=''><br /><br />\n

					<input class='form-fan' type='submit' name='submit' value='Submit'>

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