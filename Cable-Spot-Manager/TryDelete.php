<?php

include 'db.php';

try {
	$toDelete = 'SELECT AdID, ClientName, Name, Duration 
					FROM commercialad, client 
					WHERE commercialad.Client_ID = client.clientid
					ORDER BY ClientName, Duration';
	
	$r = $pdo->query($toDelete);
	if ($r->rowcount() == 0) {
		//echo "All programs currently have an ad placed."; 
		//exit();}
		header('Location: NoMoreAds.php');
        exit();
	  }  
}

catch (PDOException $e)  {
    $error = 'Unable to delete. Ad is already placed in a timeslot.' . $e->getMessage();
    include 'error.html.php';
	/*pdo->rollback();*/
    exit();
  } 
?>

<!DOCTYPE=html>
<html>
<head>
<title>Ad Catalog</title>
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
    <p>Select an ad to delete:</p>
	 <table align="center"> <!-- Here table headers for Ad Name, Client Name, Duration -->
    <?php foreach ($r as $ad): ?>
      <form action="DeleteAd.php" method="post">
	  <tr>
	  <input type="hidden" name="adid" value="<?php echo $ad['AdID']; ?>">
      <td> <?php echo $ad['Name']; ?> </td>
       <td> <?php echo $ad['ClientName']; ?> </td>
        <td> <?php echo $ad['Duration']; ?> </td> 
		 <td> 
		 <input type="hidden" name="placead" value="<?php echo $ad['AdID'];?>">
		 <input type="submit" name="submitter" value="Delete This Ad?">
		</td>
      </tr> </form>
    <?php endforeach;?>
    </table>
	</form>
	<form>
	<br>
		<input type="button" value="Log out" onclick="document.location.href='../../login.html'">
	</form>
  </body>
</html>