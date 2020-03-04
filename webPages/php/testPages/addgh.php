/*  Developer:   Justin Alho
 *  File Name:   addgh.php
 *  Description: Allows coordinators to add new group home records into the database
 *  Date Start:  25/02/2020
 *  Date End:    TBD
 *  TODO:        - Add CSS
 *		 - Add data verification
 *		 - Add user authentication
 */
<html>

    <head>

        <title>Add New Group Home</title>

    </head>

    <body>

        <?php
			$super = '';
			$name = '';
			$phone = '';
			$address = '';
	    
			//If the user submits data, it is added into the database
			if(isset($_POST['submit']))
			{	
				$super = $_POST['super'];
				$name = $_POST['name'];
				$phone = $_POST['phone'];
				$address = $_POST['address'];
				
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

				$sql = $conn->prepare("INSERT INTO 	group_home (STAFF_ID, GH_NAME, GH_PHONE, GH_ADDRESS) VALUES ('$super', '$name', '$phone', '$address')");
				
				$sql->execute();
				
				//As well as a new group home record, a new department record is also created
				
				//The last inserted ID is retrieved and "G" is added to it, so the department for GH with ID 17 would be G17
				$id = $conn->lastInsertId();
				$code = 'G' . $id;
				$desc = 'The department for ' . $name . '.';
				
				$depsql = $conn->prepare("INSERT INTO department (DEP_CODE, GH_ID, DEP_NAME, DEP_DESC) VALUES ('$code', '$id', '$name', '$desc')");
				$depsql->execute();
				
				//echo implode(":",$sql->errorInfo());
				
				echo "record added successfully.<br /><br />";
			}
			else
			{
				//A list of supervisors is retrieved from the staff table so the user can select a supervisor for the group home
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
						
				$sql = $conn->prepare("SELECT * FROM staff WHERE TYPE_CODE = 'S'");
					
				$sql->execute();
				//echo implode(":",$sql->errorInfo());
				
				$row = $sql->fetchAll();
				
				printf("

					<h1>Add New Group Home</h1>

					<form method='post' action='addgh.php'>

						Supervisor:
							<select name='super'>
								<option value=''>Select a supervisor:</option>");
				foreach($row as $data)
					echo "<option value='{$data['STAFF_ID']}'>{$data['STAFF_FNAME']} {$data['STAFF_LNAME']}</option>";
				printf("
							</select><br /><br />\n
							
						Group Home Name:
							<input type='text' name='name' value=''><br /><br />\n	
							
						Group Home Address:
							<input type='text' name='address' value=''><br /><br />\n

						Phone Number:
							<input type='text' name='phone' value=''><br /><br />\n

						<input type='submit' name='submit' value='Submit'>\n

					</form>

				");
			}
        ?>

    </body>

</html>
