<?php
include 'include/db.php';
include 'include/session.php';
include 'include/function.php';
ConfirmLogin();
if (isset($_POST['submit'])){
	$cat_name =filter_var($_POST['category'],FILTER_SANITIZE_STRING);
	date_default_timezone_get("Africa/Cairo");
	$current =time();
	$time=strftime("%Y-%m-%d  %H:%M:%S",$current);
	
	$admin = $_SESSION['User_Name'];
	if (empty($cat_name)){
		$_SESSION['ErroMessage'] ="All Filed are required";
                redirect_to('categories.php');
	}elseif (strlen($cat_name) > 99){
		$_SESSION['ErroMessage'] ="Too long String";
                redirect_to('categories.php');
	}else {
		global $con;
		$stat= $con->prepare("INSERT INTO categories(name, datatime,creatname) VALUES(:zcat_name,:ztime,:zcreatname)");
		$stat->execute(array(':zcat_name' => $cat_name,':ztime' => $time, 'zcreatname' => $admin));
		$count = $stat->rowCount();
		if ($count > 0){
				$_SESSION['SuccessMessage'] ="inserted Succsufully";
                redirect_to('categories.php');
		}else {
					$_SESSION['ErroMessage'] ="failed to Add";
                redirect_to('categories.php');
		}
	}
	
}

?>



<!DOCTYPE html>
<html>
<leng = en>
	<head>
		
		<title>Admin Deashborad</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/admin.css"/>
	</head>
<body>
	<div style="height:10px; background-color: #27aae1;">
		
	</div>
	<nav class="navbar navbar-inverse" role="navigation">
		<div class="container">
			<div class="navbar-header">
				<button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#collapse">
					<span class="sr-only">toggle navigatio</span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>
					<span class="icon-bar"></span>

				</button>
				<a class='navbar-brand' href="blog.php" width="200px" height="20px;"> Afaf Gomaa</a>
			</div>
			<div class="collapse navbar-collapse" id="collapse">
			<ul class="nav navbar-nav">
				<li><a href='#'>home</a></li>
				<li class="active"><a href='blog.php' target="_balnk">Blog</a></li>
				<li><a href='#'>About Us</a></li>
				<li><a href='#'>Serevices</a></li>
				<li><a href='#'>Contact Us</a></li>
				<li><a href='#'>Features</a></li>
			</ul>
			<form action="blog.php" class="navbar-form navbar-right">
				<div class="form-group">
					<input type="text" class="form-control" name="search" placeholder="Search">
				</div>
				<button class="btn btn-default" name="searchbutton">Go</button>
				
			</form>
			</div>
		</div>
	</nav>
	<div style="height:10px; background-color: #27aae1;"></div>

 <div class="container-fluid">
 	<div class="row">
 		<div class="col-sm-2">
 			<h1>admin</h1>
 			<nav id="side_menu" class="nav nav-pills nav-stacked">
 				<li><a href="dashborad.php">
 				<span class="glyphicon glyphicon-th"></span>
 				&nbsp; Dashborad</a></li>
 				<li><a href="addnewpost.php">
                <span class="glyphicon glyphicon-list-alt"></span>
 				&nbsp;Add New Post </a></li>
 				<li class="active"><a href="categories.php">
                <span class="glyphicon glyphicon-tags"></span>
 				&nbsp;Categories</a></li>
 				<li><a href="admin.php">
                <span class="glyphicon glyphicon-user"></span>
 				&nbsp;Manage Admin</a></li>
 				<li><a href="comment.php">
                <span class="glyphicon glyphicon-comment"></span>
 				&nbsp;Comments</a></li>
 				<li><a href="blog.php?page=1" target="_balnk">
                <span class="glyphicon glyphicon-equalizer"></span>
 				&nbsp;Live Blog</a></li>
 				<li><a href="logout.php">
                <span class="glyphicon glyphicon-log-out"></span>
 				&nbsp;Log Out</a></li>
 			</nav>
 		</div><!-- End of side par -->
 		<div class="col-sm-10">
 			<h1>Manage Category</h1>
 			    <div><?php
 			           echo Message();
                       echo SuccessMessage();
 			 ?></div>
				 <form action="categories.php" method="post">
				 	<fieldset>
				 		<div class="form-group">
	                      <label for="catname">Name</label>
					 		<input class="form-control" type="text" name="category" id="catname" placeholder="Name">
					 		
				 	   </div>
				 	   <br>
				 	   <input class="btn btn-success btn-block" type="submit" name="submit" value="Add New Category">
				 	   <br>
				 	</fieldset>

				 </form>

<div class="table-responsive">
	<table class="table table-striped table-hover">
		<tr>
			<th>Sr No</th>
			<th>Category Name</th>
			<th>Date & Time</th>
			<th>Admin Ceartor</th>
            <th>Delete</th>
		</tr>
		<?php
		$stat = $con->prepare("SELECT * FROM categories ORDER BY datatime DESC");
		$stat->execute();
		$cats = $stat->fetchAll();
		$srno = 0;
		
		foreach($cats as $cat){?>
			
		<tr>
			<td><?php echo  $srno++; ?></td>
			<td><?php echo $cat['name'] ; ?></td>
			<td><?php echo $cat['datatime'] ; ?></td>
			<td><?php echo $cat['creatname'] ; ?></td>
			<td><a href="deleteCategory.php?id=<?php echo $cat['id'] ?>">
				<span class="btn btn-danger">Delete</span>
                </a>
			</td>
		</tr>
		

		<?php }?>

	</table>
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