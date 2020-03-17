<?php
echo'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	        <title>Scedule A New shift</title>
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
			
			$dep = '';
			$client = '';
			$staff = '';
			$date = '';
			$start = '';
			$end = '';
			$super = '';
			$notes = '';
			
			$deperr = '';
			$clierr = '';
			$staerr = '';
			$daterr = '';
			$sterr = '';
			$enderr = '';
			
			$username = 'Coordinator';
			$password = 'Password1';
			$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
		
			if(isset($_POST['submit']))
			{	
				$err = 0;
				
				if(isset($_POST['rec']))
				{
					$dep = $_POST['dep'];
					$client = $_POST['client'];
					$staff = $_POST['staff'];
					$date = strtotime($_POST['date']);
					$stdate = $_POST['date'];
					$day = date('D', $date);
					$start = $_POST['start'];
					$end = $_POST['end'];
					if(isset($_POST['super']))
						$super = 1;
					else
						$super = 0;
					$notes = $_POST['notes'];
					
					if($dep == '')
					{
						$deperr = 'Please select a department.';
						$err++;
					}
					if($client == '')
					{
						$clierr = 'Please select a client.';
						$err++;
					}
					if($staff == '')
					{
						$staerr = 'Please select a staff member.';
						$err++;
					}
					if($date == '')
					{
						$daterr = 'Please select a date.';
						$err++;
					}
					if($start == '')
					{
						$sterr = 'Please choose a start time.';
						$err++;
					}
					if($end == '' || strtotime($end) < strtotime($start))
					{
						$enderr = 'Please choose a valid end time.';
						$err++;
					}
					
					if($err == 0)
					{
						$sql = $conn->prepare("INSERT INTO REC_SHIFT (DEP_CODE, CLIENT_ID, STAFF_ID, REC_DAY, REC_START, REC_END, REC_SUPER, REC_NOTES)
						VALUES ('$dep', '$client', '$staff', '$day', '$start', '$end', '$super', '$notes')");
						
						$sql->execute();
						
						//echo implode(":",$sql->errorInfo());
						
						$recid = $conn->lastInsertId();
						
						header("Location: schedrecshift.php?recid=$recid&st=$stdate");
					}
				}
				else
				{
					$dep = $_POST['dep'];
					$client = $_POST['client'];
					$staff = $_POST['staff'];
					$date = $_POST['date'];
					$start = $_POST['start'];
					$end = $_POST['end'];
					if(isset($_POST['super']))
						$super = 1;
					else
						$super = 0;
					$notes = $_POST['notes'];

					if($dep == '')
					{
						$deperr = 'Please select a department.';
						$err++;
					}
					if($client == '')
					{
						$clierr = 'Please select a client.';
						$err++;
					}
					if($staff == '')
					{
						$staerr = 'Please select a staff member.';
						$err++;
					}
					if($date == '')
					{
						$daterr = 'Please select a date.';
						$err++;
					}
					if($start == '')
					{
						$sterr = 'Please choose a start time.';
						$err++;
					}
					if($end == '' || strtotime($end) <= strtotime($start))
					{
						$enderr = 'Please choose a valid end time.';
						$err++;
					}

					if($err == 0)
					{
						$sql = $conn->prepare("INSERT INTO SHIFT (DEP_CODE, CLIENT_ID, STAFF_ID, SHIFT_DATE, SCHEDULED_START, SCHEDULED_END, SHIFT_SUPER, SHIFT_NOTES)
						VALUES ('$dep', '$client', '$staff', '$date', '$start', '$end', '$super', '$notes')");
						
						$sql->execute();
						
						//echo implode(":",$sql->errorInfo());
						
						header("Location: schedshift.php?s=1");
					}
				}
			}
			
			$depsql = $conn->prepare("SELECT * FROM department");
			$clisql = $conn->prepare("SELECT * FROM client where CLIENT_STATUS = 'A'");
			$stasql = $conn->prepare("SELECT * FROM staff where STAFF_STATUS = 'A'");
				
			$depsql->execute();
			$deprow = $depsql->fetchAll();
			$clisql->execute();
			$clirow = $clisql->fetchAll();
			$stasql->execute();
			$starow = $stasql->fetchAll();
			
	
			
			if(isset($_REQUEST['s']))
				echo "Shift Scheduled successfully.<br /><br />";
			if(isset($_REQUEST['r']))
				echo "Shifts Scheduled successfully.<br /><br />";
			
			printf("

				<h1>Schedule a New Shift</h1>

				<form method='post' action='schedshift.php'>

					Search for Client:
						<input class='form-fan' type='' name='' value=''><br /><br />\n

					Client Results:
						<select class='fanc' name='client'>
							<option value=''>Select a Client:</option>");
			foreach($clirow as $data)
				echo "<option value='{$data['CLIENT_ID']}'>{$data['CLIENT_FNAME']} {$data['CLIENT_LNAME']}</option>";
			printf("
						</select>$clierr<br /><br />\n

					Department:
						<select class='fanc' name='dep'>
							<option value=''>Select a Department:</option>");
			foreach($deprow as $data)
				echo "<option value='{$data['DEP_CODE']}'>{$data['DEP_NAME']}</option>";
			printf("
						</select>$deperr<br /><br />\n

					Shift Date:
						<input class='form-fan' type='date' name='date' value='$date'>$daterr<br /><br />\n
						
					Recurring Shift: ");
				if(isset($_POST['rec']))
					echo "<input class='form-fan' type='checkbox' name='rec' checked><br /><br />";
				else
					echo "<input class='form-fan' type='checkbox' name='rec'><br /><br />";
				printf("

					Start Time:
						<input class='form-fan' type='time' name='start' value='$start'>$sterr<br /><br />\n

					End Time:
						<input class='form-fan' type='time' name='end' value='$end'>$enderr<br /><br />\n

					Search for Staff:
						<input class='form-fan' type='text' name='' value=''><br /><br />\n

					Staff results:
						<select class='fanc' name='staff'>
							<option value=''>Select a Staff Member:</option>");
			foreach($starow as $data)
				echo "<option value='{$data['STAFF_ID']}'>{$data['STAFF_FNAME']} {$data['STAFF_LNAME']}</option>";
			printf("
						</select>$staerr<br /><br />\n

						Supervisor: ");
				if(isset($_POST['super']))
					echo "<input class='form-fan' type='checkbox' name='super' checked><br /><br />";
				else
					echo "<input class='form-fan' type='checkbox' name='super'><br /><br />

					Shift Notes:
						<textarea name='notes'>$notes</textarea><br /><br />\n

					<input class='form-fan' type='submit' name='submit' value='Submit'>

				</form>";
		
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