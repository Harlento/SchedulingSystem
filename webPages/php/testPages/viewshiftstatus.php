<?php

	echo
	"<html>
	<head>
	</head>
	<body>";
	$username = 'Coordinator';
	$password = 'Password1';
	$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
			
	$sql = $conn->prepare("SELECT * FROM shift_status");
		
	$sql->execute();
	
	$row = $sql->fetchAll();
	
	echo
	"<table border='1'>
		<tr>
			<th>Status Code</th>
			<th>Status Name</th>
		</tr>
	";
	
	foreach ($row as $data)
	{
		echo "<tr>";
		echo "<td>{$data['STATUS_CODE']}</td>";
		echo "<td><a href='modshiftstatus.php?code={$data['STATUS_CODE']}&name={$data['STATUS_NAME']}'>{$data['STATUS_NAME']}</a></td>";
		echo "</tr>";
	}
		
	echo "</table><br />\n";
		
	echo
	"</body>
	</html>";

?>