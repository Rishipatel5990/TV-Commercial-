<?php 

 include 'db.php';
 
 	if(!empty($error)) {
		echo $error;
		$adid = $_SESSION["adid"];
	}
	
	else if(isset($_POST['reset'])) {

	$adid = $_SESSION["adid"];
	}
	
	else {
	session_start();
 
 	$adid = $_POST['placead'];
	
	$_SESSION["adid"] = $adid;
	}
	
 try {
 
 $sqlTVS = 'SELECT TimeSlotID, ChannelName, AirDate, StartTime, EndTime, ProgramName, ProgramType, Adjacency, BaseRate, BreakDuration
			FROM timeslot, tvprogram
			WHERE Program_ID = ProgramID AND
			Ad_ID IS NULL AND
			BreakDuration = (SELECT Duration
								FROM CommercialAd
								WHERE AdID = \'' ."$adid".'\' )
 ORDER BY TimeSlotID'; 
						
	$r = $pdo->query($sqlTVS);
	$resultTVS = $r->fetchAll();
	
	if ($r->rowcount() == 0) {
		header('Location: FullSchedule.php');
        exit();
	  }  
		//echo "All programs currently have an ad placed.";
		//exit();}	
 }

 catch (PDOException $e)  {
    $error = 'Error selecting ads: ' . $e->getMessage();
    include 'error.html.php';
    exit();
  }  
  
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Program Search Results</title>
	<style>body{
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
	<b>The results are in:</b><br><br>
  </head>
  <body>
  	 <table align="center">
	 <form action="BuyTime.php" method="post">
    <?php foreach ($resultTVS as $place): ?>
	<tr>
	<input type="hidden" name="timeslotid" value="<?php echo $place['TimeSlotID']; ?>">
      <td> <?php echo $place['ChannelName']; ?> </td>
       <td> <?php echo $place['AirDate']; ?> </td>
	    <td> <?php echo $place['StartTime']; ?> </td>
        <td> <?php echo $place['EndTime']; ?> </td>
		<td> <?php echo $place['ProgramName']; ?> </td>
		<td> <?php echo $place['ProgramType']; ?> </td>
       <td> <?php echo $place['Adjacency']; ?> </td>
	    <td> <?php echo $place['BaseRate']; ?> </td>
        <td> <?php echo $place['BreakDuration']; ?> </td> 
		<td> <input type="checkbox" name="tsids[]" value="<?php echo $place['TimeSlotID']; ?>"> </td>
		</tr> 
		<?php endforeach;?>
	</table> <br>
	<input type="submit" value="Buy these programs">
	</form>
	</body>
	</html> 