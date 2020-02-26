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
			$avail = '';
			$notes = '';
		
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
				//$avail = $_POST['avail'];
				$notes = $_POST['notes'];
				
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

				
				$sql = $conn->prepare("INSERT INTO STAFF (TYPE_CODE, USER_NAME, USER_PASS, STAFF_FNAME, STAFF_LNAME, STAFF_PHONE, STAFF_ADDRESS, STAFF_CITY, CAN_CHILD, CAN_PC, CAN_DRIVE, STAFF_AVAIL, STAFF_NOTES)
				VALUES ('$type', '$uname', '$pass', '$fname', '$lname', '$phone', '$address', '$city', '$child', '$pc', '$drive', '$avail', '$notes')");
				
				$sql->execute();
				
				//echo implode(":",$sql->errorInfo());
				
				echo "record added successfully.<br /><br />";
			}
			else
			{
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