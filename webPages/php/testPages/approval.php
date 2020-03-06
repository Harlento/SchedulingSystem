<?php
/*  Developer:   Justin Alho
 *  File Name:   approval.php
 *  Description: Takes in a staff ID and approves the hours they have claimed for all claimed shifts
 *  Date Start:  05/03/2020
 *  Date End:    TBD
 *  TODO:      	 - Add user authentication
 */
 
	$id = $_REQUEST['id'];
	
	$username = 'Coordinator';
	$password = 'Password1';
	$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);
			
	$sql = $conn->prepare("SELECT SHIFT_ID, SHIFT.STATUS_CODE, SHIFT.STAFF_ID, CLAIMED_START, CLAIMED_END
	FROM SHIFT
	LEFT JOIN SHIFT_STATUS
	ON SHIFT.STATUS_CODE = SHIFT_STATUS.STATUS_CODE
	LEFT JOIN STAFF
	ON SHIFT.STAFF_ID = STAFF.STAFF_ID
	WHERE SHIFT.STATUS_CODE = 'C'
	AND SHIFT.STAFF_ID = '$id'");
		
	$sql->execute();
	
	$row = $sql->fetchAll();
	
	foreach ($row as $data)
	{
		$addSql = $conn->prepare("UPDATE SHIFT SET STATUS_CODE = 'A', APPROVED_START = '{$data['CLAIMED_START']}', APPROVED_END = '{$data['CLAIMED_END']}'
		WHERE SHIFT_ID = '{$data['SHIFT_ID']}'");
		
		$addSql->execute();
	}
?>
