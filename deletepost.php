<?php
include 'include/db.php';
include 'include/session.php';
include 'include/function.php';
ConfirmLogin();

		
$deletePostFromUrl = $_GET['delete'];

$stat = $con->prepare("DELETE FROM adminPanel WHERE id = ? ");
$stat->execute(array($deletePostFromUrl));
		$count = $stat->rowCount();
		move_uploaded_file($_FILES['image']['tmp_name'], $target);
		if ($count > 0){
				$_SESSION['SuccessMessage'] ="Post Deleted Successfully";
                redirect_to('dashborad.php');
		}else {
					$_SESSION['ErroMessage'] ="Something Wont Rong ,Try Again";
                redirect_to('editpost.php');
		}


?>



<!DOCTYPE html>
<html>
<leng = en>
	<head>
		
		<title> Delete Post</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/admin.css"/>
	</head>
<body>
 <div class="container-fluid">
 	<div class="row">
 		<div class="col-sm-2">
 			<h1>admin</h1>
 			<nav id="side_menu" class="nav nav-pills nav-stacked">
 				<li><a href="dashborad.php">
 				<span class="glyphicon glyphicon-th"></span>
 				&nbsp; Dashborad</a></li>
 				<li class="active"><a href="addnewpost.php">
                <span class="glyphicon glyphicon-list-alt"></span>
 				&nbsp;Add New Post </a></li>
 				<li><a href="categories.php">
                <span class="glyphicon glyphicon-tags"></span>
 				&nbsp;Categories</a></li>
 				<li><a href="deashborad.php">
                <span class="glyphicon glyphicon-user"></span>
 				&nbsp;Manage Admin</a></li>
 				<li><a href="comment.php">
                <span class="glyphicon glyphicon-comment"></span>
 				&nbsp;Comments</a></li>
 				<li><a href="blog.php">
                <span class="glyphicon glyphicon-equalizer"></span>
 				&nbsp;Live Blog</a></li>
 				<li><a href="deashborad.php">
                <span class="glyphicon glyphicon-log-out"></span>
 				&nbsp;Log Out</a></li>
 			</nav>
 		</div><!-- End of side par -->
 		<div class="col-sm-10">
 			<h1>delete Post</h1>


 			 </div>






 		</div><!-- End of main page -->
 	</div><!-- End of row -->
 </div><!-- End of container -->


 <div id="footer">
 	<hr><p>Theme By | Afaf Gomaa |&copy 2018 --- All right reservied.
 	
 	<a style="color: #fff; text-decoration: none; cursor: pointer;font-weight: bold;" href="Dashborad.php"></a>
 	this second web site i have Made </p>
 	<hr>
</div>

<div style="height: 10px; background-color:#27AAE1"></div>		
</body>



</html>