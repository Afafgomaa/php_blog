<?php
$host = 'localhost';
$user = 'root';
$pass = '';
$dbname = 'phpcms';

try{
	$con = new PDO("mysql:host=$host;dbname=$dbname",$user,$pass);
	$con->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

}catch(PDOException $e){
	die('opps');
    $e->getMessage();

}



?>