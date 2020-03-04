/*  Developer:   Justin Alho
 *  File Name:   schedrecshift.php
 *  Description: Allows coordinators to schedule shifts from a recurring shift record
 *  Date Start:  27/02/2020
 *  Date End:    TBD
 *  TODO:        - Add CSS
 *		 - Add data verification
 *		 - Add user authentication
 */
<html>

    <head>

        <title>Schedule Recurring Shifts</title>

    </head>

    <body>

        <?php

	    		//If request is submitted, shift records are created
			if(isset($_POST['submit']))
			{	
				print_r($_POST);
				$dep = $_POST['dep'];
				$start = strtotime($_POST['start']);
				$end = strtotime($_POST['end']);
				
				//Retrieve recurring shift information for selected department
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

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
				}
				
				echo "Shifts Created Successfully.<br /><br />";
			}
			else
			{
				//Retrieve list of departments to schedule shifts for
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
				
				$depsql = $conn->prepare("SELECT DEP_CODE, DEP_NAME FROM DEPARTMENT");
				
				$depsql->execute();
				
				$deprow = $depsql->fetchAll();

				printf("
				<h1>Schedule Recurring Shifts</h1>

					<form method='post' action='schedrecshift.php'>

						Select a Department to Schedule Shifts For:
							<select name='dep'>
								<option value=''>Choose a Department</option>");
				foreach($deprow as $data)
					echo "<option value='{$data['DEP_CODE']}'>{$data['DEP_NAME']}</option>";
				printf("
							</select><br /><br />\n
						
						From Start Date:
							<input type='date' name='start' value=''><br /><br />\n

						To End Date:
							<input type='date' name='end' value=''><br /><br />\n

						<input type='submit' name='submit' value='Submit'>

					</form>

				");
			}
        ?>

    </body>

</html>
