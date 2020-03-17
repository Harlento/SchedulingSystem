<?php
echo'
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
            <title>Add New Staff Member</title>
    <link href="css/bootstrap.css" rel="stylesheet" type="text/css">
    <link href="css/table.css" rel="stylesheet" type="text/css">

</head>
<body>';
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


		



			include "../includes/functions/isSpecial.php";
			include "../includes/functions/isComplex.php";
			
			//level of authorization required to access page
			$authLevel = "C";
			
			#to verify the user 
			include "../includes/functions/verLogin.php";
			verLogin();
			
			#test!!!!!!!!!!!!!!!!!!!!!!!1
			#print($authLevel);
			
			#to verify the users type
			include "../includes/functions/valUserType.php";
			valUserType($authLevel);
			
			$username = 'Coordinator';
			$password = 'Password1';
			$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
			
			$type = '';
			$uname = '';
			$pass1 = '';
			$pass2 = '';
			$fname = '';
			$lname = '';
			$phone = '';
			$address = '';
			$city = '';
			$child = '';
			$pc = '';
			$drive = '';
			$sunAvail = '';
			$monAvail = '';
			$tueAvail = '';
			$wedAvail = '';
			$sunAvail = '';
			$sunAvail = '';
			$sunAvail = '';
			$notes = '';
			
			$typerr = '';
			$unerr = '';
			$paserr = '';
			$fnerr = '';
			$lnerr = '';
		
			if(isset($_POST['submit']))
			{	
				$err = 0;
				$type = $_POST['type'];
				$uname = $_POST['uname'];
				$pass1 = $_POST['pass1'];
				$pass2 = $_POST['pass2'];
				$fname = $_POST['fname'];
				$lname = $_POST['lname'];
				$phone = $_POST['phone'];
				$address = $_POST['address'];
				$city = $_POST['city'];
				if(isset($_POST['child']))
					$child = 1;
				else
					$child = 0;
				if(isset($_POST['pc']))
					$pc = 1;
				else
					$pc = 0;
				if(isset($_POST['drive']))
					$drive = 1;
				else
					$drive = 0;
				$sunSt = $_POST['sunSt'];
				$sunEnd = $_POST['sunEnd'];
				$sunAvail = $sunSt . " - " . $sunEnd;
				$monSt = $_POST['monSt'];
				$monEnd = $_POST['monEnd'];
				$monAvail = $monSt . " - " . $monEnd;
				$tueSt = $_POST['tueSt'];
				$tueEnd = $_POST['tueEnd'];
				$tueAvail = $tueSt . " - " . $tueEnd;
				$wedSt = $_POST['wedSt'];
				$wedEnd = $_POST['wedEnd'];
				$wedAvail = $wedSt . " - " . $wedEnd;
				$thuSt = $_POST['thuSt'];
				$thuEnd = $_POST['thuEnd'];
				$thuAvail = $thuSt . " - " . $thuEnd;
				$friSt = $_POST['friSt'];
				$friEnd = $_POST['friEnd'];
				$friAvail = $friSt . " - " . $friEnd;
				$satSt = $_POST['satSt'];
				$satEnd = $_POST['satEnd'];
				$satAvail = $satSt . " - " . $satEnd;
				$notes = $_POST['notes'];
				
				
				
				if($type == '')
				{
					$typerr = 'Please specify a user type.';
					$err++;
				}
				if($uname == '')
				{
					$unerr = 'Please enter a username.';
					$err++;
				}
				if($pass1 == '')
				{
					$paserr = 'Please enter a password.';
					$err++;
				}
				else if($pass1 != $pass2)
				{
					$paserr = 'The passwords did not match.';
					$err++;
				}
				else if(!isComplex($pass2))
				{
					$paserr = "Password is not complex enough.";
					$err++;
				}
				if($fname == '')
				{
					$fnerr = 'Please enter a first name.';
					$err++;
				}
				if($lname == '')
				{
					$lnerr = 'Please enter a last name.';
					$err++;
				}
				
				if($err == 0)
				{
					//test
					//print($err);
					$pass = password_hash($pass, PASSWORD_BCRYPT);
					
					$sql = $conn->prepare("INSERT INTO STAFF (TYPE_CODE, USER_NAME, USER_PASS, STAFF_FNAME, STAFF_LNAME, STAFF_PHONE, STAFF_ADDRESS, STAFF_CITY, CAN_CHILD, CAN_PC, CAN_DRIVE, SUN_AVAIL, MON_AVAIL, TUE_AVAIL, WED_AVAIL, THU_AVAIL, FRI_AVAIL, SAT_AVAIL, STAFF_NOTES)
					VALUES ('$type', '$uname', '$pass1', '$fname', '$lname', '$phone', '$address', '$city', '$child', '$pc', '$drive', '$sunAvail', '$monAvail', '$tueAvail', '$wedAvail', '$thuAvail', '$friAvail', '$satAvail', '$notes')");
					
					$sql->execute();
					
					//echo implode(":",$sql->errorInfo());
					
					echo "record added successfully.<br /><br />";
					header ("Location: addstaff.php?p=1");
				}
			}
			
			$sql = $conn->prepare("SELECT * FROM user_type");
				
			$sql->execute();
			
			$row = $sql->fetchAll();
			
			
			

			printf("
				<div class='container'>
				");
				
			//test	
			//print_r($row);
			if(isset($_REQUEST['p']))
				echo "Staff member added successfully.<br /><br />";
			
			printf("
				<h1>Add New Staff Member</h1>

				<form method='post' action='addstaff.php'>

					First Name:
						<input class='form-fan' type='text' name='fname' value='$fname'>$fnerr
					Last Name:
						<input class='form-fan' type='text' name='lname' value='$lname'>$lnerr<br /><br />\n

					Full Address:
						<input class='form-fan' type='text' name='address' value='$address'>
					City:
						<input class='form-fan' type='text' name='city' value='$city'><br /><br />\n

					Primary Phone Number:
						<input class='form-fan' type='text' name='phone' value='$phone'><br /><br />\n

					User Type:
						<select class='fanc' name='type'>
							<option value=''>Select one:</option>
			");
			foreach($row as $data)
				echo "<option value='{$data['TYPE_CODE']}'>{$data['TYPE_NAME']}</option>";
			printf("
						</select>$typerr<br /><br />\n

					User Name:
						<input class='form-fan' type='text' name='uname' value='$uname'>$unerr<br /><br />
					Password:<br /><br />
						Enter password: <input class='form-fan' type='password' name='pass1' value='$pass1'>$paserr<br /><br />
						Confirm password: <input class='form-fan' type='password' name='pass2' value=''><br /><br />
						Passwords need to be at least 8 characters long and include a number,<br />
						a lowercase letter, an uppercase letter, and a special character.<br /><br />

					Availability: <br /><br />
						Sunday:
							Start:
								<input class='form-fan' type='time' name='sunSt' value='$sunSt'>
							End:
								<input class='form-fan' type='time' name='sunEnd' value='$sunEnd'><br /><br />
						Monday:
							Start:
								<input class='form-fan' type='time' name='monSt' value='$monSt'>
							End:
								<input class='form-fan' type='time' name='monEnd' value='$monEnd'><br /><br />

						Tuesday:
							Start:
								<input class='form-fan' type='time' name='tueSt' value='$tueSt'>
							End:
								<input class='form-fan' type='time' name='tueEnd' value='$tueEnd'><br /><br />

						 Wednesday:
							Start:
								<input class='form-fan' type='time' name='wedSt' value='$wedSt'>
							End:
								<input class='form-fan' type='time' name='wedEnd' value='$wedEnd'><br /><br />

						 Thursday:
							Start:
								<input class='form-fan' type='time' name='thuSt' value='$thuSt'>
							End:
								<input class='form-fan' type='time' name='thuEnd' value='$thuEnd'><br /><br />

						 Friday:
							Start:
								<input class='form-fan' type='time' name='friSt' value='$friSt'>
							End:
								<input class='form-fan' type='time' name='friEnd' value='$friEnd'><br /><br />

						 Saturday:
							Start:
								<input class='form-fan' type='time' name='satSt' value='$satSt'>
							End:
								<input class='form-fan' type='time' name='satEnd' value='$satEnd'><br /><br />

						Able to Drive:");
			if(isset($_POST['drive']))
				echo "<input class='form-fan' type='checkbox' name='drive' checked><br /><br />";
			else
				echo "<input class='form-fan' type='checkbox' name='drive'><br /><br />";
			printf("
						
					Notes:
						<textarea name='notes'>$notes</textarea><br /><br />

						Can Provide Personal Care:");
			if(isset($_POST['pc']))
				echo "<input class='form-fan' type='checkbox' name='pc' checked><br /><br />";
			else
				echo "<input class='form-fan' type='checkbox' name='pc'><br /><br />";
			printf("

						Can work with Children:");
			if(isset($_POST['child']))
				echo "<input class='form-fan' type='checkbox' name='child' checked><br /><br />";
			else
				echo "<input class='form-fan' type='checkbox' name='child'><br /><br />";
			printf("

					<input class='form-fan' type='submit' name='submit' value='Submit'>

				</form>
				
				</div>

			");
			
			//Releasing database resources
			if(isset($conn) )
			{
				$conn = null;
			}
			
			
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