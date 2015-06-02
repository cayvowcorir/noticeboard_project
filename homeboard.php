<?php
/*********************************

Author: Kevin Kibet Korir
Date Created: 12/10/2014

**********************************/
$index="index.php";
$username=$_GET['u_na'];
$user_no=$_GET['u_no'];
$avatar_no=$_GET['a_no'];
$avatar_isset=$_GET['a_set'];
$user_info_no=$_GET['u_i_no'];
$name="uid";
$value=$username;
$expiry=time()+(10);
if(!isset($_COOKIE['logged_out'])){
	setcookie($name, $value, $expiry);
	session_start();
}
else{
	header("Location:".$index);
	session_destroy();
}
	


 
echo<<<END
<!DOCTYPE html>
	<html>
		<head>
		<meta charset="utf-8">
		<title>$username-Noticeboard</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0">
		<meta name="description" content="">
		<meta name="author: Kevin" content="">
		<!--link rel="stylesheet/less" href="less/bootstrap.less" type="text/css" /-->
		<!--link rel="stylesheet/less" href="less/responsive.less" type="text/css" /-->
		<!--script src="js/less-1.3.3.min.js"></script-->


		<link href="css/bootstrap.css" rel="stylesheet">
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
		<script type="text/javascript" src="js/trunk8.js"></script>		
		<script type="text/javascript" src="js/javascript.js"></script>
		<script type="text/javascript" src="js/dropzone.js"></script>
		<script type="text/javascript" src="js/jquery-ui.js"></script>
		<script type="text/javascript" src="js/readmore.js"></script>
		<script type="text/javascript" src="js/typeahead.js"></script>



		
	</head>
	<body onload="load_avatar($avatar_isset);">		

		<div class="container">
			<div class="row clearfix">
				<div class="col-md-12 column">
					<div class="row clearfix">
						<div class="col-md-11 column top_bar">
							<ul class="nav nav-pills menu_buttons">
								<a href="#" class='home_button'><img src="images/notice_background.jpg" class="logo pull-left"></a>
								<li class="active">
									<a href="#" class="menu_button home_button"></i>Home</a>
								</li>
								<li>
									<a href="#" class="menu_button">Profile</a>
								</li>
								<li class="dropdown">
									<a href="#" role="button" id="post_notice" class="menu_button dropdown-toggle" data-toggle='dropdown'>Post Notice<span class="caret"></span></a>
								  	<ul class="dropdown-menu">
									    <!-- dropdown menu links -->
									    <li>
									    	<a href="#" id="text_notice">Text Notice</a>										
									    </li>

									    <li>
									    <a href="#" id="image_notice">Image Notice</a>
									    </li>

									    <li>
									    	<a href="#" id="audio_notice">Audio Notice</a>
									    </li>
								  	</ul>
								</li>
								<li class="">
									<a href="#" class="menu_button" id='menu_notice_boards'>Notice Boards</a>									
								</li>
								<li class="">
									<a href="#" class="menu_button" id="contact_us">Contact Us</a>
								</li>

								<li class="">
									<div class="input-append">
										<input class="span2 typeahead" id="search" type="text" placeholder='Search...'>
										<span class="add-on"><a href='#'><img width='30px' height='30px' src='images/search_image.jpg'</img></a></span>
									</div>
								</li>

								<div class="pull-right"><button type="button" class="btn btn-warning pull-right" id="logout">Logout</button></div>
							</ul>
							
						</div>
					</div>

					<div class="row clearfix main_content">
						<div class="col-md-4 column side_bar">
							<ul class="nav nav-pills">
								<li class="active">
									<a href="#"> <span class="badge pull-right" id='number_of_notices'></span> Notices</a>
								</li>
								<li>
									<a href="#"> <span class="badge pull-right">0</span> Following</a>
								</li>
								<li>
									<a href="#"> <span class="badge pull-right">0</span> Blog</a>
								</li>
							</ul>
							<a href="#modal-container-625298" id="modal-625298" data-toggle="modal"></a>

							<div class="panel-group" id="accordion">
								<div class="panel panel-default">
									<div class="panel-heading">
										<a class="panel-title collapsed" id="notifications" data-toggle="collapse" data-parent="#panel-55795" href="#">Notifications</a>
										<p><div id="inner_notifications"></div></p>									
									</div>									
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<a class="panel-title collapsed" id="messages" data-toggle="collapse" data-parent="#panel-55795" href="#">Messages</a>
										<p><div id="inner_messages"></div></p>
									</div>
								</div>
								<div class="panel panel-default">
									<div class="panel-heading">
										<a class="panel-title" data-toggle="collapse" id="settings" data-parent="#panel-55795" href="#">Account Settings</a>
										<div id="inner_settings"></div>
									</div>
								</div>
							</div>
						</div>


						<div class="col-md-8 column main">

							<div class="col-md-8 column hidden" id="upload_avatar">
								<form action="phplib/upload_avatar.php" method="post" class="dropzone hidden" id="avatar_upload" enctype="multipart/form-data">
									<input type="hidden" name="avatar_no" id="avatar_no" value="$avatar_no">
									<input type="hidden" name="code" value='2010'>
									<button type='submit' class='btn btn-block btn-info' id='submit_avatar'>Submit Profile pic</button>
								</form>
							</div>

							<div class="drop_down_sort">
								<select class="drop_down_sort" name='notice_type_loaded' id='notice_type_loaded'>								
										<option value='text_notices'>
											<a href="" class="text_notices">Text notices</a>
										</option>
										<option value='audio_notices'>
											<a href="" class="audio_notices">Audio notices</a>
										</option>
										<option value='image_notices'>
											<a href="#" class="image_notices">Image notices</a>
										</option>
										
								</select>
							</div>

							<div id="notices" class='row'>
							</div>

							<div id="new_noticeboard" class='row'>
							</div>

							<div id='about_us' class='hidden'>
								<h2>Four dudes, two ladies...Making Stuff</p>
								<h3>Who we are</h3>
								<p>We are a group of programmers who have scaled the limits and have a yearning for success in coding. Our main 
								aim is to make sure we provide unique code to the world, code that is clean, efficient, easy to understand, and as modular 
								as possible</p>
								<h3>Inception</h3>
								<p>The group was concieved and ideas born, and the end result was a tight group of programmers, who employ the concept of 
								modularization as much as possible.</p>
								<h3>This website</h3>
								<p>Coined within a matter of days and implemented on a very, very busy schedule, the design and implementation of this website has 
								exceeded any expectation as far as time utilization is concerned. In less than a week, alot of stuff has been done, and the result is
								this spectacular website.</p>
							</div>

							<div id="noticeboards" class='row'>
							</div>

							<div id="loading" class='row'>
							</div>

							<div id="notice_upload" class='row'>
							</div>

							<div id="error" class='row'>
							</div>

							<div class="col-md-8 column hidden" id="contact_us_form">
								<form class="form-horizontal form-group">
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

							<div class="add_content">
							</div>
								
							
						</div>
						
					</div>
					<div class="row clearfix footer">
						<div class="col-md-12 column">
						<address> <strong>The Notice-Board Project, Inc.</strong><br> P.O. Box 1 Juja,<br> Nairobi, Kenya<br> <abbr title="Phone">Phone:</abbr> +254 712-345678</address>
					</div>
					<div class="text-center bottom_links">
						<a href="#" id="policy">Privacy Policy</a>||<a href="#">Terms Of Service</a>||<a href="#" class="menu_button" id="contact_us">Contact Us</a>||<a href="#" id='about_us_menu' class="menu_button">About us</a>
					</div>
				</div>
			</div>
		</div>
	</div>



	<!--------Modal 3[Profile _image]---------!-->
	<div class="modal fade" id="modal-container-625298" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel">
						Profile Pic
					</h4>
				</div>
				<div class="modal-body" id="image_preview">
					
				</div>
				<div class="modal-footer">
					 <button type="button" class="btn btn-default" data-dismiss="modal">Close</button> 
					 <button type="button" id="change_avatar" data-dismiss="modal" class="btn btn-primary">Change Profile Pic</button>
				</div>
			</div>
			
		</div>
		
	</div>

	<!--------Modal 4[change_password]---------!-->
	<div class="modal fade" id="modal-container-625299" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true">
		<div class="modal-dialog">
			<div class="modal-content">
				<div class="modal-header">
					 <button type="button" class="close" data-dismiss="modal" aria-hidden="true">×</button>
					<h4 class="modal-title" id="myModalLabel">
						Change Password
					</h4>
				</div>
				<div class="modal-body">
					<div class="control-group text-center" id="div_original_pass">
					  <label class="control-label" for="original_password">Enter the old password</label>
					  <div class="controls">
					    <span class="help-inline hidden" id="wrong_password">Wrong password</span>
					    <span class="help-inline hidden" id="password_valid">Password Ok</span>
					    <input type="password" id="original_password">
					    
					  </div>
					</div>

					<div class="control-group text-center" id="div_new_pass">
					  <label class="control-label" for="new_password">Enter the new password</label>
					  <div class="controls"><span class="help-inline hidden" id="password_ok">Password Ok</span>
					    <span class="help-inline hidden" id="password_not_ok">The password is less than 6 characters</span>
					    <input type="password" id="new_password">					    
					  </div>
					</div>

					<div class="control-group text-center" id="div_new_pass2">
					  <label class="control-label" for="new_password2">Repeat the new password</label>
					  <div class="controls">
					  	<span class="help-inline hidden" id="password_mismatch">The Passords don't match</span>
					  	<span class="help-inline hidden" id="password_match">The Passords match</span>
					    <input type="password" id="new_password2">			
					  </div>
					</div>

				</div>
				<div class="modal-footer">
					 <button type="button" class="btn btn-default" data-dismiss="modal">Cancel</button> 
					 <button type="button" id="confirm_pass_change" data-dismiss="modal" class="btn btn-primary">Change Password</button>
				</div>
			</div>
			
		</div>
		
	</div>


	<!-----------Popovers--------------!-->
	<div class="popover" id="popover_alerts"></div>


	<div class="hidden" id="user_no">$user_no</div>	
	<div class="hidden" id="username">$username</div>
	<div class="hidden" id="user_info_no">$user_info_no</div>

</body>
</html>
END;
?>
