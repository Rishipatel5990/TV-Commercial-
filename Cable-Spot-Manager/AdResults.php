<?php
include 'db.php';

$test = 'SELECT AdID, ClientName, Name, Duration
			FROM commercialad, client 
			WHERE commercialad.Client_ID = client.clientid
			AND	Duration IN (SELECT DISTINCT BreakDuration FROM timeslot
								WHERE Ad_ID IS NULL
								ORDER BY BreakDuration)	';

 try
	{ if(!$_GET['client'] == 0 || !$_GET['adduration'] == 0) {
		  
		if (!$_GET['client'] == 0) {
			$test .= 'AND ClientName = :client ';
		}  
  
		if (!$_GET['adduration'] == 0) {
			$test .= 'AND Duration = :adduration';			
		}
		
		$s = $pdo->prepare($test);
		
		if (!$_GET['client'] == 0) { 
		$s->bindValue(':client', $_GET['client'], PDO::PARAM_STR); }
		
		if (!$_GET['adduration'] == 0) { 
		$s->bindValue(':adduration', $_GET['adduration'], PDO::PARAM_INT); 
		} 
		
		$s->execute();	

		if ($s->rowcount() == 0) {
		$adduration = $_GET['adduration'];
		$error_message = "There are no available ads with those criteria.
		<br><br>
		Please make a selection:";
		include('CommercialAdSearch.php'); 
		exit();}		
		
	}	
		else {
			$test .= 'ORDER BY ClientName, Duration';
			$s = $pdo->query($test);
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
<title>Ad Results</title>
<style>body {
	text-align: center;
    background-color: lightblue;
	font-size: 25px;
	
}
table,th,td
{
border: 1px solid navy;
background-color: #4CAF50;
    color: white;
	font-size: 25px;
}

</style>
</head>
<body>
    <p>All relevant ads:</p>
	 <table align="center"> <!-- Here table headers for Ad Name, Client Name, Duration -->
    <?php foreach ($s as $ad): ?>
      <form action="TVProgramSearch.php" method="post">
	  <tr>
	  <input type="hidden" name="adid" value="<?php echo $ad['AdID']; ?>">
      <td> <?php echo $ad['Name']; ?> </td>
       <td> <?php echo $ad['ClientName']; ?> </td>
        <td> <?php echo $ad['Duration']; ?> </td> 
		 <td> 
		 <input type="hidden" name="placead" value="<?php echo $ad['AdID'];?>">
		 <input type="submit" name="submitter" value="Place this ad">
		</td>
      </tr> </form>
    <?php endforeach;?>
    </table>
	</form>
	<form>
	<br>
		<input type="button" value="New Search" onclick="document.location.href='CommercialAdSearch.php'">
	</form>
  </body>
</html>