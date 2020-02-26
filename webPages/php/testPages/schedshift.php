<html>

    <head>

        <title>Schedule a New Shift</title>

    </head>

    <body>

        <?php
			
			$dep = '';
			$client = '';
			$staff = '';
			$date = '';
			$start = '';
			$end = '';
			$super = '';
			$notes = '';
		
			if(isset($_POST['submit']))
			{	
				if(isset($_POST['rec']))
				{
					$dep = $_POST['dep'];
					$client = $_POST['client'];
					$staff = $_POST['staff'];
					$date = strtotime($_POST['date']);
					$day = date('D', $date);
					$start = $_POST['start'];
					$end = $_POST['end'];
					if(isset($_POST['super']))
						$super = 1;
					else
						$super = 0;
					$notes = $_POST['notes'];
					
					$username = 'Coordinator';
					$password = 'Password1';
					$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
					
					$sql = $conn->prepare("INSERT INTO REC_SHIFT (DEP_CODE, CLIENT_ID, STAFF_ID, REC_DAY, REC_START, REC_END, REC_SUPER, SHIFT_NOTES)
					VALUES ('$dep', '$client', '$staff', '$day', '$start', '$end', '$super', '$notes')");
					
					$sql->execute();
					
					//echo implode(":",$sql->errorInfo());
					
					echo "Shift scheduled successfully.<br /><br />";
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
						$super = 1;
					$notes = $_POST['notes'];
					
					$username = 'Coordinator';
					$password = 'Password1';
					$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

					$sql = $conn->prepare("INSERT INTO SHIFT (DEP_CODE, CLIENT_ID, STAFF_ID, SHIFT_DATE, SCHEDULED_START, SCHEDULED_END, SHIFT_SUPER, SHIFT_NOTES)
					VALUES ('$dep', '$client', '$staff', '$date', '$start', '$end', '$super', '$notes')");
					
					$sql->execute();
					
					//echo implode(":",$sql->errorInfo());
					
					echo "Shift scheduled successfully.<br /><br />";
				}
			}
			else
			{
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
				
				$depsql = $conn->prepare("SELECT * FROM department");
				$clisql = $conn->prepare("SELECT * FROM client where CLIENT_STATUS = 'A'");
				$stasql = $conn->prepare("SELECT * FROM staff where STAFF_STATUS = 'A'");
				
				$depsql->execute();
				$deprow = $depsql->fetchAll();
				$clisql->execute();
				$clirow = $clisql->fetchAll();
				$stasql->execute();
				$starow = $stasql->fetchAll();
				
				printf("

					<h1>Schedule a New Shift</h1>

					<form method='post' action='schedshift.php'>

						Search for Client:
							<input type='' name='' value=''><br /><br />\n

						Client Results:
							<select name='client'>
								<option value=''>Select a Client:</option>");
				foreach($clirow as $data)
					echo "<option value='{$data['CLIENT_ID']}'>{$data['CLIENT_FNAME']} {$data['CLIENT_LNAME']}</option>";
				printf("
							</select><br /><br />\n

						Department:
							<select name='dep'>
								<option value=''>Select a Department:</option>");
				foreach($deprow as $data)
					echo "<option value='{$data['DEP_CODE']}'>{$data['DEP_NAME']}</option>";
				printf("
							</select><br /><br />\n

						Shift Date:
							<input type='date' name='date' value=''><br /><br />\n

						Start Time:
							<input type='time' name='start' value=''><br /><br />\n

						End Time:
							<input type='time' name='end' value=''><br /><br />\n

						Search for staff:
							<input type='text' name='' value=''><br /><br />\n

						Staff results:
							<select name='staff'>
								<option value=''>Select a Staff Member:</option>");
				foreach($starow as $data)
					echo "<option value='{$data['STAFF_ID']}'>{$data['STAFF_FNAME']} {$data['STAFF_LNAME']}</option>";
				printf("
							</select><br /><br />\n

						Supervisor:
							<input type='checkbox' name='super' value=''><br /><br />\n

						Recurring shift:
							<input type='checkbox' name='rec' value=''><br /><br />\n

						Shift Notes:
							<textarea name='notes'>
							</textarea><br /><br />\n

						<input type='submit' name='submit' value='Submit'>

					</form>

				");
			}
        ?>

    </body>

</html>