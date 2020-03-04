/*  Developer:   Justin Alho
 *  File Name:   viewclient.php
 *  Description: Allows coordinators to view client information
 *  Date Start:  25/02/2020
 *  Date End:    TBD
 *  TODO:        - Add CSS
 *		 - Add user authentication
 *		 - Add sorting, filtering
 */
<html>

    <head>

        <title>View Client Information</title>

    </head>

    <body>

        <?php
	    		//Retrieve client, group home, and status information and display it in a table
			$username = 'Coordinator';
			$password = 'Password1';
			$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
					
			$sql = $conn->prepare("SELECT CLIENT_ID, C_S_STATUS_NAME, GH_NAME, CLIENT_FNAME, CLIENT_LNAME, CLIENT_PHONE, CLIENT_ADDRESS, CLIENT_CITY, CLIENT_MAX_HOURS, CLIENT_KM, CLIENT_NOTES
			FROM CLIENT
			LEFT JOIN C_S_STATUS
			ON CLIENT.CLIENT_STATUS = C_S_STATUS.C_S_STATUS_CODE
			LEFT JOIN GROUP_HOME
			ON CLIENT.GH_ID = GROUP_HOME.GH_ID
			ORDER BY CLIENT_LNAME");
				
			$sql->execute();
			
			$row = $sql->fetchAll();
			
			echo
			"<table border='1'>
				<tr>
					<th>Client</th>
					<th>Status</th>
					<th>Group Home</th>
					<th>Phone Number</th>
					<th>Address</th>
					<th>City</th>
					<th>Max Hours per Month</th>
					<th>Distance (km)</th>
					<th>Notes</th>
				</tr>
			";
			
			foreach ($row as $data)
			{	
				echo "<tr>";
				echo "<td>{$data['CLIENT_LNAME']}, {$data['CLIENT_FNAME']}</td>";
				echo "<td>{$data['C_S_STATUS_NAME']}</td>";
				echo "<td>{$data['GH_NAME']}</td>";
				echo "<td>{$data['CLIENT_PHONE']}</td>";
				echo "<td>{$data['CLIENT_ADDRESS']}</td>";
				echo "<td>{$data['CLIENT_CITY']}</td>";
				echo "<td>{$data['CLIENT_MAX_HOURS']}</td>";
				echo "<td>{$data['CLIENT_KM']}</td>";
				echo "<td>{$data['CLIENT_NOTES']}</td>";
				echo "<td><a href='modclient.php?id={$data['CLIENT_ID']}'>modify</a></td>";
				echo "</tr>";
			}
				
			echo "</table><br />\n";
		?>
	
	</body>
</html>
