<?php
include 'include/db.php';
include 'include/session.php';
include 'include/function.php';
ConfirmLogin();


if (isset($_GET['id'])){
	$getidfromurl = $_GET['id'];
	$stat = $con->prepare("DELETE FROM rejustration WHERE id = $getidfromurl ");
	$stat->execute();
	$count = $stat->rowCount();
			if ($count > 0){
				$_SESSION['SuccessMessage'] ="Admin Deleted Successfully";
                redirect_to('admin.php');
		}else {
					$_SESSION['ErroMessage'] ="Something Wont Rong ,Try Again";
                redirect_to('admin.php');
		}
}
?>