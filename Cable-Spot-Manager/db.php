<?php
try
{
  $pdo = new PDO('mysql:host=localhost;dbname=cablespotmanager_final', 'root', 'Gbi5K96JJCfU7V6O');
  $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
  $pdo->exec('SET NAMES "utf8"');
}
catch (PDOException $e)
{
  $error = 'Unable to connect to the database server.';
  include 'error.html.php';
  exit();
}