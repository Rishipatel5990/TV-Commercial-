<!DOCTYPE html>
<?php 

 include 'db.php';
 session_start();
 $adid = $_SESSION["adid"];

 
 foreach($_POST['ads'] as $adsplaced) {
	/* echo $adsplaced; just printing out all IDs updated and queries used */
	
	try {
		
		$sqlBuy = 'UPDATE timeslot
					SET Ad_ID = '."$adid".'
					WHERE TimeSlotID = '."$adsplaced";
						
		$r = $pdo->query($sqlBuy);
		
		/* var_dump($r); testing results */
	}
 
	catch (PDOException $e)  {
		$error = 'Error selecting ads: ' . $e->getMessage();
		include 'error.html.php';
		exit();
	}
 }	
 ?>
 <html lang="en">
  <head>
    <meta charset="utf-8">
	
    <title>Placement successful!</title>
	<style>
	body{
		text-align: center;
    background-image: url("background.jpg");
	font-size: 25px;
	}
	</style>
	</head>
	<body>
	<p> Your ad was placed successfully! </p>
	<form>
		<input type="button" value="Choose Another Ad" onclick="document.location.href='CommercialAdSearch.php'">
		
		<input type="button" value="LogOut" onclick="document.location.href= '../../login.html'">
		
	</form>
	</body>
	</html>