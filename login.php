<?php
require_once("include/db.php");
require_once("include/session.php");
require_once ("include/function.php");

if (isset($_POST['submit'])){
	$username =filter_var($_POST['username'],FILTER_SANITIZE_STRING);
	$password = $_POST['password'];

	
	$admin = 'Afaf Gomaa';
	if (empty($username) || empty($password)){
		$_SESSION['ErroMessage'] ="All Filed are required";
                redirect_to('login.php');

	}else {
	$check_user = login_attempt($username, $password);
	$stat = $con->prepare("SELECT * FROM rejustration WHERE username = ? AND password = ? ");
	$stat->execute(array($username, $password));
	$rows = $stat->fetchAll();
	foreach($rows as $row){
      	 $_SESSION['User_Id'] = $row['id'];
		 $_SESSION['User_Name'] = $row['username'];
	}



		if ($check_user){

				$_SESSION['SuccessMessage'] ="Welcom {$_SESSION['User_Name']} " ;
                redirect_to('dashborad.php');
		}else {
					$_SESSION['ErroMessage'] ="invalied username or password";
                redirect_to('login.php');
		}
	}
	
}

?>



<!DOCTYPE html>
<html>
<leng = en>
	<head>
		
		<title> Login</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/admin.css"/>
		<link rel="stylesheet" href="css/puplic.css"/>


	</head>
	<style>
		
		body {
			background-color: #fff;
		}
	</style>
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

			</div>
		</div>
	</nav>
	<div style="height:10px; background-color: #27aae1;"></div>

 <div class="container-fluid">
 	<div class="row">
 		<div class="col-sm-offset-4 col-sm-4">
 			<br><br><br><br>
 			   <div><?php
 			           echo Message();
                       echo SuccessMessage();
 			 ?></div>
 			<h2>Welcom Back !</h2>

				 <form action="login.php" method="post">
				 	<fieldset>
				 		<div class="form-group">
	                        <label class="filedinfo" for="username">Username</label>
	                       <div class="input-group input-group-lg">
	                       	<span class="input-group-addon">
	                       		<span class="glyphicon glyphicon-envelope text-primary"></span>
	                       	</span>
					 		<input class="form-control" type="text" name="username" id="username" placeholder="username">
				 	      </div>
				 	   </div>
				 	   	<div class="form-group">
	                      <label class="filedinfo" for="password">Password</label>
	                      <div class="input-group input-group-lg">
	                        <span class="input-group-addon">
	                       		<span class="glyphicon glyphicon-lock text-primary"></span>
	                       	</span>
					 		<input class="form-control" type="password" name="password" id="password" placeholder="password">
					 		</div>
				 	   </div>

				 	   <br>
				 	   <input class="btn btn-info btn-block btn-lg" type="submit" name="submit" value="Login">
				 	   <br>
				 	</fieldset>

				 </form>

<br>
 		</div><!-- End of main page -->
 	</div><!-- End of row -->
 


	
</div><!-- End of container -->	
</body>



</html>