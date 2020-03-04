/*  Developer:   Justin Alho
 *  File Name:   adddep.php
 *  Description: Allows coordinators to add new department records into the database
 *  Date Start:  23/02/2020
 *  Date End:    TBD
 *  TODO:        - Add CSS
 *		 - Add data verification
 *		 - Add user authentication
 */
<html>

    <head>

        <title>Add New Department</title>

    </head>

    <body>

        <?php
			//When the user submits data, it is added to the database
	    		$code = '';
			$name = '';
			$desc = '';
		
			if(isset($_POST['submit']))
			{	
				$code = $_POST['code'];
				$name = $_POST['name'];
				$desc = $_POST['desc'];
				
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

				$sql = $conn->prepare("INSERT INTO 	department (DEP_CODE, DEP_NAME, DEP_DESC) VALUES ('$code', '$name', '$desc')");
				
				$sql->execute();
				
				//echo implode(":",$sql->errorInfo());
				
				echo "record added successfully.<br /><br />";
			}
			else
			{
				printf("

					<h1>Add New Department</h1>

					<form method='post' action='adddep.php'>
							
						Department Code:
							<input type='text' name='code' value=''><br /><br />\n	
							
						Department Name:
							<input type='text' name='name' value=''><br /><br />\n

						Department Description:
							<textarea name='desc'></textarea><br /><br />\n

						<input type='submit' name='submit' value='Submit'>\n

					</form>

				");
			}
        ?>

    </body>

</html>
