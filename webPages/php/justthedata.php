<?php

$username = 'Coordinator';
$password = 'Password1';
$conn = new PDO("mysql:host=localhost; dbname=edenbridgetest", $username, $password);

$sql = $conn->prepare("SELECT SHIFT_ID, SHIFT_DATE, CLAIMED_START, CLAIMED_END, SHIFT_DATE,
			FROM SHIFT");

$sql->execute();

$row = $sql->fetchAll();

// query to get the list of shifts worked in that month by a worker ordered by accending date
//select * from shift where cast(SHIFT_DATE as date) between "2020-03-01" and "2020-03-15" and STAFF_ID = "$username" order by SHIFT_DATE ASC;


//gets the day from a date (can be a string)
//select extract(DAY FROM "2020-03-21")

//This can be used to get how many days in a month there are
//EOMONTH = $eday - 15;

echo "<table>
<tr>
        <th>Individual Served</th>
        <th>Specifics</th>
        ";
        for ($x = 0; $x <= $eday; $eday--) {
    echo "<th>$eday</th>";}

echo "
    </tr>";


foreach ($row as $data)
{
    echo "<tr>";
    echo "<td>{$data['CLIENT_LNAME']}</td>";
    echo "start time";
    echo "<tr>";
}

echo "</table><br />\n";



