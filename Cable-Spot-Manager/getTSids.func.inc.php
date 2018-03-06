<?php
	
function getTSids($array){
	
	include 'db.php';
 
 $tsID_string = implode(",", $array);
 
 try {
		
		$sqlSUM = 'SELECT SUM(BaseRate) AS TotalCost
					FROM timeslot
					WHERE TimeSlotID IN (' . $tsID_string . ')';
		
		$r = $pdo->query($sqlSUM);
		
		$row = $r->fetch();
		
		$sum = (int) $row[0];
	}
 
	catch (PDOException $e)  {
		$error = 'Error selecting ads: ' . $e->getMessage();
		include 'error.html.php';
		exit();
	} 

	return $sum;
}