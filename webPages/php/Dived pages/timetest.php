<?php
/*  Developer:   Justin Alho, Evan Guest
 *  File Name:   timesheet.php
 *  Description: Allows staff to review and submit their hours
 *  Date Start:  08/03/2020
 *  Date End:    TBD
 *  TODO:    	 - Get last pay period instead of current pay period
 */?>
<html>

    <head>

        <title>Submit Timesheet</title>
		<?php
			//Starting a session and initializing variables needed
			session_start(); 
			$userType = $_SESSION['userType'];
		
			//include links to css, javascript, etc.
			include "../includes/scripts/headLinks2.0.php";?>
			
		<script>
			//this function changes the status of the submit button when the confirmation checkbox is clicked
			function verify()
			{
			  //if checkbox is checked, set submit button enabled
			  if (document.getElementById('ver').checked) 
			  {
				  document.getElementById('sub').disabled = false;
			  }
			  //if checkbox is unchecked, set submit button disabled
			  else {
				  document.getElementById('sub').disabled = true;
			  }
			}
			
		</script>
		</script>

    </head>

    <body>

        <?php
		
		//level of authorization required to access page
		$authLevel = "W";
		
		//to verify the user 
		include "../includes/functions/verLogin.php";
		verLogin();
		
		//to verify the user's type
		include "../includes/functions/valUserType.php";
		valUserType($authLevel);
		
	//connect to the database
	$username = 'Coordinator';
	$password = 'Password1';
	$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
	
	//set ID variable to session variable
	$id = $_SESSION['staffID'];
	
	//gets the number of days in the month
	$days = date('t');

	//if today's date is before or equal to the 15th, set min to 1 and max to 15
	if(date('d') <= 15)
	{
		$max = 15;
		$maxdate = date('Y-m-') . '15';
		$min = 1;
		$mindate = date('Y-m-') . '01';
	}
	//if the date is after the 15th, set max to $days and min to 16
	else
	{
		$max = $days;
		$maxdate  = date('Y-m-t');
		$min = 16;
		$mindate = date('Y-m-') . '16';
	}
	
	//if the form has been submitted
	if(isset($_POST['submit']))
	{
		//for each submitted time
		foreach($_POST as $index=>$value)
		{
			//if this item is not the value passed by the submit button
			if($index != 'submit')
			{
				//split index into the shift ID and whether it is a start or end time
				$arr = explode('-', $index);
				$shiftId = $arr[0];
				$stEnd = $arr[1];
				
				//if it is a start time
				if($stEnd == 'St')
				{
					//update claimed start time in database and set shift to claimed
					$addSql = $conn->prepare("UPDATE SHIFT SET CLAIMED_START = '$value', STATUS_CODE = 'C' WHERE SHIFT_ID = '$shiftId'");
					$addSql->execute();
				}
				//if it is an end time
				else
				{
					//update claimed end time in database and set shift to claimed
					$addSql = $conn->prepare("UPDATE SHIFT SET CLAIMED_END = '$value', STATUS_CODE = 'C' WHERE SHIFT_ID = '$shiftId'");
					$addSql->execute();
				}
			}
		}
		//when hours have been submitted, send user back to this page with a success message
		header ("Location: timesheet.php?s=1");
	}
	
	//include navbar
	include "../includes/scripts/navBar.php";
	
	//select basic information about shifts, ordered first by client, then by date,
	//then by start time in case somehow the same staff is scheduled with the same client multiple times in one day
	$sql = $conn->prepare("SELECT SHIFT_ID, SHIFT_DATE, SCHEDULED_START, SCHEDULED_END, SHIFT_DATE, SHIFT.CLIENT_ID, CLIENT_LNAME, CLIENT_FNAME
				FROM SHIFT
				LEFT JOIN CLIENT
				ON SHIFT.CLIENT_ID = CLIENT.CLIENT_ID
				WHERE SHIFT_DATE > '$mindate'
				AND SHIFT_DATE < '$maxdate'
				AND STAFF_ID = '$id'
				AND STATUS_CODE = 'S'
				ORDER BY CLIENT_LNAME ASC, SHIFT_DATE ASC, SCHEDULED_START ASC");

	$sql->execute();

	$row = $sql->fetchAll();

	//echo implode(":",$sql->errorInfo());

	//gets the number of days in the month
	$days = date('t');

	echo "<html>";
	echo "<body>";

	//if timesheet submitted successfully, display success message
	if(isset($_REQUEST['s']))
		echo "Your hours have been submitted.<br /><br />";

	//if there are no shifts, don't show any shifts
	if(sizeof($row) == 0)
	{
		echo "You have no unsubmitted hours.<br /><br />";
		echo "<a href='../land.php' class='btn btn-secondary'>Back</a>";
		include "../includes/scripts/footer.php";
	}
	//if there are shifts to claim
	else
	{
		
		//set up the table, inside a form
		
		echo "<form action='timesheet.php' method='post'>
				<table border='1'>
				<tr>
				<th>Individual Served</th>
				<th>Specifics</th>";
		
		$min = 0;
		$max = 0;
		//if the date is before the 15th, print the first half of the month
		if(date('d') <= 15)
		{
			for($i = 1; $i <= 15; $i++)
			{
				echo "<th>$i</th>";
			}
			$max = 15;
			$min = 1;
		}
		//if the date is after the 15th, print the second half of the month
		else
		{
			for($i = 16; $i <= $days; $i++)
			{
				echo "<th>$i</th>";
			}
			$max = $days;
			$min = 16;
		}
		echo "</tr>";

		$lastcli = '';	//lastcli keeps track of the last client that had shifts printed
		$tempmin = 0;	//tempmin keeps track of the earliest date for the timesheet
		$i = 0;			//i is used to iterate through records
		while ($i < sizeof($row))
		{
			//if the record is for a different client than the last record
			if($lastcli != $row[$i]['CLIENT_ID'])
			{
				$tempmin = $min;
				
				//set up the row
				echo "<tr>";
				echo "<td><b>Last:</b> {$row[$i]['CLIENT_LNAME']}</td>";
				echo "<td>Start Time:</td>";
				
				$j = $i;
				//starting with the current record, until the client is different
				do
				{
					//set the date for the shift
					$date = strtotime($row[$j]['SHIFT_DATE']);
					//until the shift date, fill the timesheet with blank table data
					while($tempmin < date('d', $date))
					{
						echo "<td></td>";
						$tempmin++;
					}
					//once the date is reached, print the start time
					$shiftId = $row[$j]['SHIFT_ID'] . '-St';
					echo "<td><input type='time' name='$shiftId' value='{$row[$j]['SCHEDULED_START']}' /></td>";
					$tempmin++;
					
					$j++;
					//if the next record is the last one, break out of the loop
					if($j >= sizeof($row))
						break;
				} while ($row[$j]['CLIENT_ID'] == $row[$j-1]['CLIENT_ID']);
				
				//fill the timesheet with blank table data until the end of the table
				while($tempmin <= $max)
				{
					echo "<td></td>";
					$tempmin++;
				}
				//when all of the start times for that client are filled in, end the row 
				echo "</tr>";
				
				//reset tempmin, set up the next row
				$tempmin = $min;
				echo "<tr>";
				echo "<td><b>First:</b> {$row[$i]['CLIENT_FNAME']}</td>";
				echo "<td>End Time:</td>";
				
				$j = $i;
				//this loop is the same as the start time, except it prints the end time
				do
				{
					$date = strtotime($row[$j]['SHIFT_DATE']);
					while($tempmin < date('d', $date))
					{
						echo "<td></td>";
						$tempmin++;
					}
					$shiftId = $row[$j]['SHIFT_ID'] . '-End';
					echo "<td><input type='time' name='$shiftId' value='{$row[$j]['SCHEDULED_END']}' /></td>";
					$tempmin++;
					
					$j++;
					if($j >= sizeof($row))
						break;
				} while ($row[$j]['CLIENT_ID'] == $row[$j-1]['CLIENT_ID']);
				while($tempmin <= $max)
				{
					echo "<td></td>";
					$tempmin++;
				}
				echo "</tr>";
				
				//set the last client as lastcli, so that their shifts won't be displayed again
				$lastcli = $row[$i]['CLIENT_ID'];
			}
			
			//increment i to get the next record
			$i++;
		}
		
		//end the table
		echo "</table><br /><br />\n
			By checking this box, I certify that this timesheet is complete and accurately reflects my time and effort:
			<!--this checkbox has to be checked before timesheet can be submitted-->
			<input id='ver' type='checkbox' name='ver' onclick='verify()'><br /><br />
			<input id='sub' type='submit' name='submit' value='Submit Timesheet' disabled='true'>
		</form><br />
		
		<a href='../land.php' class='btn btn-danger'>Cancel</a>";
					
		//releasing database resources
		if(isset($conn) )
		{
			$conn = null;
		}
		
		//include footer
		include "../includes/scripts/footer.php";
	}
	?>
	</body>
</html>


