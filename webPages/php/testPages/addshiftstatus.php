<?php

$code = "";
$name = "";

echo
"<html>
<head>
</head>
<body>";

if(isset($_REQUEST['submit']))
{	
	$code=$_REQUEST['code'];
	$name=$_REQUEST['name'];
	
	$username = 'Coordinator';
	$password = 'Password1';
	$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

	
	$sql = $conn->prepare("INSERT INTO SHIFT_STATUS VALUES ('$code', '$name')");
	
	$sql->execute();
	
	echo "record added successfully.<br /><br />";
}

else
{
	echo
	"<form method='post' action='addshiftstatus.php'>
		Code: <input type='text' name='code' /><br /><br />
		Name: <input type='text' name='name' /><br /><br />
		<input type='submit' name='submit' value='add' /><br />
	</form>";
}
echo
"	
	<a href='viewshiftstatus.php'><button>Back to Home</button></a>
	
</body>
</html>";

?>