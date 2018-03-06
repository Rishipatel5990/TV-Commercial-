<?php
include_once $_SERVER['DOCUMENT_ROOT'] . '/PHPLab/Lab7Student/include/db.inc.php';


$userlogin = $_POST['userlogin'];
$userpwd = $_POST['userpwd'];



try // fetching data from to userPwd table
{
  $users = $pdo->query('SELECT * FROM userpwd');
}
catch (PDOException $e)
{
 $error_message = 'Error fetching departments: ' . $e->getMessage();
  include ('login.html');
  exit();
}
try // fetching data from adminPwd table
{
  $admins = $pdo->query('SELECT * FROM adminpwd');
}
catch (PDOException $e)
{
 $error_message = 'Error fetching departments: ' . $e->getMessage();
  include ('login.html');
  exit();
}
foreach ($users as $user): // checkong data from userpwd
$pwdHash = $user['pwdHash'];
$login = $user['login'];
  if (password_verify($userpwd,$pwdHash) && $userlogin == $login){ // case when entered data match with database data
		header('Location: Mike\project\CommercialAdSearch.php');
        exit();
	  }  
	endforeach;
	
	


	
foreach ($admins as $admin): //checkong data from adminpwd
$pwdHash = $admin['pwdHash'];
$login = $admin['login'];
  if (password_verify($userpwd,$pwdHash) && $userlogin == $login /*$userpwd == $pwdHash && $userlogin == $login*/){ // case when entered data match with database data
		header('Location: mike/project/TryDelete.php');
        exit();
	  }  
	endforeach;	
	
	
	

$error_message = 'Incorrect login or password. Please try again.<br>'; // case if data not mactch
include ('login.html');	
exit();



?>