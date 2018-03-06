<!DOCTYPE html>
<?php 

 include 'db.php';
 include_once 'getTSids.func.inc.php';

 session_start();
 
 if(isset($_POST['reset'])) {
		$adid = $_SESSION["adid"];
	 include 'TVProgramSearch.php';
	 exit();
 }
 
 if (empty($_POST['tsids'])) {
	 $error = 'Please select a program to buy:<br><br>';
	 include 'TVProgramSearch.php';
	 exit();
 } 
 
 $sum = getTSids($_POST['tsids']);
 $sumformat = '$' . $sum;
 
 foreach($_POST['tsids'] as $buyad) {
	/*echo $buyad; test command*/  
  
	try {
		$sqlBT = 'SELECT TimeSlotID, ChannelName, AirDate, StartTime, EndTime, ProgramName, ProgramType, Adjacency, BaseRate, BreakDuration
					FROM timeslot, tvprogram
					WHERE Program_ID = ProgramID AND
					TimeSlotID = ' . $buyad . ' 
					ORDER BY TimeSlotID'; 
						
		$r = $pdo->query($sqlBT);

		$resultBT[] = $r->fetch(); 		
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
    <title>Ready to Place</title>
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
	<b>Your selected ads:</b><br><br>
  </head>
  <body>
  	 <table align="center">
	 <form action="FinalCheck.php" method="post">
    <?php foreach ($resultBT as $buy): ?>
	<tr>
	<input type="hidden" name="ads[]" value="<?php echo $buy['TimeSlotID']; ?>">
      <td> <?php echo $buy['ChannelName']; ?> </td>
       <td> <?php echo $buy['AirDate']; ?> </td>
	    <td> <?php echo $buy['StartTime']; ?> </td>
        <td> <?php echo $buy['EndTime']; ?> </td>
		<td> <?php echo $buy['ProgramName']; ?> </td>
		<td> <?php echo $buy['ProgramType']; ?> </td>
        <td> <?php echo $buy['Adjacency']; ?> </td>
	    <td> <?php echo $buy['BaseRate']; ?> </td>
        <td> <?php echo $buy['BreakDuration']; ?> </td> 
	</tr> 
	<?php endforeach;?>
	</table> 
	<br>
	<input type="submit" value="Buy these programs for <?php echo $sumformat;?>">
	</form>
	<br>
	<br>
	<form>
			<input type="button" value="Choose a Different Ad" onclick="document.location.href='CommercialAdSearch.php'">
	</form>
	<br>
	<br>
		<form action="?" method="post">
		<input type="hidden" name="reset" value="<?php echo $buy['TimeSlotID']; ?>">
		<input type="submit" value="Choose Different Programs">
	</form>
	</body>
	</html> 