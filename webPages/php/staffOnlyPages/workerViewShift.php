<html>

    <head>

        <title>View Shift</title>
		<?php 
			#Starting a session and initilizing variables needed
			session_start(); 
			$userType = $_SESSION['userType'];
			//$sID = $_SESSION['staffID'];
		?>
		<?php include "../includes/scripts/headLinks2.0.php"; ?>

    </head>

    <body>

        <?php
		
			//level of authorization required to access page
			$authLevel = "W";
			
			#to verify the user 
			include "../includes/functions/verLogin.php";
			verLogin();
			
			#test!!!!!!!!!!!!!!!!!!!!!!!1
			#print($authLevel);
			
			#to verify the users type
			include "../includes/functions/valUserType.php";
			valUserType($authLevel);
			
			$sID = 
			
		
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
				if(isset($_POST['super']))
					$super = 1;
				else
					$super = 0;
				$notes = $_POST['notes'];
				
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

				$sql = $conn->prepare("UPDATE SHIFT SET STATUS_CODE = '$status', DEP_CODE = '$dep', CLIENT_ID = '$client', STAFF_ID = '$staff', SHIFT_DATE = '$date', SCHEDULED_START = '$schStart', SCHEDULED_END = '$schEnd',
				CLAIMED_START = '$claStart', CLAIMED_END = '$claEnd', APPROVED_START = '$appStart', APPROVED_END = '$appEnd', SHIFT_SUPER = '$super', SHIFT_NOTES = '$notes'
				WHERE SHIFT_ID = '$id'");
				
				$sql->execute();
				
				//echo implode(":",$sql->errorInfo()) . "<br>";
				
				echo "record updated successfully.<br /><br />";
			}
			else
			{
				$id = $_REQUEST['id'];
				$sID = $_SESSION['staffID'];
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
				WHERE SHIFT_ID = '$id'
				AND SHIFT.STAFF_ID = '$sID'
				");
				//
				//AND SHIFT.STAFF_ID = '$sID'
					
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
				
				include "../includes/scripts/navBar.php";
				
				printf("

					<h1>View a Shift</h1>

					<form method='post' action='modshift.php'>

						Client: " . $row['CLIENT_FNAME'] . " " . $row['CLIENT_LNAME'] . "<br /><br />\n
				");

				printf("
						Department: " . $row['DEP_NAME'] . "<br /><br />\n
				");

				printf("	
						Shift Status: " . $row['STATUS_NAME'] . "<br /><br />\n
				");

				
				//Translating the date into something more easily readable
				$dateArray = explode("-", $row['SHIFT_DATE']);
				
				$year = $dateArray[0];
				$month = $dateArray[1];
				$day = $dateArray[2];
				
				//Converting numeric month to text
				switch($month)
				{
					case "01":
						$month = "Jan";
					break;
					
					case "02":
						$month = "Feb";
					break;
					
					case "03":
						$month = "Mar";
					break;
					
					case "04":
						$month = "Apr";
					break;
					
					case "05":
						$month = "May";
					break;
					
					case "06":
						$month = "Jun";
					break;
					
					case "07":
						$month = "Jul";
					break;
					
					case "08":
						$month = "Aug";
					break;
					
					case "09":
						$month = "Sep";
					break;
					
					case "10":
						$month = "Oct";
					break;
					
					case "11":
						$month = "Nov";
					break;
					
					case "12":
						$month = "Dec";
					break;
					
					default:
						echo "Invalid month.";
					break;
				}
				
				//more readable date string
				$date = $month . ", " . $day . " " . $year;
				

				printf("
						Shift Date: " . $date . "<br /><br />\n
							
				");
				
				//Translating from 24 to 12hr time
				$start = $row['SCHEDULED_START'];
				$end = $row['SCHEDULED_END'];
		
				
				$startArray = explode(":", $start);
				$endArray = explode(":", $end);
				
				
				$hour = "";
				$endHour = "";
				
				//Converting shift start time to 12hr format
				if( ($startArray[0] < 12) && ($startArray[0] != 0) )
				{
					//Removing the leading zero 
					$startHour = $startArray[0];
					$startHour = intVal($startHour, 10);
					$start = $startHour . ":" . $startArray[1] . "AM";
				}
				else if($startArray[0] == 12)
				{
					$start = $startArray[0] . ":" . $startArray[1] . "PM";
				}
				else if($startArray[0] > 12)
				{
					$hour = $startArray[0] - 12;
					$start = $hour . ":" . $startArray[1] . "PM";
				}
				else if($startArray[0] == 0)
				{
					$hour = 12;
					$start = $hour . ":" . $startArray[1] . "AM";
				}
				
				//Converting shift end time to 12hr format
				if( ($endArray[0] < 12) && ($endArray[0] != 0) )
				{
					//Removing the leading zero
					$endHour = $endArray[0];
					$endHour = intVal($endHour, 10);
					$end = $endHour . ":" . $endArray[1] . "AM";
				}
				else if($endArray[0] == 12)
				{
					$end = $endArray[0] . ":" . $endArray[1] . "PM";
				}
				else if($endArray[0] > 12)
				{
					$endHour = $endArray[0] - 12;
					$end = $endHour . ":" . $endArray[1] . "PM";
				}
				else if($endArray[0] == 0)
				{
					$endHour = 12;
					$end = $endHour . ":" . $endArray[1] . "AM";
				}
				
				printf("
						<p>Hours: " . $start . "-" . $end . "</p>\n		

						
				");
				
				if($row['SHIFT_SUPER'] == 1)
					echo "<p>Supervisor: Yes</p>";
				else
					echo "<p>Supervisor: No</p>";
				printf("
				
						Notes: " . $row['SHIFT_NOTES'] . "<br /><br />

					</form>

				");
				
				include "../includes/scripts/footer.php";
			}
        ?>

    </body>

</html>