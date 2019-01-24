<?php
include 'include/db.php';
include 'include/session.php';
include 'include/function.php';
ConfirmLogin();

if (isset($_GET['id'])){
	$getidfromurl = $_GET['id'];
	$stat = $con->prepare("DELETE FROM categories WHERE id = $getidfromurl ");
	$stat->execute();
	$count = $stat->rowCount();
			if ($count > 0){
				$_SESSION['SuccessMessage'] ="Category Deleted Successfully";
                redirect_to('categories.php');
		}else {
					$_SESSION['ErroMessage'] ="Something Wont Rong ,Try Again";
                redirect_to('categories.php');
		}
}
?>