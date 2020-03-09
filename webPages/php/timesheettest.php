<?php

	$username = 'Coordinator';
	$password = 'Password1';
	$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

	//select basic information about shifts, ordered first by client, then by date,
	//then by start time in case somehow the same staff is scheduled with the same client multiple times in one day
	$sql = $conn->prepare("SELECT SHIFT_ID, SHIFT_DATE, SCHEDULED_START, SCHEDULED_END, SHIFT_DATE, SHIFT.CLIENT_ID, CLIENT_LNAME, CLIENT_FNAME
				FROM SHIFT
				LEFT JOIN CLIENT
				ON SHIFT.CLIENT_ID = CLIENT.CLIENT_ID
				WHERE SHIFT_DATE > '2020-03-01'
				AND SHIFT_DATE < '2020-03-15'
				AND STAFF_ID = '4'
				AND STATUS_CODE = 'S'
				ORDER BY CLIENT_LNAME ASC, SHIFT_DATE ASC, SCHEDULED_START ASC");

	$sql->execute();

	$row = $sql->fetchAll();

	//echo implode(":",$sql->errorInfo());

	//gets the number of days in the month
	$days = date('t');

	echo "<html>";
	echo "<body>";

	//set up the table
	echo "<table border='1'>
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
	
	//if there are no shifts, don't show any shifts
	if(sizeof($row) == 0)
	{
		echo "You have no unsubmitted hours.";
	}
	else
	{
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
				echo "<td>Last: {$row[$i]['CLIENT_LNAME']}</td>";
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
					echo "<td>{$row[$j]['SCHEDULED_START']}</td>";
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
				echo "<td>First: {$row[$i]['CLIENT_FNAME']}</td>";
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
					echo "<td>{$row[$j]['SCHEDULED_END']}</td>";
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
			
			$i++;
		}
	}
	
	//end the table
	echo "</table><br />\n";
	echo "</body>";
	echo "</html>";

?>
