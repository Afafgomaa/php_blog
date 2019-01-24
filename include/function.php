<?php
require_once("include/db.php");
require_once("include/session.php");

function redirect_to($new_location){
		header('location:' .$new_location);
		exit();
}

function login_attempt($username, $password){
    global $con;
	$stat = $con->prepare("SELECT * FROM rejustration WHERE username = ? AND password = ? ");
	$stat->execute(array($username, $password));
	$data = $stat->fetchAll();
	$count = $stat->rowCount();
	if ($count){
		return $data;
	}else {
		return null;
	}
}

function login(){
	if (isset($_SESSION['User_Id'])){
		return true;
	}
}


function ConfirmLogin() {
	if (!login()){
		$_SESSION['ErroMessage'] ="Login Required";
                redirect_to('login.php');
	}
}
?>

