<html>

    <head>

        <title>Modify Recurring Shifts</title>

    </head>

    <body>

        <?php
		
			$id = '';
			$dep = '';
			$client = '';
			$staff = '';
			$day = '';
			$start = '';
			$end = '';
			$super = '';
			$notes = '';
			
			if(isset($_POST['submit']))
			{	
				$id = $_POST['id'];
				$dep = $_POST['dep'];
				$client = $_POST['client'];
				$staff = $_POST['staff'];
				$day = $_POST['day'];
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

				$sql = $conn->prepare("UPDATE REC_SHIFT SET DEP_CODE = '$dep', CLIENT_ID = '$client', STAFF_ID = '$staff', REC_START = '$start', REC_END = '$end', REC_SUPER = '$super', REC_NOTES = '$notes'
				WHERE REC_ID = '$id'");

				$sql->execute();

				$shsql = $conn->prepare("UPDATE SHIFT SET DEP_CODE = '$dep', CLIENT_ID = '$client', STAFF_ID = '$staff', SCHEDULED_START = '$start', SCHEDULED_END = '$end', SHIFT_SUPER = '$super', SHIFT_NOTES = '$notes'
				WHERE REC_ID = '$id' AND STATUS_CODE = 'S'");
				
				$shsql->execute();
				
				//echo implode(":",$sql->errorInfo()) . "<br>";
				
				echo "record updated successfully.<br /><br />";
			}
			else
			{
				$id = $_REQUEST['id'];
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
						
				$sql = $conn->prepare("SELECT REC_ID, REC_SHIFT.DEP_CODE, DEP_NAME, REC_SHIFT.CLIENT_ID, CLIENT_FNAME, CLIENT_LNAME, REC_SHIFT.STAFF_ID, STAFF_FNAME, STAFF_LNAME, REC_DAY, REC_START, REC_END, REC_SUPER, REC_NOTES
				FROM REC_SHIFT
				LEFT JOIN DEPARTMENT
				ON REC_SHIFT.DEP_CODE = DEPARTMENT.DEP_CODE
				LEFT JOIN CLIENT
				ON REC_SHIFT.CLIENT_ID = CLIENT.CLIENT_ID
				LEFT JOIN STAFF
				ON REC_SHIFT.STAFF_ID = STAFF.STAFF_ID
				WHERE REC_ID = '$id'");
					
				$sql->execute();
				
				$row = $sql->fetch();
				//echo implode(":",$sql->errorInfo()) . "<br>";
				
				$depsql = $conn->prepare("SELECT DEP_CODE, DEP_NAME FROM DEPARTMENT WHERE DEP_CODE != '{$row['DEP_CODE']}'");
				
				$depsql->execute();
				
				$deprow = $depsql->fetchAll();
				
				$clisql = $conn->prepare("SELECT CLIENT_ID, CLIENT_FNAME, CLIENT_LNAME FROM CLIENT WHERE CLIENT_ID != '{$row['CLIENT_ID']}'");
				
				$clisql->execute();
				
				$clirow = $clisql->fetchAll();
				
				$stfsql = $conn->prepare("SELECT STAFF_ID, STAFF_FNAME, STAFF_LNAME FROM STAFF WHERE STAFF_ID != '{$row['STAFF_ID']}'");
				
				$stfsql->execute();
				
				$stfrow = $stfsql->fetchAll();
				
				printf("

					<h1>Modify a Recurring Shift</h1>

					<form method='post' action='modrecshift.php'>

						<input type='hidden' name='id' value='$id'>
						Search for Client:
							<input type='' name='' value=''><br /><br />\n

						Client Results:
							<select name='client'>
								<option value='{$row['CLIENT_ID']}'>{$row['CLIENT_FNAME']} {$row['CLIENT_LNAME']}</option>");
				foreach($clirow as $data)
					echo "<option value='{$data['CLIENT_ID']}'>{$data['CLIENT_FNAME']} {$data['CLIENT_LNAME']}</option>";
				printf("
							</select><br /><br />\n

						Department:
							<select name='dep'>
								<option value='{$row['DEP_CODE']}'>{$row['DEP_NAME']}</option>");
				foreach($deprow as $data)
					echo "<option value='{$data['DEP_CODE']}'>{$data['DEP_NAME']}</option>";
				printf("
							</select><br /><br />\n
						
						Shift Day:
							<input type='text' name='day' value='{$row['REC_DAY']}'><br /><br />\n

						Scheduled Start Time:
							<input type='time' name='start' value='{$row['REC_START']}'><br /><br />\n

						Scheduled End Time:
							<input type='time' name='end' value='{$row['REC_END']}'><br /><br />\n
							
						Search for staff:
							<input type='text' name='' value=''><br /><br />\n

						Staff results:
							<select name='staff'>
								<option value='{$row['STAFF_ID']}'>{$row['STAFF_FNAME']} {$row['STAFF_LNAME']}</option>");
				foreach($stfrow as $data)
					echo "<option value='{$data['STAFF_ID']}'>{$data['STAFF_FNAME']} {$data['STAFF_LNAME']}</option>";
				printf("
							</select><br /><br />\n

						Supervisor:");
				if($row['REC_SUPER'] == 1)
					echo "<input type='checkbox' name='super' checked><br /><br />";
				else
					echo "<input type='checkbox' name='super'><br /><br />";
				printf("
				
						Notes:
							<textarea name='notes'>{$row['REC_NOTES']}</textarea><br /><br />
						
						<input type='submit' name='submit' value='Submit'>

					</form>

				");
			}
        ?>

    </body>

</html>