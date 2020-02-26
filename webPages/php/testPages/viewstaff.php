<html>

    <head>

        <title>View Staff Information</title>

    </head>

    <body>

        <?php
			$username = 'Coordinator';
			$password = 'Password1';
			$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
					
			$sql = $conn->prepare("SELECT STAFF_ID, C_S_STATUS_NAME, TYPE_NAME, USER_NAME, STAFF_FNAME, STAFF_LNAME, STAFF_PHONE, STAFF_ADDRESS, STAFF_CITY, CAN_CHILD, CAN_PC, CAN_DRIVE, STAFF_NOTES
			FROM STAFF
			LEFT JOIN C_S_STATUS
			ON STAFF.STAFF_STATUS = C_S_STATUS.C_S_STATUS_CODE
			LEFT JOIN USER_TYPE
			ON STAFF.TYPE_CODE = USER_TYPE.TYPE_CODE
			ORDER BY STAFF_LNAME");
				
			$sql->execute();
			
			$row = $sql->fetchAll();
			
			echo
			"<table border='1'>
				<tr>
					<th>Staff</th>
					<th>Status</th>
					<th>Staff Type</th>
					<th>Username</th>
					<th>Phone Number</th>
					<th>Address</th>
					<th>City</th>
					<th>Can Work with Children</th>
					<th>Can Provide Personal Care</th>
					<th>Can Drive</th>
					<th>Notes</th>
				</tr>
			";
			
			foreach ($row as $data)
			{	
				echo "<tr>";
				echo "<td>{$data['STAFF_LNAME']}, {$data['STAFF_FNAME']}</td>";
				echo "<td>{$data['C_S_STATUS_NAME']}</td>";
				echo "<td>{$data['TYPE_NAME']}</td>";
				echo "<td>{$data['USER_NAME']}</td>";
				echo "<td>{$data['STAFF_PHONE']}</td>";
				echo "<td>{$data['STAFF_ADDRESS']}</td>";
				echo "<td>{$data['STAFF_CITY']}</td>";
				if($data['CAN_CHILD'] == 1)
					echo "<td>Yes</td>";
				else
					echo "<td>No</td>";
				if($data['CAN_PC'] == 1)
					echo "<td>Yes</td>";
				else
					echo "<td>No</td>";
				if($data['CAN_DRIVE'] == 1)
					echo "<td>Yes</td>";
				else
					echo "<td>No</td>";
				echo "<td>{$data['STAFF_NOTES']}</td>";
				echo "<td><a href='modstaff.php?id={$data['STAFF_ID']}'>modify</a></td>";
				echo "</tr>";
			}
				
			echo "</table><br />\n";
		?>
	
	</body>
</html>