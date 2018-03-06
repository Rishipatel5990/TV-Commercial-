
<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
	<style>
body {
	text-align: center;
    background-image: url("background.jpg");
	font-size: 25px;
	
}
</style>

  </head>
  <body>
   <h1>Welcome to Cable Spot Manager, your only place to buy Commercial ad time!</h1>
   <form action="processNewUser.php" method="post">
      <div><label for="newuserlogin">New User Name:
        <input type="text" name="newuserlogin" id="newuserlogin"></label>
      </div>
      <div><label for="newuserpwd">New User's Password:
        <input type="text" name="newuserpwd" id="newuserpwd"></label>
      </div>
      <div><input type="submit" value="Sign up"></div>
    </form>
	<?php if (!empty($error_message)) { ?>
   <p class='error'> <?php echo $error_message ?></p> <?php } ?>
	<p>Go back to <a href="login.html">login</a> page</p>
  
  </body>
</html>
  
  