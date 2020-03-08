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
				
			}
			
			table
			{
				table-layout: fixed;
			}
			
			.calendar
			{
				width: 80%;
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
            //Verify user

            //Include header

            //Include navbar
			
			include "../includes/scripts/navBar.php";

            //This will query the db for the required information
            $username = 'Coordinator';
            $password = 'Password1';

            $conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

            $stm = $conn->prepare("SELECT shift_date, scheduled_start, scheduled_end, shift_id
            FROM shift
            WHERE staff_id = ?
            AND status_code = ?
            ");
			
			
			//
			$statusCode = "S";
			$staffID = $_SESSION['staffID'];
			
			 
			
			//test
			//$staffID = "4";
			$exeParams = array($staffID, $statusCode);

            $stm->execute($exeParams);

            $dataArray = $stm->fetchAll(PDO::FETCH_ASSOC);
			
			
			//test
			//$conn->connection = null;
			
			$array = array(1,2,3,4,5,6,7,8,9,10,11,12,13,14,15,16,17,18,19,20,21,22,23,24,25,26,27,28,29,30,31);
			
			//$shiftID = $dataArray[][];

            //Date information
            $numODays = date('t');
            $year = date('Y');
            $month = date('m');

            //Test print values
			
            print($numODays);
            print($year);
            print($month);
			
			//test
			print("<div id='ele'></div>");
			
			//test
            print_r($dataArray);
			
			print($staffID);
			
			
			$dateComponents = getdate();

			$month = $dateComponents['mon'];
			$year = $dateComponents['year'];
			
			//This will print out the calendar
			echo build_calendar($month,$year,$dateComponents);
			
			

			include "../includes/scripts/footer.php";
			
        ?>
        
			<script>

					
				var index;
				
				//Passing data from PHP to JS
				var array = <?php echo json_encode($dataArray); ?>;
				var numODays = <?php echo $numODays; ?>;

				var year = <?php echo $year; ?>;
				var month = <?php echo $month; ?>;
				

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

							//This converts 24hr to 12hr time
							var start = array[j]['scheduled_start'];
							var end = array[j]['scheduled_end'];
							
							var startArray = start.split(":");
							var endArray = end.split(":");
							
							var hour;
							var endHour;
	
							
							//Converting shift start time to 12hr format
							if(startArray[0] < 12)
							{
								start = startArray[0] + ":" + startArray[1] + "AM";
							}
							else if(startArray[0] == 12)
							{
								start = startArray[0] + ":" + startArray[1] + "PM";
							}
							else if(startArray[0] > 12)
							{
								hour = startArray[0] - 12;
								start = hour + ":" + startArray[1] + "PM";
							}
							
							//Converting shift end time to 12hr format
							if(endArray[0] < 12)
							{
								end = endArray[0] + ":" + endArray[1] + "AM";
							}
							else if(endArray[0] == 12)
							{
								end = endArray[0] + ":" + endArray[1] + "PM";
							}
							else if(endArray[0] > 12)
							{
								endHour = endArray[0] - 12;
								end = endHour + ":" + endArray[1] + "PM";
							}
							
							//*/
							//////////////////////////////////////////////////////////////////////////
							//////////////////////////////////////////////////////////////////////////
							
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