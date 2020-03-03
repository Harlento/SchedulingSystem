<?php
	//This function takes a start and end time and returns the number of hours between the two.
	function getHours($start, $end)
	{
		$diff = strtotime($end) - strtotime($start);
		$hours = date('h', $diff);
		$mins = date('i', $diff);
		$hours = ($hours + ($mins / 60));
		return $hours;
	}
?>