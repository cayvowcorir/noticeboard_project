<?php
/*********************************

Author: Kevin Kibet Korir
Date Created: 12/10/2014

**********************************/

$homeboard="http://localhost/Notice-Board project/homeboard.php";

$data=<<<END
<!DOCTYPE html>
<html lang="en">
	<head>
						<meta charset="utf-8">
						<title>Notice-Board</title>
						<meta name="viewport" content="width=device-width, initial-scale=1.0">
						<meta name="description" content="">
						<meta name="author: Kevin" content="">
		<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
		<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
		<!--script src="js/less-1.3.3.min.js"></script-->


		<link type="text/css" href="css/bootstrap.css" rel="stylesheet">
		<link rel="stylesheet" type="text/css" href="css/css.css">
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.theme.css">
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.structure.css">
		<link rel="stylesheet" type="text/css" href="css/jquery-ui.css">
		<link rel="stylesheet" type="text/css" href="css/dropzone.css">
		<link rel="stylesheet" type="text/css" href="css/bootstrap-theme.css">


		<!-- HTML5 shim, for IE6-8 support of HTML5 elements -->
		<!--[if lt IE 9]>
		<script src="js/html5shiv.js"></script>
		<![endif]-->
		<!-- Fav and touch icons -->
		<link rel="apple-touch-icon-precomposed" sizes="144x144" href="img/apple-touch-icon-144-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="114x114" href="img/apple-touch-icon-114-precomposed.png">
		<link rel="apple-touch-icon-precomposed" sizes="72x72" href="img/apple-touch-icon-72-precomposed.png">
		<link rel="apple-touch-icon-precomposed" href="img/apple-touch-icon-57-precomposed.png">
		<link rel="shortcut icon" href="img/favicon.png">
		
		<script type="text/javascript" src="js/jquery-2.1.1.js"></script>
		<script type="text/javascript" src="js/bootstrap.js"></script>		
		<script type="text/javascript" src="js/javascript.js"></script>
		<script type="text/javascript" src="js/dropzone.js"></script>
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="js/readmore.js"></script>


		
	</head>

	<body class="bg_landing">
		<div class="container">

			<!-- Top bar-->

			<div class="row clearfix">	
				<div class="col-md-11 column top_bar">
					<ul class="nav nav-pills menu_buttons">
						<a href="index.php"><img src="images/notice_background.jpg" class="logo pull-left"></a>
						<li class="">
							<a href="index.php" class="menu_button">Home</a>
						</li>
						<li>
							<a href="#" data-toggle='tooltip' data-trigger="hover" data-placement="bottom" data-title="Insufficient Rights" data-content='You have to be logged in to access this feature' class="menu_button_prohib">Profile</a>
						</li>
						<li>
							<a href="#" data-toggle='tooltip' data-trigger="hover" data-placement="bottom" data-title="Insufficient Rights" data-content='You have to be logged in to access this feature' class="menu_button_prohib">Post Notice</a>
						</li>
				
						<li>
							<a href="#" class="menu_button" id="contact_us">Contact Us</a>
						</li>

						<li>
							<a href="#" class="menu_button" id="sign_up">Sign Up</a>
						</li>
						<form class="form-inline inline_login" role="form" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<div class="input-group">
									<div class="input-group-addon">@</div>
									<input class="form-control bg_gray" id="user_login" name="user_login" type="text" placeholder="Enter username">
								</div>
							</div>
							<div class="form-group">
								<label class="sr-only" for="password2">Password</label>
								<input type="password" class="form-control bg_gray" id="pass_login" name="pass_login" placeholder="Password">
							</div>
							<div id="submit_login">
								<label class="checkbox1">
									<input type="checkbox"> Remember me
								</label>
								<button type="button" id="login" class="btn btn-info submit1">Sign in</button>
							</div>
						</form>
					</ul>
				</div>
			</div>


			<!-- Main Content-->

			<div class="row clearfix main_content">
				<div class="col-md-12 column main">

					<!-- Carousel Slider-->

					<div class="carousel slide carousel" id="carousel-160094">
						<ol class="carousel-indicators">
							<li data-slide-to="0" data-target="#carousel-160094" class="active">
							</li>
							<li data-slide-to="1" data-target="#carousel-160094">
							</li>
							<li data-slide-to="2" data-target="#carousel-160094">
							</li>
						</ol>
						<div class="carousel-inner carousel">
							<div class="item active">
								<img alt="" src="img/notice 2.jpg">
								<div class="carousel-caption">
									<h4>
									We are here for you
									</h4>
									<p>
									We save you the trouble of rushing to the noticeboard every time to check what is new...
									</p>
								</div>
							</div>
							<div class="item">
								<img alt="" src="img/notice 1.jpg">
								<div class="carousel-caption">
									<h4>
									Everything revolves around time
									</h4>
									<p>
									Time is of essence. And we are about time, and we don't want to waste yours...
									</p>
								</div>

							</div>
							<div class="item">
								<img alt="" src="img/notice 4.jpg">
								<div class="carousel-caption">
									<h4>
									All you have to do
									</h4>
									<p>
									Why burn your energy going to that crowded noticeboard and yet you can have all the notices posted on your phone?
									</p>
								</div>
							</div>
						</div> 
						<a class="left carousel-control" href="#carousel-160094" data-slide="prev"><span class="glyphicon glyphicon-chevron-left"></span></a> <a class="right carousel-control" href="#carousel-160094" data-slide="next"><span class="glyphicon glyphicon-chevron-right"></span></a>
					</div>

					<!-- User Reviews-->

					<div class="container" id='user_reviews'>
						<div class="row clearfix">
							<div class="col-md-12 column proofs">
								<blockquote>
									<p>
									This is the best thing that has ever happened to me! OMG! Am never going to the notice-board again
									</p> <small>Otii@Jkuat <cite>Review</cite></small>
								</blockquote>
								<blockquote>
									<p>
									Atleast someone had the guts to do something as amazing as this.
									</p> <small>Maryan@KU <cite>Review</cite></small>
								</blockquote>
								<blockquote>
									<p>
									If you ever see me at that crowded notice-board again, stab me with a knife. This is the in thing!!
									</p> <small>joanne@KU <cite>Review</cite></small>
								</blockquote>
								<blockquote>
									<p>
									Wow!! Work of art! Thank you so much!!
									</p> <small>Kevv@UON <cite>Review</cite></small>
								</blockquote>
							</div>
						</div>						
					</div>
				</div>	
				<div class="add_content" id="add_content_index"></div>

				<!--------Contact Us---------!-->
				<div class="hidden col-md-8 column contact_landing" id="contact_us_form">
					<form class="form-horizontal pull-center">
						<div class="form-group">
							<div class="col-md-12">
								<label for="name" class="control-label">Name</label>
								<input type="text" class="form-control" name="name" id="contact_name">
							</div>
						</div>

						<div class="form-group">
							<div class="col-md-12">
								<label for="name" class="control-label">Email</label>
								<input type="text" class="form-control" name="name" id="contact_email">
							</div>
						</div>

						<div class="form-group">
							<label class="control-label" for="description" id="message_label">Message</label>
							<div class="controls">
								<textarea rows="5" width="500" id="contact_message" placeholder="Click and drag the right bottom corner to increase size"></textarea>
							</div>
						</div>
					</form>
				</div>
			</div>


			<!-- Footer-->

			<div class="row clearfix footer">
				<div class="col-md-12 column">
					<address> <strong>The Notice-Board Project, Inc.</strong><br> P.O. Box 1 Juja,<br> Nairobi, Kenya<br> <abbr title="Phone">Phone:</abbr> +254 712-345678</address>
				</div>
				<div class="text-center bottom_links">
					<a href="" id="policy">Privacy Policy</a>||<a href="terms.html">Terms Of Service</a>||<a href="contact_us.html">Contact Us</a>
				</div>
			</div>
		</div>
	</body>


	<!-----------Popovers--------------!-->
	<div class="popover" id="popover_alerts"></div>


	

</html>
END;

if(isset($_COOKIE['uid'])){
	if(isset($_GET["logout"])){
		$logout=$_GET['logout'];
		if($logout=='true'){
			$expiry=time()+(1);
			setcookie("logged_out", "logged_out", $expiry);
			echo($data);
		}
	}
	else{ 
		$username=$_COOKIE['uid'];
		header("Location:".$homeboard."?username=".$username); //change location to homeboard
	}
}
else{

echo($data);
}


?>