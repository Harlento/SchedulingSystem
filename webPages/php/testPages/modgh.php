/*  Developer:   Justin Alho
 *  File Name:   modgh.php
 *  Description: Allows coordinators to modify group home records
 *  Date Start:  25/02/2020
 *  Date End:    TBD
 *  TODO:        - Add CSS
 *		 - Add data verification
 *		 - Add user authentication
 */
<html>

    <head>

        <title>Modify Group Home</title>

    </head>

    <body>

        <?php
			$id = '';
			$super = '';
			$name = '';
			$phone = '';
			$address = '';
		
	    		//If data is submitted, the database record is updated
			if(isset($_POST['submit']))
			{	
				$id = $_POST['id'];
				$super = $_POST['super'];
				$name = $_POST['name'];
				$phone = $_POST['phone'];
				$address = $_POST['address'];
				
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

				$sql = $conn->prepare("UPDATE GROUP_HOME SET STAFF_ID = '$super', GH_NAME = '$name', GH_PHONE = '$phone', GH_ADDRESS = '$address' WHERE GH_ID = '$id'");
				
				$sql->execute();
				
				//echo implode(":",$sql->errorInfo()) . "<br>";
				
				echo "record updated successfully.<br /><br />";
			}
			else
			{
				//Information is retrieved from the database
				$id = $_REQUEST['id'];
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
						
				$sql = $conn->prepare("SELECT GH_ID, GROUP_HOME.STAFF_ID, STAFF_FNAME, STAFF_LNAME, GH_NAME, GH_PHONE, GH_ADDRESS
				FROM GROUP_HOME
				LEFT JOIN STAFF
				ON GROUP_HOME.STAFF_ID = STAFF.STAFF_ID
				WHERE GH_ID = '$id'");
					
				$sql->execute();
				
				$row = $sql->fetch();
				
				$supsql = $conn->prepare("SELECT STAFF_ID, STAFF_FNAME, STAFF_LNAME FROM STAFF WHERE TYPE_CODE = 'S'");
				
				$supsql->execute();
				
				$suprow = $supsql->fetchAll();
				
				printf("

					<h1>Modify Group Home</h1>

					<form method='post' action='modgh.php'>
							
						<input type='hidden' name='id' value='$id'>
							
						Group Home Name:
							<input type='text' name='name' value='{$row['GH_NAME']}'><br /><br />\n
							
						Supervisor:
							<select name='super'>
								<option value='{$row['STAFF_ID']}'>{$row['STAFF_FNAME']} {$row['STAFF_LNAME']}</option>");
				foreach($suprow as $data)
					echo "<option value='{$data['STAFF_ID']}'>{$data['STAFF_FNAME']} {$data['STAFF_LNAME']}</option>";
				printf("
							</select><br /><br />\n
							
						Group Home Phone:
							<input type='text' name='phone' value='{$row['GH_PHONE']}'><br /><br />\n

						Group Home Address:
							<input type='text' name='address' value='{$row['GH_ADDRESS']}'><br /><br />\n
							
						<input type='submit' name='submit' value='Update'>\n

					</form>

				");
			}
        ?>

    </body>

</html>
