/*  Developer:   Justin Alho
 *  File Name:   modstaff.php
 *  Description: Allows coordinators to modify staff records
 *  Date Start:  26/02/2020
 *  Date End:    TBD
 *  TODO:        - Add CSS
 *		 - Add data verification
 *		 - Add user authentication
 */
<html>

    <head>

        <title>Modify Staff</title>

    </head>

    <body>

        <?php
		
			$id = '';
			$status = '';
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
			$sunSt = '';
			$sunEnd = '';
			$monAvail = '';
			$monSt = '';
			$monEnd = '';
			$tueAvail = '';
			$tueSt = '';
			$tueEnd = '';
			$wedAvail = '';
			$wedSt = '';
			$wedEnd = '';
			$thuAvail = '';
			$thuSt = '';
			$thuEnd = '';
			$friAvail = '';
			$friSt = '';
			$friEnd = '';
			$satAvail = '';
			$satSt = '';
			$satEnd = '';
			$notes = '';
			
	    		//If information is submitted, update staff record
			if(isset($_POST['submit']))
			{	
				$id = $_POST['id'];
				$status = $_POST['status'];
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
				
				$pass = password_hash($pass, PASSWORD_BCRYPT);
				
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

				$sql = $conn->prepare("UPDATE STAFF SET STAFF_STATUS = '$status', TYPE_CODE = '$type', USER_NAME = '$uname', USER_PASS = '$pass', STAFF_FNAME = '$fname', STAFF_LNAME = '$lname', STAFF_PHONE = '$phone',STAFF_ADDRESS = '$address', STAFF_CITY = '$city',
				CAN_CHILD = '$child', CAN_PC = '$pc', CAN_DRIVE = '$drive', SUN_AVAIL = '$sunAvail', MON_AVAIL = '$monAvail', TUE_AVAIL = '$tueAvail', WED_AVAIL = '$wedAvail', THU_AVAIL = '$thuAvail', FRI_AVAIL = '$friAvail', SAT_AVAIL = '$satAvail', STAFF_NOTES = '$notes'
				WHERE STAFF_ID = '$id'");
				
				$sql->execute();
				
				//echo implode(":",$sql->errorInfo()) . "<br>";
				
				echo "record updated successfully.<br /><br />";
			}
			else
			{
				//retrieve information from the database
				$id = $_REQUEST['id'];
				$username = 'Coordinator';
				$password = 'Password1';
				$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
						
				$sql = $conn->prepare("SELECT STAFF_ID, STAFF_STATUS, C_S_STATUS_CODE, C_S_STATUS_NAME, STAFF.TYPE_CODE, TYPE_NAME, USER_NAME, USER_PASS, STAFF_FNAME, STAFF_LNAME, STAFF_PHONE, STAFF_ADDRESS, STAFF_CITY, CAN_CHILD, CAN_PC, CAN_DRIVE, SUN_AVAIL, MON_AVAIL, TUE_AVAIL, WED_AVAIL, THU_AVAIL, FRI_AVAIL, SAT_AVAIL, STAFF_NOTES
				FROM STAFF
				LEFT JOIN C_S_STATUS
				ON STAFF.STAFF_STATUS = C_S_STATUS.C_S_STATUS_CODE
				LEFT JOIN USER_TYPE
				ON STAFF.TYPE_CODE = USER_TYPE.TYPE_CODE
				WHERE STAFF.STAFF_ID = '$id'");
					
				$sql->execute();
				
				$row = $sql->fetch();
				//echo implode(":",$sql->errorInfo()) . "<br>";
				
				$stasql = $conn->prepare("SELECT * FROM C_S_STATUS WHERE C_S_STATUS_CODE != '{$row['STAFF_STATUS']}'");
				
				$stasql->execute();
				
				$starow = $stasql->fetchAll();
				
				$typsql = $conn->prepare("SELECT * FROM USER_TYPE WHERE TYPE_CODE != '{$row['TYPE_CODE']}'");
				
				$typsql->execute();
				
				$typrow = $typsql->fetchAll();
				
				printf("

					<h1>Modify a Staff Member</h1>

					<form method='post' action='modstaff.php'>

						<input type='hidden' name='id' value='$id'>
						First Name:
							<input type='text' name='fname' value='{$row['STAFF_FNAME']}'>
						Last Name:
							<input type='text' name='lname' value='{$row['STAFF_LNAME']}'><br /><br />\n

						Full Address:
							<input type='text' name='address' value='{$row['STAFF_ADDRESS']}'>
						City:
							<input type='text' name='city' value='{$row['STAFF_CITY']}'><br /><br />\n

						Primary Phone Number:
							<input type='text' name='phone' value='{$row['STAFF_PHONE']}'><br /><br />\n
							
						Status:
							<select name='status'>
								<option value='{$row['C_S_STATUS_CODE']}'>{$row['C_S_STATUS_NAME']}</option>");
				foreach($starow as $data)
					echo "<option value='{$data['C_S_STATUS_CODE']}'>{$data['C_S_STATUS_NAME']}</option>";
				printf("
							</select><br /><br />\n
							
						User Type:
							<select name='type'>
								<option value='{$row['TYPE_CODE']}'>{$row['TYPE_NAME']}</option>");
				foreach($typrow as $data)
					echo "<option value='{$data['TYPE_CODE']}'>{$data['TYPE_NAME']}</option>";
				printf("
							</select><br /><br />\n

						User Name:
							<input type='text' name='uname' value='{$row['USER_NAME']}'>
						Password:
							<input type='text' name='pass' value='{$row['USER_PASS']}'><br /><br />");
							
				if($row['SUN_AVAIL'] != '')
				{					
					$sunAvail = explode(" - ", $row['SUN_AVAIL']);
					$sunSt = $sunAvail[0];
					$sunEnd = $sunAvail[1];
				}
				if($row['MON_AVAIL'] != '')
				{					
					$monAvail = explode(" - ", $row['MON_AVAIL']);
					$monSt = $monAvail[0];
					$monEnd = $monAvail[1];
				}
				if($row['TUE_AVAIL'] != '')
				{					
					$tueAvail = explode(" - ", $row['TUE_AVAIL']);
					$tueSt = $tueAvail[0];
					$tueEnd = $tueAvail[1];
				}
				if($row['WED_AVAIL'] != '')
				{					
					$wedAvail = explode(" - ", $row['WED_AVAIL']);
					$wedSt = $wedAvail[0];
					$wedEnd = $wedAvail[1];
				}
				if($row['THU_AVAIL'] != '')
				{					
					$thuAvail = explode(" - ", $row['THU_AVAIL']);
					$thuSt = $thuAvail[0];
					$thuEnd = $thuAvail[1];
				}
				if($row['FRI_AVAIL'] != '')
				{					
					$friAvail = explode(" - ", $row['FRI_AVAIL']);
					$friSt = $friAvail[0];
					$friEnd = $friAvail[1];
				}
				if($row['SAT_AVAIL'] != '')
				{					
					$satAvail = explode(" - ", $row['SAT_AVAIL']);
					$satSt = $satAvail[0];
					$satEnd = $satAvail[1];
				}
						
				printf("
						Availability: <br /><br />
							Sunday:
								Start:
									<input type='time' name='sunSt' value='$sunSt'>
								End:
									<input type='time' name='sunEnd' value='$sunEnd'><br /><br />
							Monday:
								Start:
									<input type='time' name='monSt' value='$monSt'>
								End:
									<input type='time' name='monEnd' value='$monEnd'><br /><br />

							Tuesday:
								Start:
									<input type='time' name='tueSt' value='$tueSt'>
								End:
									<input type='time' name='tueEnd' value='$tueEnd'><br /><br />

							 Wednesday:
								Start:
									<input type='time' name='wedSt' value='$wedSt'>
								End:
									<input type='time' name='wedEnd' value='$wedEnd'><br /><br />

							 Thursday:
								Start:
									<input type='time' name='thuSt' value='$thuSt'>
								End:
									<input type='time' name='thuEnd' value='$thuEnd'><br /><br />

							 Friday:
								Start:
									<input type='time' name='friSt' value='$friSt'>
								End:
									<input type='time' name='friEnd' value='$friEnd'><br /><br />

							 Saturday:
								Start:
									<input type='time' name='satSt' value='$satSt'>
								End:
									<input type='time' name='satEnd' value='$satEnd'><br /><br />");

				echo "Able to Drive:";
				if($row['CAN_DRIVE'] == 1)
					echo "<input type='checkbox' name='drive' checked><br /><br />";
				else
					echo "<input type='checkbox' name='drive'><br /><br />";
				
				echo "Can Provide Personal Care:";
				if($row['CAN_PC'] == 1)
					echo "<input type='checkbox' name='pc' checked><br /><br />";
				else
					echo "<input type='checkbox' name='pc'><br /><br />";

				echo "Can Work with Children:";
				if($row['CAN_CHILD'] == 1)
					echo "<input type='checkbox' name='child' checked><br /><br />";
				else
					echo "<input type='checkbox' name='child'><br /><br />";
				
				printf("							
						Notes:
							<textarea name='notes'>{$row['STAFF_NOTES']}</textarea><br /><br />
						
						<input type='submit' name='submit' value='Submit'>

					</form>

				");
			}
        ?>

    </body>

</html>
