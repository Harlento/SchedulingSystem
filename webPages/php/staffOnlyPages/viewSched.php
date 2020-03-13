<html>
    
    <head>
        <title>View Schedule</title>
		<?php 
			session_start(); 
			$userType = $_SESSION['userType'];
		?>
		<?php include "../includes/scripts/headLinks2.0.php"; ?>
		
		<style>
			.calendar, td, tr
			{
				border: 1px solid black;
				
				
			}
			
			th
			{
				text-align: center;
			}
			
			td
			{
				vertical-align: top;
				text-align: left;
				width: 14.25%;
				word-break: break-word;
			}
			
			table
			{
				table-layout: fixed;
			}
			
			.calendar
			{
				width: 100%;
				height: 100%;
			}

			.header
			{
				
			}

			.day
			{
				
			}
			
			a
			{
				display: block;
			}
			
			html, body
			{
				height: 100%;
				width: 100%; 
			}
			
			.bodyDiv
			{
				height: 100%;
				width: 100%;
				text-align: center;
			}
			
			.childBodyDiv
			{
				height: 100%;
				width: 100%;
				display: inline-block;
			}
		</style>

    </head>
    
    <body>

        <?php
			
			//test variable!!!
			//$_SESSION['staffId'] = "4";
			
			$authLevel = "W";
			
			#to verify the user 
			include "../includes/functions/verLogin.php";
			verLogin();
			
			#test!!!!!!!!!!!!!!!!!!!!!!!1
			#print($authLevel);
			
			#to verify the users type
			include "../includes/functions/valUserType.php";
			valUserType($authLevel);
			
			
			include "../includes/functions/calendar.php";
			
			if(isset($_SESSION['staffID']))
			{
				$staffID = $_SESSION['staffID'];
			}
			//echo $staffID;
            //Verify user

            //Include header

            //Include navbar
			
			include "../includes/scripts/navBar.php";
			
			print("
				<div class='bodyDiv'>
					<div class='childBodyDiv'>
			");

            //This will query the db for the required information
            $username = 'Coordinator';
            $password = 'Password1';

            $conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

            $stm = $conn->prepare("SELECT shift_date, scheduled_start, scheduled_end, shift_id
            FROM shift
            WHERE staff_id = ?
            AND status_code = ?
            ");
			
			
			//Executino parameters
			$statusCode = "S";
			$staffID = $_SESSION['staffID'];
			
			 
			
			//test
			//$staffID = "4";
			$exeParams = array($staffID, $statusCode);

            $stm->execute($exeParams);

            $dataArray = $stm->fetchAll(PDO::FETCH_ASSOC);
			
			
			//test
			//$conn->connection = null;
			
			//$array = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
			
			//$shiftID = $dataArray[][];

            //Date information
            $numODays = date('t');
            $year = date('Y');
            $month = date('m');

            //Test print values
			
           // print($numODays);
           // print($year);
            //print($month);
			
			//test
			//print("<div id='ele'></div>");
			
			//test
            //print_r($dataArray);
			
			//print($staffID);
			
			
			$dateComponents = getdate();
			
			//Month being stored in a session var
			$month = $dateComponents['mon'];
			if(!isset($_REQUEST['submit']))
			{
				$_SESSION['month'] = $month;
			}
			
			//Testing changing the month
			//$month = $month - 10;
			
			//test
			//print($month);
			
			
			$year = $dateComponents['year'];
			
				
			if( (isset($_REQUEST['submit'])) && ($_REQUEST['nextMonth'] == 1) )
			{
				
				$month = $_SESSION['month'] + 1;
				$_SESSION['month'] = $_SESSION['month'] + 1;
			}
			else if( (isset($_REQUEST['submit'])) && ($_REQUEST['nextMonth'] == -1) )
			{
				$month = $_SESSION['month'] - 1;
				$_SESSION['month'] = $_SESSION['month'] - 1;
			}
			
			//This will print out the calendar
			echo build_calendar($month,$year);
			
			print("
					</div>
				</div>	
			");

			include "../includes/scripts/footer.php";
			
        ?>
        
			<script>
					
				//////////////////////Calendar population script///////////////////////////
				////////////////////////////////////////////////////////////////
				/*
				Author: Harley Lenton
				Date: 03/03/20
				Brief: This script will populate the calendar with all the shifts of the current worker. 
				*/
				var index;
				
				//Passing data from PHP to JS
				var array = <?php echo json_encode($dataArray); ?>;
				var numODays = <?php echo $numODays; ?>;

				
				var year = <?php echo $year; ?>;
				var month = <?php echo $month; ?>;
				
				//giving the month back it's leading zero if it needs one because JS gets rid of it when passing from PHP
				if (month < 10)
				{
					month = "0" + month;
				}
				
				var date = year + "-" + month + "-";
				
				
				//This is the length of the fetchAll array 
				var lofa = <?php echo count($dataArray); ?>;
				var i;
				
				for(index = 1; index <= numODays; index++)
				{
					
					if(index < 10)
					{
						i = "0" + index;
						//test
						//document.getElementById("2020-03-01").innerHTML = "Index < 10";
					}
					else
					{
						i = index;
						//test
						//document.getElementById("2020-03-01").innerHTML = "Index !< 10";
					}
					
					//Getting the current day by id
					var parent = document.getElementById(date + i);
					var newChild;
					
					//This will iterate through all rows of the fetch array checking if the current index is scheduled for the current day
					for(var j = 0; j < lofa; j++)
					{
						if( (array[j]['shift_date']) == (date + i) )
						{
							//test
							//document.getElementById(date + i).innerHTML = array[j]['shift_date'];

							//This will convert 24hr to 12hr time///////////////////////////////////////////////////////////////////
							var start = array[j]['scheduled_start'];
							var end = array[j]['scheduled_end'];
							
							var startArray = start.split(":");
							var endArray = end.split(":");
							
							var hour;
							var endHour;
	
							
							//Converting shift start time to 12hr format
							if( (startArray[0] < 12) && (startArray[0] != 0) )
							{
								//Getting rid of the leading zero of the first hour
								var startHour = startArray[0];
								startHour = parseInt(startHour, 10);
								start = startHour + ":" + startArray[1] + "<br />" + "AM";
							}
							else if(startArray[0] == 12)
							{
								start = startArray[0] + ":" + startArray[1] + "<br />" + "PM";
							}
							else if(startArray[0] > 12)
							{
								hour = startArray[0] - 12;
								start = hour + ":" + startArray[1] + "<br />" + "PM";
							}
							else if(startArray[0] == 0)
							{
								hour = 12;
								start = hour + ":" + startArray[1] + "<br />" + "AM";
							}
							
							//Converting shift end time to 12hr format
							if( (endArray[0] < 12)  && (endArray[0] != 0) )
							{
								//Removing leading zero
								var endHour = endArray[0];
								endHour = parseInt(endHour, 10);
								end = endHour + ":" + endArray[1] + "<br />" + "AM";
							}//Noon will be changed into 12PM by this
							else if(endArray[0] == 12)
							{
								end = endArray[0] + ":" + endArray[1] + "<br />" + "PM";
							}
							else if(endArray[0] > 12)
							{
								endHour = endArray[0] - 12;
								end = endHour + ":" + endArray[1] + "<br />" + "PM";
							}//Midnight 00 will be changed into 12AM by this
							else if(endArray[0] == 0)
							{
								endHour = 12;
								end = endHour + ":" + endArray[1] + "<br />" + "AM";
							}
							/////////////////////////////////////////////////////////////////////////
							
							let newChild = document.createElement('div');
							newChild.innerHTML = "<a href='workerViewShift.php?id=" + array[j]['shift_id'] + "'>" + start + "-" + end + "</a>";
							parent.appendChild(newChild.firstChild);
							
						}
						else
						{
							//document.getElementById("2020-03-25").innerHTML = "shift date not matching";
						}
						
					}
					
				}
						
            
        </script>

    </body>
	


</html>