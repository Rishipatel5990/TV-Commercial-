<?php 
 include 'db.php';
 
if (isset($_SESSION)) {
	session_unset();
	session_destroy(); 
}
 try
{
  $sqlClient = 'SELECT DISTINCT ClientName
				FROM Client, commercialad
				WHERE clientID = Client_ID AND
				Duration IN (SELECT DISTINCT BreakDuration FROM timeslot
								WHERE Ad_ID IS NULL
								ORDER BY BreakDuration)
				ORDER BY ClientName';
  $resultClient = $pdo->query($sqlClient);
  
  $sqlAdDur = 'SELECT DISTINCT BreakDuration FROM timeslot
				WHERE Ad_ID IS NULL
				ORDER BY BreakDuration';
  $resultAdDur = $pdo->query($sqlAdDur);
  
  	if ($resultAdDur->rowcount() == 0) {
		//echo "All programs currently have an ad placed."; 
		//exit();}
		header('Location: FullSchedule.php');
        exit();
	  }  
	//	
}


catch (PDOException $e)
{
  $error = 'Error fetching everything: ' . $e->getMessage();
  include 'error.html.php';
  exit();
}
?>
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <title>Commercial Ad Search</title>
	
	   <?php
if (!empty($error_message)) //tests for error message
	{
		?>
<p class="error">

	<?php echo $error_message; //displays error message
	}
	else { 
		$error_message = '';
		echo '<b>Select a client and break duration!</b><br><br>';
		} ?>
  </head>
  <style>
  body {
	text-align: center;
    background-image: url("background.jpg");
	font-size: 25px;
	
}
table {
   border: 1px solid navy;
    }
		tr {
   border: 2px solid navy;
    }
	td {
    background-color: blue;
    color: white;
}
  </style>
  <body>
    <form action="AdResults.php" method="get"> 
     <table border="1" align="center">
	 <tr>
	 <td align="center"><b>Client Name</b></td>
	 <td align="center"><b>Break Duration</b></td>
	 </tr>
	 <tr>
	 <td>
		<select name="client">
		<option class="under" value = "0"></option>
			<?php foreach ($resultClient as $client) { ?>
			<option value="<?php echo $client['ClientName']?>">
				<?php echo $client['ClientName']?> </option> <?php } ?>
		</select></td>
		<td><select name="adduration">
		<option value="0"></option>
			<?php foreach ($resultAdDur as $adduration) { ?>
			<option value="<?php echo $adduration['BreakDuration']?>">
				<?php echo $adduration['BreakDuration']?> </option> <?php } ?>
		</select>
	</td>
	</tr>
	</table>
	<br>
      <div><input type="submit" value="Find Ads">
	  </div>
    </form>
  </body>
</html>