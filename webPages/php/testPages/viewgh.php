<html>

    <head>

        <title>View Group Home Information</title>

    </head>

    <body>

        <?php
			$username = 'Coordinator';
			$password = 'Password1';
			$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
					
			$sql = $conn->prepare("SELECT GH_ID, GH_NAME, STAFF_FNAME, STAFF_LNAME, GH_PHONE, GH_ADDRESS
			FROM GROUP_HOME
			LEFT JOIN STAFF
			ON GROUP_HOME.STAFF_ID = STAFF.STAFF_ID");
				
			$sql->execute();
			
			$row = $sql->fetchAll();
			
			echo
			"<table border='1'>
				<tr>
					<th>Group Home</th>
					<th>Supervisor</th>
					<th>Phone Number</th>
					<th>Address</th>
				</tr>
			";
			
			foreach ($row as $data)
			{	
				echo "<tr>";
				echo "<td>{$data['GH_NAME']}</td>";
				echo "<td>{$data['STAFF_FNAME']} {$data['STAFF_LNAME']}</td>";
				echo "<td>{$data['GH_PHONE']}</td>";
				echo "<td>{$data['GH_ADDRESS']}</td>";
				echo "<td><a href='modgh.php?id={$data['GH_ID']}'>modify</a></td>";
				echo "</tr>";
			}
				
			echo "</table><br />\n";
		?>
	
	</body>
</html>