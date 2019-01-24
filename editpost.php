<?php
include 'include/db.php';
include 'include/session.php';
include 'include/function.php';
ConfirmLogin();
if (isset($_POST['submit'])){
	$title =filter_var($_POST['title'],FILTER_SANITIZE_STRING);
	$category =filter_var($_POST['category'],FILTER_SANITIZE_STRING);
	$post =filter_var($_POST['post'],FILTER_SANITIZE_STRING);
	date_default_timezone_get("Africa/Cairo");
	$current =time();
	$time=strftime("%Y-%m-%d  %H:%M:%S",$current);
	$admin ='Afaf Gomaa';
	$image =$_FILES['image']['name'];
	$target = 'uplodes/'.basename($_FILES['image']['name']);
	if (empty($title)){
		$_SESSION['ErroMessage'] ="All Filed are required";
                redirect_to('addnewpost.php');
	}elseif (strlen($title) < 2){
		$_SESSION['ErroMessage'] ="Too short title";
                redirect_to('addnewpost.php');
	}elseif (empty($_FILES['image'])) {
		echo 'imge rquirefd';
	}else {
		
		$EditPostFromUrl = $_GET['edit'];

$stat = $con->prepare("UPDATE adminPanel SET datatime = ? , category = ?, title	= ? , author = ?, iamge = ?, post = ? WHERE id = ? ");
$stat->execute(array($time, $category, $title, $admin, $image, $post, $EditPostFromUrl));

		$count = $stat->rowCount();
		move_uploaded_file($_FILES['image']['tmp_name'], $target);
		if ($count > 0){
				$_SESSION['SuccessMessage'] ="Post Updated Successfully";
                redirect_to('dashborad.php');
		}else {
					$_SESSION['ErroMessage'] ="Something Wont Rong ,Try Again";
                redirect_to('editpost.php');
		}
	}
	
}

?>



<!DOCTYPE html>
<html>
<leng = en>
	<head>
		
		<title> Edit Post</title>
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
 				<li><a href="deashborad.php">
                <span class="glyphicon glyphicon-comment"></span>
 				&nbsp;Comments</a></li>
 				<li><a href="blog.php?page=1" target="_balnk">
                <span class="glyphicon glyphicon-equalizer"></span>
 				&nbsp;Live Blog</a></li>
 				<li><a href="deashborad.php">
                <span class="glyphicon glyphicon-log-out"></span>
 				&nbsp;Log Out</a></li>
 			</nav>
 		</div><!-- End of side par -->
 		<div class="col-sm-10">
 			<h1>Edit Post</h1>
 			    <div><?php
 			           echo Message();
                       echo SuccessMessage();

                  
                  $SearchQueryParameter = $_GET['edit'];

                    $stat = $con->prepare("SELECT * FROM adminPanel WHERE id = ?");
                    $stat->execute(array($SearchQueryParameter));
                    $rows = $stat->fetchAll();
                    foreach($rows as $row){

                    }

 			 ?></div>
				 <form action="editpost.php?edit=<?php echo $SearchQueryParameter ?>" method="post" enctype="multipart/form-data">
				 	<fieldset>
				 		<div class="form-group">
	                      <label for="title">Name</label>
					 		<input class="form-control" type="text" name="title" id="title" value="<?php echo $row['title'];?>" >
					 	<div class="form-group">
	                      <label for="category">category:</label>
	                      <select class="form-control" id="category" name="category" >
	                      	
	    <?php
		$stat = $con->prepare("SELECT * FROM categories ORDER BY datatime DESC");
		$stat->execute();
		$cats = $stat->fetchAll();
               
		 foreach($cats as $cat){
               if ($cat['name'] == $row['category']){
                $select = 'selected';
                    
                    
                   }else{
                   	$select = '';
                   }
                   	
                   echo "<option value={$cat['name']} {$select}>{$cat['name']}</option>";
		}
?>
	                      </select>
					 		
					 	</div>
					 	<div class="form-group">
	                        <label for="image">Image
                                   <img src="uplodes/<?php echo  $row['iamge'] ?>" width="130px" height="50px">
	                        </label>
					 		<input class="form-control" name="image" type="file"  id="image">
					 	</div>
					 	<div class="form-group">
	                      <label for="postarea">Post</label>
					 		<textarea class="form-control" name="post" id="postarea" rows="10" style="text-align: justify;">
					 			<?php echo $row['post'] ;?>
					 		</textarea> 
					 	</div>
				 	   </div>
				 	   <br>
				 	   <input class="btn btn-success btn-block" type="submit" name="submit" value="Update Post">
				 	   <br>
				 	</fieldset>

				 </form>


		<?php
		$stat = $con->prepare("SELECT * FROM categories ORDER BY datatime DESC");
		$stat->execute();
		$cats = $stat->fetchAll();
		$srno = 0;
		
		foreach($cats as $cat){
			


		 }
		 ?>


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