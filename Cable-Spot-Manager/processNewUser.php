<?php 
include_once $_SERVER['DOCUMENT_ROOT'] . '/PHPLab/Lab7Student/include/db.inc.php'; // conect to database


$newUserLogin  = $_POST['newuserlogin'];
$newUserPwd = $_POST['newuserpwd'];

if ( $newUserLogin == '' || $newUserPwd == '') { //check if field not blank
        $error_message = 'Please fill out all blank fileds.';
		include('NewUser.php');
        exit();
    } 
	
$newUserPwd = password_hash($_POST['newuserpwd'],PASSWORD_DEFAULT); //convert password to hash form

try // check if user with same name already exist
{
  $sql = 'SELECT * FROM userpwd';
  $users = $pdo->query('SELECT * FROM userpwd');
}
catch (PDOException $e)
{
  $error = 'Error fetching departments: ' . $e->getMessage();
  include 'error.html.php';
  exit();
}

foreach ($users as $user):
$login = $user['login'];
if ($login == $newUserLogin){
	 $error_message = "Domain '$newUserLogin' aleady exist";
		include('NewUser.php');
        exit();
    } 
	endforeach;



try // adding new user to database
{
  $sql = "INSERT INTO userpwd
(login, pwdHash)
values
('$newUserLogin', '$newUserPwd')";
  $pdo->exec($sql);
   $output= 'Registration Successful';
}
catch (PDOException $e)
{
  $output = 'Error performing update: ' .'<br/>'. $e->getMessage();
}

echo $output;
?>
<p>Go to <a href ="login.html">Main</a> page</P