<?php

include 'db.php';

try {
	$deletion = $_POST['adid'];
	
	$sqlDele = 'SELECT TimeSlotID, Ad_ID, AdID
				FROM timeslot, commercialad
				WHERE Ad_ID = :adid';
				
	$r = $pdo->prepare($sqlDele);
				
	$r->bindValue(':adid', $_POST['adid'], PDO::PARAM_STR);
	
	$r->execute();
	
	$results = $r->fetchAll();
	
	if(empty($results)) {
		$del = 'DELETE FROM commercialad
				WHERE AdID = :adid';
		
		$r = $pdo->prepare($del);
				
		$r->bindValue(':adid', $_POST['adid'], PDO::PARAM_STR);
	
		$r->execute();
	
		echo 'The ad was successfully deleted.';
	}
	
	else {
		echo 'Ad already scheduled. Delete failed.';
	}
}
catch (PDOException $e)  {
    $error = 'Error selecting ads: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  } 
?>
  <!DOCTYPE=html>
<html>
<head>
<title>Deletion Results</title>
<style>
body{
		text-align: center;
    background-image: url("background.jpg");
	font-size: 25px;
	}
table,th,td
{
	border: 1px solid navy;
background-color: green;
    color: white;
	font-size: 20px;
}
</style>
</head>
<body>
	<form>
	<br>
		<input type="button" value="New Search" onclick="document.location.href='trydelete.php'">
	</form>
  </body>
</html>