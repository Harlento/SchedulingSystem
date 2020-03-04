/*  Developer:   Justin Alho
 *  File Name:   modclient.php
 *  Description: Allows coordinators to modify existing client records
 *  Date Start:  25/02/2020
 *  Date End:    TBD
 *  TODO:        - Add CSS
 *		 - Add data verification
 *		 - Add user authentication
 */
<html>

    <head>

        <title>Modify Client</title>

    </head>

    <body>

        <?php
		
			$id = '';
			$status = '';
			$gh = '';
			$fname = '';
			$lname = '';
			$phone = '';
			$address = '';
			$city = '';
			$hours = '';
			$km = '';
			$notes = '';
			
	    		//If the data has been submitted, the record is updated
			if(isset($_POST['submit']))
			{	
				$id = $_POST['id'];
				$status = $_POST['status'];
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

				$sql = $conn->prepare("UPDATE CLIENT SET CLIENT_STATUS = '$status', GH_ID = '$gh', CLIENT_FNAME = '$fname', CLIENT_LNAME = '$lname', CLIENT_PHONE = '$phone', CLIENT_ADDRESS = '$address', CLIENT_CITY = '$city',
				CLIENT_MAX_HOURS = '$km', CLIENT_KM = '$km', CLIENT_NOTES = '$notes'
				WHERE CLIENT_ID = '$id'");
				
				$sql->execute();
				
				//echo implode(":",$sql->errorInfo()) . "<br>";
				
				echo "record updated successfully.<br /><br />";
			}
			else
			{
				//Retrieve existing data from database
				$id = $_REQUEST['id'];
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
						
				$sql = $conn->prepare("SELECT CLIENT_ID, CLIENT_STATUS, C_S_STATUS_CODE, C_S_STATUS_NAME, CLIENT.GH_ID, GH_NAME, CLIENT_FNAME, CLIENT_LNAME, CLIENT_PHONE, CLIENT_ADDRESS, CLIENT_CITY, CLIENT_MAX_HOURS, CLIENT_KM, CLIENT_NOTES
				FROM CLIENT
				LEFT JOIN C_S_STATUS
				ON CLIENT.CLIENT_STATUS = C_S_STATUS.C_S_STATUS_CODE
				LEFT JOIN GROUP_HOME
				ON CLIENT.GH_ID = GROUP_HOME.GH_ID
				WHERE CLIENT.CLIENT_ID = '$id'");
					
				$sql->execute();
				
				$row = $sql->fetch();
				//echo implode(":",$sql->errorInfo()) . "<br>";
				
				$stasql = $conn->prepare("SELECT * FROM C_S_STATUS WHERE C_S_STATUS_CODE != '{$row['CLIENT_STATUS']}'");
				
				$stasql->execute();
				
				$starow = $stasql->fetchAll();
				
				$ghsql = $conn->prepare("SELECT GH_ID, GH_NAME FROM GROUP_HOME WHERE GH_ID != '{$row['GH_ID']}'");
				
				$ghsql->execute();
				
				$ghrow = $ghsql->fetchAll();
				
				printf("

					<h1>Modify a Client</h1>

					<form method='post' action='modclient.php'>

						<input type='hidden' name='id' value='$id'>
						First Name:
							<input type='text' name='fname' value='{$row['CLIENT_FNAME']}'>
						Last Name:
							<input type='text' name='lname' value='{$row['CLIENT_LNAME']}'><br /><br />\n

						Primary Phone Number:
							<input type='text' name='phone' value='{$row['CLIENT_PHONE']}'><br /><br />\n
							
						Full Address:
							<input type='text' name='address' value='{$row['CLIENT_ADDRESS']}'>
						City:
							<input type='text' name='city' value='{$row['CLIENT_CITY']}'><br /><br />\n
							
						Status:
							<select name='status'>
								<option value='{$row['C_S_STATUS_CODE']}'>{$row['C_S_STATUS_NAME']}</option>");
				foreach($starow as $data)
					echo "<option value='{$data['C_S_STATUS_CODE']}'>{$data['C_S_STATUS_NAME']}</option>";
				printf("
							</select><br /><br />\n
							
						Group Home:
							<select name='gh'>
								<option value='{$row['GH_ID']}'>{$row['GH_NAME']}</option>");
				foreach($ghrow as $data)
					echo "<option value='{$data['GH_ID']}'>{$data['GH_NAME']}</option>";
				printf("
							</select><br /><br />\n

						Distance (in kilometers):
							<input type='text' name='km' value='{$row['CLIENT_KM']}'><br /><br />
							
						Max Hours per Month:
							<input type='text' name='hours' value='{$row['CLIENT_MAX_HOURS']}'><br /><br />
							
						Notes:
							<textarea name='notes'>{$row['CLIENT_NOTES']}</textarea><br /><br />
						
						<input type='submit' name='submit' value='Submit'>

					</form>

				");
			}
        ?>

    </body>

</html>
