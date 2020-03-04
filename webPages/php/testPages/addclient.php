/*  Developer:   Justin Alho
 *  File Name:   addclient.php
 *  Description: Allows coordinators to add new client records into the database
 *  Date Start:  25/02/2020
 *  Date End:    TBD
 *  TODO:        - Add CSS
 *		 - Add data verification
 *		 - Add user authentication
 */
<html>

    <head>

        <title>Add New Staff Member</title>

    </head>

    <body>

        <?php
			
			$gh = '';
			$fname = '';
			$lname = '';
			$phone = '';
			$address = '';
			$city = '';
			$hours = '';
			$km = '';
			$notes = '';
		
	    		//If the user submits the form, the info is added to the database
			if(isset($_POST['submit']))
			{	
				$gh = $_POST['gh'];
				$fname = $_POST['fname'];
				$lname = $_POST['lname'];
				$phone = $_POST['phone'];
				$address = $_POST['address'];
				$city = $_POST['city'];
				$hours = $_POST['hours'];
				$km = $_POST['km'];
				$notes = $_POST['notes'];
				
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

				
				$sql = $conn->prepare("INSERT INTO CLIENT (GH_ID, CLIENT_FNAME, CLIENT_LNAME, CLIENT_PHONE, CLIENT_ADDRESS, CLIENT_CITY, CLIENT_MAX_HOURS, CLIENT_KM, CLIENT_NOTES)
				VALUES ('$gh', '$fname', '$lname', '$phone', '$address', '$city', '$hours', '$km', '$notes')");
				
				$sql->execute();
				
				//echo implode(":",$sql->errorInfo());
				
				echo "record added successfully.<br /><br />";
			}
			else
			{
				//Retrieve Group Home records to display in dropdown
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
						
				$sql = $conn->prepare("SELECT * FROM group_home");
					
				$sql->execute();
				
				$row = $sql->fetchAll();
				
				printf("

					<h1>Add New Client</h1>

					<form method='post' action='addclient.php'>

					First Name:
                        <input type='text' name='fname' value=''>
                    Last Name:
                        <input type='text' name='lname' value=''><br /><br />\n
                    Full Address:
                        <input type='text' name='address' value=''>
                    City:
                        <input type='text' name='city' value=''><br /><br />\n
                    Phone Number:
                        <input type='text' name='phone' value=''><br /><br />\n
                    Group Home:
                        <select name='gh'>
                            <option value=''>Select a Group Home:</option>");
				foreach($row as $data)
					echo "<option value='{$data['GH_ID']}'>{$data['GH_NAME']}</option>";
				printf("
                        </select><br /><br />
					Hours Per Month:
                        <input type='text' name='hours' value=''><br /><br /><br />\n
					Distance (in kilometers):
                        <input type='text' name='km' value=''><br /><br /><br />\n
					Notes:
						<textarea name='notes'>
						</textarea><br /><br />\n

						<input type='submit' name='submit' value='Submit'>

					</form>

				");
			}
        ?>

    </body>

</html>
