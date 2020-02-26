<html>

    <head>

        <title>View Shift Information</title>

    </head>

    <body>

        <?php
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
				</tr>
			";
			
			foreach ($row as $data)
			{	
				echo "<tr>";
				echo "<td>{$data['CLIENT_LNAME']}, {$data['CLIENT_FNAME']}</td>";
				echo "<td>{$data['STAFF_LNAME']}, {$data['STAFF_FNAME']}</td>";
				echo "<td>{$data['DEP_NAME']}</td>";
				echo "<td>{$data['SHIFT_DATE']}</td>";
				echo "<td>{$data['STATUS_NAME']}</td>";
				echo "<td>{$data['SCHEDULED_START']} - {$data['SCHEDULED_END']}</td>";
				echo "<td>{$data['CLAIMED_START']} - {$data['CLAIMED_END']}</td>";
				echo "<td>{$data['APPROVED_START']} - {$data['APPROVED_END']}</td>";
				if($data['SHIFT_SUPER'] == 1)
					echo "<td>Yes</td>";
				else
					echo "<td>No</td>";
				echo "<td>{$data['SHIFT_NOTES']}</td>";
				echo "<td><a href='modshift.php?id={$data['SHIFT_ID']}'>modify</a></td>";
				echo "</tr>";
			}
				
			echo "</table><br />\n";
		?>
	
	</body>
</html>