<?php
include 'include/db.php';
include 'include/session.php';
include 'include/function.php';
ConfirmLogin();

if (isset($_GET['id'])){
	$getidfromurl = $_GET['id'];
	$stat = $con->prepare("UPDATE comment SET  Status = 'off' WHERE id = ? ");
	$stat->execute(array($getidfromurl));
	if ($stat->rowCount() > 0){
		$_SESSION['SuccessMessage'] ="Comment Approved Successfully";
                redirect_to('comment.php');
	}else {
					$_SESSION['ErroMessage'] ="Something Wont Rong ,Try Again";
                redirect_to('comment.php');
	}

}

?>