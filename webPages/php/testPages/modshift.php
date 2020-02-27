<html>

    <head>

        <title>Modify Shift</title>

    </head>

    <body>

        <?php
		
			$id = '';
			$status = '';
			$dep = '';
			$client = '';
			$staff = '';
			$date = '';
			$schStart = '';
			$schEnd = '';
			$claStart = '';
			$claEnd = '';
			$appStart = '';
			$appEnd = '';
			$super = '';
			$notes = '';
			
			if(isset($_POST['submit']))
			{	
				print_r($_POST);
				$id = $_POST['id'];
				$status = $_POST['status'];
				$dep = $_POST['dep'];
				$client = $_POST['client'];
				$staff = $_POST['staff'];
				$date = $_POST['date'];
				$schStart = $_POST['schStart'];
				$schEnd = $_POST['schEnd'];
				$claStart = $_POST['claStart'];
				$claEnd = $_POST['claEnd'];
				$appStart = $_POST['appStart'];
				$appEnd = $_POST['appEnd'];
				$super = $_POST['super'];
				$notes = $_POST['notes'];
				
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

				$sql = $conn->prepare("UPDATE SHIFT SET STATUS_CODE = '$status', DEP_CODE = '$dep', CLIENT_ID = '$client', STAFF_ID = '$staff', SHIFT_DATE = '$date', SCHEDULED_START = '$schStart', SCHEDULED_END = '$schEnd',
				CLAIMED_START = '$claStart', CLAIMED_END = '$claEnd', APPROVED_START = '$appStart', APPROVED_END = '$appEnd', SHIFT_NOTES = '$notes'
				WHERE SHIFT_ID = '$id'");
				
				$sql->execute();
				
				//echo implode(":",$sql->errorInfo()) . "<br>";
				
				echo "record updated successfully.<br /><br />";
			}
			else
			{
				$id = $_REQUEST['id'];
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
						
				$sql = $conn->prepare("SELECT SHIFT_ID, SHIFT.STATUS_CODE, STATUS_NAME, SHIFT.DEP_CODE, DEP_NAME, SHIFT.CLIENT_ID, CLIENT_FNAME, CLIENT_LNAME, SHIFT.STAFF_ID, STAFF_FNAME, STAFF_LNAME, SHIFT_DATE,
				SCHEDULED_START, SCHEDULED_END, CLAIMED_START, CLAIMED_END, APPROVED_START, APPROVED_END, SHIFT_SUPER, SHIFT_NOTES
				FROM SHIFT
				LEFT JOIN SHIFT_STATUS
				ON SHIFT.STATUS_CODE = SHIFT_STATUS.STATUS_CODE
				LEFT JOIN DEPARTMENT
				ON SHIFT.DEP_CODE = DEPARTMENT.DEP_CODE
				LEFT JOIN CLIENT
				ON SHIFT.CLIENT_ID = CLIENT.CLIENT_ID
				LEFT JOIN STAFF
				ON SHIFT.STAFF_ID = STAFF.STAFF_ID
				WHERE SHIFT_ID = '$id'");
					
				$sql->execute();
				
				$row = $sql->fetch();
				//echo implode(":",$sql->errorInfo()) . "<br>";
				
				$stasql = $conn->prepare("SELECT * FROM SHIFT_STATUS WHERE STATUS_CODE != '{$row['STATUS_CODE']}'");
				
				$stasql->execute();
				
				$starow = $stasql->fetchAll();
				
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

					<h1>Modify a Shift</h1>

					<form method='post' action='modshift.php'>

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
							
						Shift Status:
							<select name='status'>
								<option value='{$row['STATUS_CODE']}'>{$row['STATUS_NAME']}</option>");
				foreach($starow as $data)
					echo "<option value='{$data['STATUS_CODE']}'>{$data['STATUS_NAME']}</option>";
				printf("
							</select><br /><br />\n
						
						Shift Date:
							<input type='date' name='date' value='{$row['SHIFT_DATE']}'><br /><br />\n

						Scheduled Start Time:
							<input type='time' name='schStart' value='{$row['SCHEDULED_START']}'><br /><br />\n

						Scheduled End Time:
							<input type='time' name='schEnd' value='{$row['SCHEDULED_END']}'><br /><br />\n
							
						Claimed Start Time:
							<input type='time' name='claStart' value='{$row['CLAIMED_START']}'><br /><br />\n

						Claimed End Time:
							<input type='time' name='claEnd' value='{$row['CLAIMED_END']}'><br /><br />\n
							
						Approved Start Time:
							<input type='time' name='appStart' value='{$row['APPROVED_START']}'><br /><br />\n

						Approved End Time:
							<input type='time' name='appEnd' value='{$row['APPROVED_END']}'><br /><br />\n
							
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
				if($row['SHIFT_SUPER'] == 1)
					echo "<input type='checkbox' name='super' checked><br /><br />";
				else
					echo "<input type='checkbox' name='super'><br /><br />";
				printf("
				
						Notes:
							<textarea name='notes'>{$row['SHIFT_NOTES']}</textarea><br /><br />
						
						<input type='submit' name='submit' value='Submit'>

					</form>

				");
			}
        ?>

    </body>

</html>