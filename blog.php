<?php

include 'include/db.php';
include 'include/session.php';
include 'include/function.php';
?>

<!DOCTYPE html>
<html>
<leng = en>
	<head>
		
		<title>Blog</title>
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
                                    // get query for search button is active
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

                            	// if category is active
                            }elseif(isset($_GET['category'])){
                                    $category = $_GET['category'];
                                    $stat = $con->prepare("SELECT * FROM adminpanel WHERE category = ? ORDER BY datatime DESC");
                                    $stat->execute(array($category));
                                    $date_category = $stat->fetchAll();



                            }elseif (isset($_GET['page'])) {
                            	$page = $_GET['page'];

                            	if($page == 0 || $page < 1){
                            		$showpostfrom = 0;
                            	}else{
                            	$showpostfrom = ($page*5)-5;
                            	
                                     }

                    $stat = $con->prepare("SELECT * FROM adminPanel ORDER BY datatime DESC LIMIT {$showpostfrom} ,5 ");
                            	
                            



                            }else{

                            
                            // get quiery if blog directly 
                            $stat = $con->prepare("SELECT * FROM adminPanel ORDER BY datatime DESC LIMIT 0,4 ");}
                            $stat->execute();
                            $adminData = $stat->fetchAll();

                            foreach($adminData as $admin){
                             $image =  $admin['iamge'] ;
                             $title =  $admin['title'] ;
                             $cat   =  $admin['category'];
                             $post  =  $admin['post'];
                             $id    =  $admin['id'];

                            
                            	


                            ?>
                     <div class="bloepost thumbnail">
                     	<img class="img-responsive img-rounded" src="uplodes/<?php echo  $image ;?>">
                     	<div class="caption">
                     		<h1 id="heading"><?php echo htmlentities($title);?></h1>
                     		<p class="description">Category:<?php echo $cat ?> puplished at :<?php
                                echo $admin['datatime'];
                     		?>
                     		<?php

                        $stat = $con->prepare("SELECT COUNT(*) FROM comment WHERE admin_panel_id = ?  AND Status = 'on' ");
                        $stat->execute(array($admin['id']));
                        $countComment = $stat->fetchColumn();
                        if ($countComment > 0){

                        ?>

                        <span class="padge pull-right">
                        
                       Comments:<?php 


                       echo $countComment;

                       ?>
                        </span>

                       <?php }?>	




                     		</p>
                     		<p class="post"><?php 

                             if (strlen($post) > 150){$post = substr($post,0,150). '...';}
                     		echo nl2br($post) ?></p>
                     	</div>
                  <a href="fullpost.php?id=<?php echo $id ;?>"><span class="btn btn-info">Read More &rsaquo; &rsaquo; </span></a>
                     </div>



                     <?php }?>
                 <nav>
                 	<ul class="pagination pull-left">
                 		<?php

                 		//for crating backward button
                        if (isset($page) && $page > 1){?>

                     <li><a href="blog.php?page=<?php echo $page-1 ; ?>">&laquo;</a></li>
                       <?php }

                 		?>
                     <?php
                     $stat = $con->prepare("SELECT COUNT(*) FROM adminpanel");
                     $stat->execute();
                     $total = $stat->fetchColumn();
                     $postprepage = $total/5;
                     $postprepage = ceil($postprepage);
                     //echo $postprepage;

                   for($i=1; $i<=$postprepage;$i++){
                       if ( isset($page) && $i == $page){
                       	?>
                       <li class="active"><a href="blog.php?page=<?php echo $i ; ?> "> <?php echo $i ; ?></a></li>

                      <?php }else {
                      	?>
                      	<li><a href="blog.php?page=<?php echo $i ; ?> "> <?php echo $i ; ?></a></li>

                  <?php }
                     ?>

                     
                
                 <?php }
//for crating forward button

                 ?>


                       <?php if (isset($page) && $page+1 <= $postprepage){?>

                     <li><a href="blog.php?page=<?php echo $page+1 ; ?>">&raquo;</a></li>
                       <?php }

                 		?>
                 </ul>
                 </nav>
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
						<div class="panel-body">
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
