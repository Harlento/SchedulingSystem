<html>

    <head>

        <title>View Department Information</title>

    </head>

    <body>

        <?php
			$username = 'Coordinator';
			$password = 'Password1';
			$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
					
			$sql = $conn->prepare("SELECT * FROM DEPARTMENT");
				
			$sql->execute();
			
			$row = $sql->fetchAll();
			
			echo
			"<table border='1'>
				<tr>
					<th>Department Code</th>
					<th>Department</th>
					<th>Department Description</th>
				</tr>
			";
			
			foreach ($row as $data)
			{
				echo "<tr>";
				echo "<td>{$data['DEP_CODE']}</td>";
				echo "<td>{$data['DEP_NAME']}</td>";
				echo "<td>{$data['DEP_DESC']}</td>";
				echo "<td><a href='moddep.php?code={$data['DEP_CODE']}'>modify</a></td>";
				echo "</tr>";
			}
				
			echo "</table><br />\n";
		?>
	
	</body>
</html>