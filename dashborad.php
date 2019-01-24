<?php
require_once("include/session.php");
require_once("include/db.php");
require_once ("include/function.php");
ConfirmLogin();
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
 			<br>
 			<nav id="side_menu" class="nav nav-pills nav-stacked">
 				<li class="active"><a href="dashborad.php">
 				<span class="glyphicon glyphicon-th"></span>
 				&nbsp; Dashborad</a></li>
 				<li><a href="addnewpost.php">
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
 				&nbsp;Comments
                       	<?php

                        $stat = $con->prepare("SELECT COUNT(*) FROM comment WHERE Status = 'off' ");
                        $stat->execute();
                        $countComment = $stat->fetchColumn();
                        if ($countComment > 0){

                        ?>

                        <span class="label pull-right label-warning">
                        
                       <?php 


                       echo $countComment;

                       ?>
                        </span>

                       <?php }?>
            </a>

 			</li>
 				<li><a href="blog.php?page=1" target="_balnk">
                <span class="glyphicon glyphicon-equalizer"></span>
 				&nbsp;Live Blog</a></li>
 				<li><a href="logout.php">
                <span class="glyphicon glyphicon-log-out"></span>
 				&nbsp;Log Out</a></li>
 			</nav>
 		</div><!-- End of side par -->
 		<div class="col-sm-10">
 			<div> <?php 
 			           echo Message();
                       echo SuccessMessage();
 			 ?>
 			 	
 			 </div>
 			<h1>Admin Dashborad</h1>
<div class="table-responsive">
	<table class="table table-striped table-hover">
		<tr>
			<th>Sr No</th>
			<th>Post Tilte</th>
			<th>Date & Time</th>
			<th>Author</th>
			<th>Category</th>
			<th>Banner</th>
			<th>Comments</th>
			<th>Actions</th>
			<th>Detials</th>

		</tr>
		<?php
		$stat = $con->prepare("SELECT * FROM adminPanel ORDER BY datatime DESC");
		$stat->execute();
		$admins = $stat->fetchAll();
		$srno= 1;
		foreach($admins as $admin){?>
			
		<tr>
			<td><?php echo $srno++; ?></td>

			<td style="color:#5e5eff "><?php 
                 if (strlen($admin['title']) > 20) {$admin['title'] = substr($admin['title'], 0, 20). "...";}
                 	
			echo $admin['title'] ;
			 
			?></td>
			<td><?php echo $admin['datatime'] ; ?></td>
			<td><?php 
			 if (strlen($admin['author']) > 8) {$admin['author'] = substr($admin['author'], 0, 8). "...";}
			echo $admin['author'] ; ?>
				
			</td>
			<td><?php 
			if (strlen($admin['category']) > 8) {$admin['category'] = substr($admin['category'], 0, 8). "...";}
			echo $admin['category']  ?>
				
			</td>
			<td><img width="130px" height="60px" src="uplodes/<?php echo $admin['iamge'] ; ?>" ></td>
			<td>
				<?php

                        $stat = $con->prepare("SELECT COUNT(*) FROM comment WHERE admin_panel_id = ?  AND Status = 'on' ");
                        $stat->execute(array($admin['id']));
                        $countComment = $stat->fetchColumn();
                        if ($countComment > 0){

                        ?>

                        <span class="label pull-right label-success">
                        
                       <?php 


                       echo $countComment;

                       ?>
                        </span>

                       <?php }?>


                       	<?php

                        $stat = $con->prepare("SELECT COUNT(*) FROM comment WHERE admin_panel_id = ?  AND Status = 'off' ");
                        $stat->execute(array($admin['id']));
                        $countComment = $stat->fetchColumn();
                        if ($countComment > 0){

                        ?>

                        <span class="label  label-danger">
                        
                       <?php 


                       echo $countComment;

                       ?>
                        </span>

                       <?php }?>


				


			</td>
			<td> <a href="editpost.php?edit=<?php echo $admin['id']; ?>">
             <span class="btn btn-warning">Edit</span>
			</a>
           <a href="deletepost.php?delete=<?php echo $admin['id']; ?>">
             <span class="btn btn-danger">Delete</span>
			</a>
		</td>
			<td>
               <a href="fullpost.php?id=<?php echo $admin['id'] ?>" target="_balnk">
               	<span class="btn btn-primary">Live Perview</span>
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
 	</p>
 	<a style="color: #fff; text-decoration: none; cursor: pointer;font-weight: bold;" href="Dashborad.php"></a>
 	<p>this second web site i have Made </p>
 	<hr>
</div>

<div style="height: 10px; background-color:#27AAE1"></div>		
</body>



</html>