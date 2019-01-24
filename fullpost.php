<?php

include 'include/db.php';
include 'include/session.php';
include 'include/function.php';

if (isset($_POST['submit'])){
	$name =filter_var($_POST['name'],FILTER_SANITIZE_STRING);
	$email =filter_var($_POST['email'],FILTER_VALIDATE_EMAIL);
	$comment =filter_var($_POST['comment'],FILTER_SANITIZE_STRING);
	date_default_timezone_get("Africa/Cairo");
	$current =time();
	$time =strftime("%Y-%m-%d  %H:%M:%S",$current);
	$id = $_GET['id'];

	if (empty($name) || empty($email) || empty($comment)){

		$_SESSION['ErroMessage'] ="All Filed are required";

                

	}elseif (strlen($comment) > 500){

		$_SESSION['ErroMessage'] ="Only 500 Chararcters Allowed in Comment";

                
	}else {
		
		$postIdFromUrl = $_GET['id'];
		$stat= $con->prepare("INSERT INTO comment(datatime, name, email, comment, approvedby, status, admin_panel_id) 
			                  VALUES(:ztime ,:zname, :zemail, :zcomment, 'panding', 'off', :zadmin_panel_id) ");
        $stat->execute(array(':ztime'  => $time,
                     ':zname'          => $name,
                     ':zemail'         => $email,
                     ':zcomment'       => $comment,
                     ':zadmin_panel_id'=> $postIdFromUrl ));

		$count = $stat->rowCount();
		if ($count > 0){
				$_SESSION['SuccessMessage'] ="Comment Submited Successfully";
                redirect_to("fullpost.php?id={$id}");
		}else {
					$_SESSION['ErroMessage'] ="Something Wont Rong ,Try Again";
                redirect_to("fullpost.php?id={$id}");
		}
	}
	
}

?>


<!DOCTYPE html>
<html>
<leng = en>
	<head>
		
		<title>Full Blog Post</title>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="css/bootstrap.min.css"/>
		<script src="js/jquery-3.3.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>
		<link rel="stylesheet" href="css/puplic.css"/>

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
				<li class="active"><a href='blog.php'>Blog</a></li>
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
	<div style="height:10px; background-color: #27aae1;margin-top: -20px;">
		<div class="container">
			<div class="blog-header">
				<h1>The Complete Responsive CMS Blog</h1>
				<p class="lead">The Complete Blog Using PHP | | By Afaf Gomaa</p>
			</div>
			<div class="row">
				<div class="col-sm-8">
                      <?php

                            if (isset($_GET['searchbutton'])){
                            	$search ="%". $_GET['search'] . "%";

                            	$stat = $con->prepare('SELECT * FROM
                            	                                     adminPanel 
                            	                       WHERE 
                            	                                     title 
                            	                       LIKE 
                            	                                     :search
                            	                        OR 
                            	                                     datatime 
                            	                        LIKE 
                            	                                     :search
                            	                        OR
                            	                                     category
                            	                        LIKE 
                            	                                     :search
                            	                        OR 
                            	                                      author
                            	                        LIKE 
                            	                                      :search
                            	                        OR 
                            	                                       post
                            	                        LIKE 
                            	                                       :search');
                            	$stat->execute(array(':search' => $search));
                            	$stat->fetchAll();

                            	
                            }else{

                            
                            $getid = $_GET['id'];
                            $stat = $con->prepare("SELECT * FROM adminPanel WHERE id = ?  ORDER BY datatime DESC");}
                            $stat->execute(array($getid));
                            $adminData = $stat->fetchAll();

                            foreach($adminData as $admin){
                             $image =  $admin['iamge'] ;
                             $title =  $admin['title'] ;
                             $cat   =  $admin['category'];
                             $post  =  $admin['post'];
                             $id    =  $admin['id'];

                            
                            	


                            ?>
            <div> <?php 
 			           echo Message();
                       echo SuccessMessage();
 			       ?>
 			 	
 			 </div>
                     <div class="bloepost thumbnail">
                     	<img class="img-responsive img-rounded" src="uplodes/<?php echo  $image ;?>">
                     	<div class="caption">
                     		<h1 id="heading"><?php echo htmlentities($title);?></h1>
                     		<p class="description">Category:<?php echo $cat ?> puplished at :<?php
                                echo $admin['datatime'];
                     		?></p>
                     		<p class="post"><?php echo nl2br($post) ?></p>
                     	</div>

                     </div>
                     <?php }?>
                     <br><br>
                     <br><br>


                     
                     <?php
                     $postidforcomment = $_GET['id'];
                     $stat = $con->prepare("SELECT * FROM comment WHERE admin_panel_id = ? AND Status = 'on' ");
                     $stat->execute(array($postidforcomment));
                     $getRecoreds = $stat->fetchAll();
                     foreach($getRecoreds as $record){?>
                    <div class="custom">
                    	<img class="pull-left" src="img/m.jpg" width="70px" height="80px">
                    	<p class="comment-info"><?php echo $record['name'] ;?></p>
                    	<p class="description"><?php echo $record['datatime']; ?></p>
                    	<p class="comment"><?php echo nl2br($record['comment']) ;?></p>
                    </div>
<br>
<hr>
                    <?php } ?>


                     <span class="filedinfo" style="color: #449D44">Share Your Thoughs About This Post</span><br>
                     <span class="filedinfo" style="color: #449D44">Comment</span>
                     <br><br>
                
         <form action="fullpost.php?id=<?php echo $id ?>" method="POST">
				 	<fieldset>
				 		<div class="form-group">
	                      <label class="filedinfo" for="name">Name :</label>
					 		<input class="form-control" type="text" name="name" id="name" placeholder="Name">
                        </div>
                        <div class="form-group">
	                      <label class="filedinfo" for="email">Email :</label>
					 		<input class="form-control" type="email" name="email" id="email" placeholder="email">
                        </div>
					 	<div class="form-group">
	                      <label class="filedinfo" for="commentarea">Post :</label>
					 		<textarea class="form-control" name="comment" id="commentarea"></textarea> 
					 	</div>
				 	   
				 	   <br>
				 	   <input class="btn btn-success" type="submit" name="submit" value="Submit">
				 	   <br>
				 	   <br>
				 	</fieldset>

				 </form>



				</div>
				<div class="col-sm-offset-1 col-sm-3">
					<h2>About me</h2>
					<img class="img-responsive img-circle imgeicon" src="img/afaf img.jpeg">
					<p style="text-align: justify;">I am full stack web developer with 8 months of experience .
I am most experienced with psd-to html and css and make responsive with bootstrap or media query .I have a little
Experience with javascript and jquery , and i
make 2 <a href="https://slachstl.000webhostapp.com/" target="_blank"> (This First One)</a>website with  php +mysql. 
My goal with every website I make I made is to take care of every small details  because that is makes different. Look for an opportunity to develop my skills in the web world, I have the ability to learn new things and develop my skills and I Looking  for an opportunity to internship .
</p>

					<div class="panel panel-primary">
						<div class="panel-heading">
							<h2 class="panel-title">
								Categoryies
							</h2>
						</div>
						<div class="panel-body">
							<?php
                             $stat = $con->prepare("SELECT * FROM categories ORDER BY datatime DESC");
                             $stat->execute();
                             $cats = $stat->fetchAll();
                             foreach($cats as $cat){?>
                     <a href="blog.php?category=<?php echo $cat['name'] ; ?>">
                         <span id="heading"><?php echo $cat['name'] ; ?></span><br>
                     </a>
                            <?php }


							?>
						</div>
						<div class="panel-footer">
							
						</div>
					</div>


					<div class="panel panel-primary">
						<div class="panel-heading">
							<h2 class="panel-title">
								Recent Post
							</h2>
						</div>
						<div class="panel-body background">
						<?php
                             $stat = $con->prepare("SELECT * FROM adminpanel ORDER BY datatime DESC LIMIT 0,5");
                             $stat->execute();
                             $admins = $stat->fetchAll();
                             foreach($admins as $admin){
                             	$id   = $admin['id'];
                             	$data = $admin['datatime'];
                             	if (strlen($data) > 11){$data = substr($data, 0,11);}
                             	?>

                             	<div>

                             	   <img class="pull-left" style="margin-top: -11px; margin-left: 10px;" src="uplodes/<?php echo $admin['iamge'] ?>" width="70px" height="70px">
                             	   <a href="fullpost.php?id=<?php echo $id ?>">
                             	   <p id="heading" style="margin-left:90px"> <?php echo htmlentities($admin['title']); ?> </p></a>
                             	   <p class="description" style="margin-left:90px "><?php echo htmlentities($data); ?> </p>
                             	   <hr>
                                </div>  
                            <?php }


							?>
						</div>
						<div class="panel-footer">
							
						</div>
					</div>


				</div>
			</div>
		</div>


 <div id="footer">
 	<hr><p>Theme By | Afaf Gomaa |&copy 2018 --- All right reservied.
 	
 	<a style="color: #fff; text-decoration: none; cursor: pointer;font-weight: bold;" href="Dashborad.php"></a>
 	this second web site i have Made </p>
 	<hr>
</div>

<div style="height: 10px; background-color:#27AAE1"></div>	
</body>
</html>
