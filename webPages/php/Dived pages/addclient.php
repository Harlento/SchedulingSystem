<?php
echo'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
	        <title>Add New Client</title>
    <title>Table</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/table.css" rel="stylesheet" type="text/css">

</head>
<body>
';
		
			#Starting a session and initilizing variables needed
			session_start(); 
			$userType = $_SESSION['userType'];
		
		
		 include "../includes/scripts/headLinks2.0.php";
		include "../includes/scripts/navBar.php";
		 echo'
<div class="row justify-content-center">
<form class="form-con">
    <form>
';



		
			//level of authorization required to access page
			$authLevel = "C";
		
			#to verify the user 
			include "../includes/functions/verLogin.php";
			verLogin();
			
			#to verify the users type
			include "../includes/functions/valUserType.php";
			valUserType($authLevel);
			
			
			$gh = '';
			$fname = '';
			$lname = '';
			$phone = '';
			$address = '';
			$city = '';
			$hours = 0;
			$km = 0;
			$notes = '';
			
			$gherr = '';
			$fnamerr = '';
			$lnamerr = '';
			
			$username = 'Coordinator';
			$password = 'Password1';
			$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
		
			if(isset($_POST['submit']))
			{	
				$err = 0;
				$gh = $_POST['gh'];
				$fname = $_POST['fname'];
				$lname = $_POST['lname'];
				$phone = $_POST['phone'];
				$address = $_POST['address'];
				$city = $_POST['city'];
				$hours = $_POST['hours'];
				$km = $_POST['km'];
				$notes = $_POST['notes'];
				
				if($gh == '')
				{
					$gherr = 'Please select a group home or N/A';
					$err++;
				}
				if($fname == '')
				{
					$fnamerr = 'Please enter a first name.';
					$err++;
				}
				if($lname == '')
				{
					$lnamerr = 'Please enter a last name.';
					$err++;
				}
				
				if($err == 0)
				{
					$addsql = $conn->prepare("INSERT INTO CLIENT (GH_ID, CLIENT_FNAME, CLIENT_LNAME, CLIENT_PHONE, CLIENT_ADDRESS, CLIENT_CITY, CLIENT_MAX_HOURS, CLIENT_KM, CLIENT_NOTES)
					VALUES ('$gh', '$fname', '$lname', '$phone', '$address', '$city', '$hours', '$km', '$notes')");
					
					$addsql->execute();
					
					//echo implode(":",$addsql->errorInfo());
					
					header('Location: addclient.php?s=1');
				}
			}
			
			$sql = $conn->prepare("SELECT * FROM group_home");
				
			$sql->execute();
			
			$row = $sql->fetchAll();
			
			
			if(isset($_REQUEST['s']))
				echo "Record added successfully.<br /><br />";
			
			printf("

				<h1>Add New Client</h1>

				<form method='post' action='addclient.php'>

				First Name:
					<input class='form-fan' type='text' name='fname' value='$fname'>$fnamerr
				Last Name:
					<input class='form-fan' type='text' name='lname' value='$lname'>$lnamerr<br /><br />\n
				Full Address:
					<input class='form-fan' type='text' name='address' value='$address'>
				City:
					<input class='form-fan' type='text' name='city' value='$city'><br /><br />\n
				Phone Number:
					<input class='form-fan' type='text' name='phone' value='$phone'><br /><br />\n
				Group Home:
					<select class='fanc' name='gh'>
						<option value=''>Select a Group Home:</option>");
			foreach($row as $data)
				echo "<option value='{$data['GH_ID']}'>{$data['GH_NAME']}</option>";
			printf("
					</select>$gherr<br /><br />
				Hours Per Month:
					<input class='form-fan' type='text' name='hours' value='$hours'><br /><br /><br />\n
				Distance (in kilometers):
					<input class='form-fan' type='text' name='km' value='$km'><br /><br /><br />\n
				Notes:<br />
					<textarea name='notes' rows='4' cols='40'>$notes</textarea><br /><br />\n

					<input class='form-fan' type='submit' name='submit' value='Submit'>

				</form>

			");
			
			
			
echo'
            

    </form>
</form>
</div>';
	include "../includes/scripts/footer.php";
	echo'
</body>
</html>
    ';
	?>
	