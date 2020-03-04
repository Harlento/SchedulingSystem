/*  Developer:   Justin Alho
 *  File Name:   addstaff.php
 *  Description: Allows coordinators to add new staff records into the database
 *  Date Start:  25/02/2020
 *  Date End:    TBD
 *  TODO:        - Add CSS
 *		 - Add data verification
 *		 - Add user authentication
 *		 - Add password complexity
 */
<html>

    <head>

        <title>Add New Staff Member</title>

    </head>

    <body>

        <?php
			
			$type = '';
			$uname = '';
			$pass = '';
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
		
	    		//If data is submitted, it is added to the database
			if(isset($_POST['submit']))
			{	
				$type = $_POST['type'];
				$uname = $_POST['uname'];
				$pass = $_POST['pass'];
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
				$sunAvail = $_POST['sunSt'] . " - " . $_POST['sunEnd'];
				$monAvail = $_POST['monSt'] . " - " . $_POST['monEnd'];
				$tueAvail = $_POST['tueSt'] . " - " . $_POST['tueEnd'];
				$wedAvail = $_POST['wedSt'] . " - " . $_POST['wedEnd'];
				$thuAvail = $_POST['thuSt'] . " - " . $_POST['thuEnd'];
				$friAvail = $_POST['friSt'] . " - " . $_POST['friEnd'];
				$satAvail = $_POST['satSt'] . " - " . $_POST['satEnd'];
				$notes = $_POST['notes'];
				
				//Staff passwords are hashed before being entered into the database
				$pass = password_hash($pass, PASSWORD_BCRYPT);
				
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

				
				$sql = $conn->prepare("INSERT INTO STAFF (TYPE_CODE, USER_NAME, USER_PASS, STAFF_FNAME, STAFF_LNAME, STAFF_PHONE, STAFF_ADDRESS, STAFF_CITY, CAN_CHILD, CAN_PC, CAN_DRIVE, SUN_AVAIL, MON_AVAIL, TUE_AVAIL, WED_AVAIL, THU_AVAIL, FRI_AVAIL, SAT_AVAIL, STAFF_NOTES)
				VALUES ('$type', '$uname', '$pass', '$fname', '$lname', '$phone', '$address', '$city', '$child', '$pc', '$drive', '$sunAvail', '$monAvail', '$tueAvail', '$wedAvail', '$thuAvail', '$friAvail', '$satAvail', '$notes')");
				
				$sql->execute();
				
				//echo implode(":",$sql->errorInfo());
				
				echo "record added successfully.<br /><br />";
			}
			else
			{
				//Get user type records so that users can choose what type of user they want the new staff to be
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
						
				$sql = $conn->prepare("SELECT * FROM user_type");
					
				$sql->execute();
				
				$row = $sql->fetchAll();
				
				printf("

					<h1>Add New Staff Member</h1>

					<form method='post' action='addstaff.php'>

						First Name:
							<input type='text' name='fname' value=''>
						Last Name:
							<input type='text' name='lname' value=''><br /><br />\n

						Full Address:
							<input type='text' name='address' value=''>
						City:
							<input type='text' name='city' value=''><br /><br />\n

						Primary Phone Number:
							<input type='text' name='phone' value=''><br /><br />\n

						User Type:
							<select name='type'>
								<option value=''>Select one:</option>");
				foreach($row as $data)
					echo "<option value='{$data['TYPE_CODE']}'>{$data['TYPE_NAME']}</option>";
				printf("
							</select><br /><br />\n

						User Name:
							<input type='text' name='uname' value=''>
						Password:
							<input type='text' name='pass' value=''><br /><br />

						Availability: <br /><br />
							Sunday:
								Start:
									<input type='time' name='sunSt' value=''>
								End:
									<input type='time' name='sunEnd' value=''><br /><br />
							Monday:
								Start:
									<input type='time' name='monSt' value=''>
								End:
									<input type='time' name='monEnd' value=''><br /><br />

							Tuesday:
								Start:
									<input type='time' name='tueSt' value=''>
								End:
									<input type='time' name='tueEnd' value=''><br /><br />

							 Wednesday:
								Start:
									<input type='time' name='wedSt' value=''>
								End:
									<input type='time' name='wedEnd' value=''><br /><br />

							 Thursday:
								Start:
									<input type='time' name='thuSt' value=''>
								End:
									<input type='time' name='thuEnd' value=''><br /><br />

							 Friday:
								Start:
									<input type='time' name='friSt' value=''>
								End:
									<input type='time' name='friEnd' value=''><br /><br />

							 Saturday:
								Start:
									<input type='time' name='satSt' value=''>
								End:
									<input type='time' name='satEnd' value=''><br /><br />

						Able to Drive:
							<input type='checkbox' name='drive'>
							
						Notes:
							<textarea name='notes'>
							</textarea><br /><br />

						Can Provide Personal Care:
							<input type='checkbox' name='pc'><br /><br />

						Can Work With Children:
							<input type='checkbox' name='child'><br /><br />

						<input type='submit' name='submit' value='Submit'>

					</form>

				");
			}
        ?>

    </body>

</html>
