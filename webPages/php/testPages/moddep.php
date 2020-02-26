<html>

    <head>

        <title>Modify Department</title>

    </head>

    <body>

        <?php
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

				$sql = $conn->prepare("UPDATE DEPARTMENT SET DEP_NAME = '$name', DEP_DESC = '$desc' WHERE DEP_CODE = '$code'");
				
				$sql->execute();
				
				//echo implode(":",$sql->errorInfo());
				
				echo "record updated successfully.<br /><br />";
			}
			else
			{
				$code = $_REQUEST['code'];
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
						
				$sql = $conn->prepare("SELECT * FROM DEPARTMENT WHERE DEP_CODE = '$code'");
					
				$sql->execute();
				
				$row = $sql->fetch();
				
				printf("

					<h1>Modify Department</h1>

					<form method='post' action='moddep.php'>
							
						Department Code: $code<br /><br />\n
						<input type='hidden' name='code' value='$code'>
							
						Department Name:
							<input type='text' name='name' value='{$row['DEP_NAME']}'><br /><br />\n

						Department Description:
							<textarea name='desc'>{$row['DEP_DESC']}</textarea><br /><br />\n

						<input type='submit' name='submit' value='Update'>\n

					</form>

				");
			}
        ?>

    </body>

</html>