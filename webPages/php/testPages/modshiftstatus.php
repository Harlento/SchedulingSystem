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

	
	$sql = $conn->prepare("UPDATE shift_status set STATUS_NAME='$name' where STATUS_CODE='$code'");
	
	$sql->execute();
	
	echo "record changed successfully.<br /><br />";
}

else if (isset($_REQUEST['code']))
{
	$code=$_REQUEST['code'];
	
	$username = 'Coordinator';
	$password = 'Password1';
	$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
	
	$sql = $conn->prepare("SELECT * FROM shift_status where STATUS_CODE='$code'");
		
	$sql->execute();

	$row = $sql->fetch();

	echo
	"<form method='post' action='modshiftstatus.php'>
		Code: <input type='text' name='code' value='$code' /><br /><br />
		Name: <input type='text' name='name' value='{$row['STATUS_NAME']}' /><br /><br />
		<input type='submit' name='submit' value='change' /><br />
	</form>";
}
echo
"	
	<a href='viewshiftstatus.php'><button>Back to Home</button></a>
	
</body>
</html>";

?>