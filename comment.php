<?php
include 'include/db.php';
include 'include/session.php';
include 'include/function.php';
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
 				<li><a href="dashborad.php">
 				<span class="glyphicon glyphicon-th"></span>
 				&nbsp; Dashborad</a></li>
 				<li><a href="addnewpost.php">
                <span class="glyphicon glyphicon-list-alt"></span>
 				&nbsp;Add New Post </a></li>
 				<li><a href="categories.php">
                <span class="glyphicon glyphicon-tags"></span>
 				&nbsp;Categories</a></li>
 				<li><a href="admin.php">
                <span class="glyphicon glyphicon-user"></span>
 				&nbsp;Manage Admin</a></li>
 				<li class="active"><a href="comment.php">
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
 <h1>Un Approve Comments</h1>
 	<div class="table-responsive">
 		<table class="table table-striped table-hover">
 			<tr>
	 			<th>No.</th>
				<th>Name</th>
				<th>Date</th>
				<th>Comment</th>
				<th>Approve</th>
				<th>Delete Comment</th>
				<th>Details</th>
 			</tr>

<?php
		$stat = $con->prepare("SELECT * FROM comment WHERE Status = 'off' ORDER BY datatime DESC");
		$stat->execute();
		$comments = $stat->fetchAll();
		$srno= 0;
		foreach($comments as $comment){
        $srno++;
        if (strlen($comment['name']) > 10) {$comment['name'] = substr($comment['name'], 0, 10) . '....' ;}
        if (strlen($comment['comment']) > 18) {$comment['comment'] = substr($comment['comment'], 0, 18) . '....' ;}
			?>
			<tr>
				<td><?php echo $srno ;?></td>
				<td style="color: #5e5eff;"><?php echo $comment['name'] ;?></td>
				<td><?php echo $comment['datatime'] ;?></td>
				<td><?php echo $comment['comment'] ;?></td>
				<td><a href="approve.php?id=<?php echo $comment['id'] ?> "><span class="btn btn-success">Approve</span></a></td>
				<td><a href="delete.php?id=<?php echo $comment['id'] ?>"><span class="btn btn-danger">Dlelete</span></a></td>
				<td><a href="fullpost.php?id=<?php echo $comment['admin_panel_id']; ?>" target='_balnk'><span class="btn btn-primary">Live Peview</span></a></td>
			</tr>


			<?php }?>
 		</table>
 	</div>



 	<h1>Approve Comments</h1>
 	<div class="table-responsive">
 		<table class="table table-striped table-hover">
 			<tr>
	 			<th>No.</th>
				<th>Name</th>
				<th>Date</th>
				<th>Comment</th>
				<th>Approved By</th>
				<th>Dis Approve</th>
				<th>Delete Comment</th>
				<th>Details</th>
 			</tr>

   <?php
   
		$stat = $con->prepare("SELECT * FROM comment WHERE Status = 'on' ORDER BY datatime DESC");
		$stat->execute();
		$comments = $stat->fetchAll();
		$srno= 0;
		foreach($comments as $comment){
        $srno++;
        if (strlen($comment['name']) > 10) {$comment['name'] = substr($comment['name'], 0, 10) . '....' ;}
        if (strlen($comment['comment']) > 18) {$comment['comment'] = substr($comment['comment'], 0, 18) . '....' ;}
			?>
			<tr>
				<td><?php echo $srno ;?></td>
				<td style="color: #5e5eff;"><?php echo $comment['name'] ;?></td>
				<td><?php echo $comment['datatime'] ;?></td>
				<td><?php echo $comment['comment'] ;?></td>
				<td><?php echo $comment['approvedby'] ;?></td>
				<td><a href="disapprove.php?id=<?php echo $comment['id'] ?>"><span class="btn btn-warning">Dis Approve</span></a></td>
				<td><a href="delete.php?id=<?php echo $comment['id'] ?>"><span class="btn btn-danger">Dlelete</span></a></td>
				<td><a href="fullpost.php?id=<?php echo $comment['admin_panel_id'];  ?>" target='_balnk'><span class="btn btn-primary">Live Peview</span></a></td>
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