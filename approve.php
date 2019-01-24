<?php
include 'include/db.php';
include 'include/function.php';


if (isset($_GET['id'])){
	$getidfromurl = $_GET['id'];
	$admin = $_SESSION['User_Name'];
	$stat = $con->prepare("UPDATE comment SET  Status = 'on', approvedby = '$admin' WHERE id = ? ");
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