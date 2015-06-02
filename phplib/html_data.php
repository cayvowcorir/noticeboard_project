<?php
if(isset($_POST)){
	$response = array();
    
    $document = $_POST['document'];    
    
    switch($document){
        
        case 'sign_up_form':         
            $response = sign_up_form();
            break; 
        case 'upload_notice':         
            $response = upload_notice();
            break; 
        case 'make_notice_board':         
            $response = make_notice_board();
            break; 
    };
	echo $response;
};

function sign_up_form(){
echo<<<END
<div class="col-md-12 sign_up_form">
	<h1 class="form_title" >Create your profile here</h1>
	<form class="form-horizontal create_account" id="form_1" name="form" method="post" enctype="multipart/form-data">
		<div>
			<div class="form-group" id="div_name">
				<div class="message"></div>
				<div class="col-md-12">
					<label for="name" class="control-label">Name</label>
					<input type="text" class="form-control" name="name" id="name">
				</div>
			</div>
			<div class="form-group" id="div_email">
				<div class="email_validation"></div>
				<div class="col-md-12">
					<label for="username" class="control-label">Email</label>
					<input type="email" class="form-control" name="email" id="email" placeholder="email@host.domain">
				</div>
			</div>
			<div class="form-group" id="div_username">
				
				<div class="col-md-6 ">
					<div id="display_availability"></div>
					<label for="username" class="control-label">Username</label>
					<input type="text" class="form-control" name="username" id="username">
				</div>
			</div>
			<div class="form-group pword1" >
				<div id="pwords"></div>
				<div class="col-md-6">
					<label for="password" class="control-label" name="password">Password</label>
					<input name="password" type="password" name="password" class="form-control" id="password">
				</div>
				<div class="col-md-6 pword2">
					<label for="password" class="control-label">Confirm Password</label>
					<input type="password" class="form-control" id="confirm_password">
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<label><input type="checkbox" id="agrement">I agree to the <a href="" >Terms of Service</a> and <a href="">Privacy Policy.</a></label>
				</div>
			</div>
			<div class="form-group">
				<div class="col-md-12">
					<input type="submit" value="Create account" id="submit2"  class="btn btn-info">
				</div>
			</div>
			
		</div>
	</form>
</div>
END;
}

function upload_notice(){
echo<<<END
	<div id="notice_upload_form" class="col-md-8 column">
	<form method="post" id="upload_notice" role="form" enctype="multipart/form-data">
	
		<div class="notice_upload_inner">
			<div id="notice_upload_message" class="text-center error"></div>
			<label for="notice_title" class="control-label" id="title_label">Title:</label>
			<input type="text" id="notice_title" name="Title">

			<div class="btn-group">
				<button class="btn btn-info" data-toggle="dropdown">Notice Type</button>
				<button class="btn btn-info dropdown-toggle" data-toggle="dropdown">
				<span class="caret"></span>				
				</button>
				<ul class="dropdown-menu">
					<blockquote><h5>
						<input type="radio" name="Type_no" value="1"> 1-Public<br>
						<input type="radio" name="Type_no" value="2"> 2-Private</h5>
					</blockquote>
				</ul>
			</div>

			<label for="Noticeboard_name" class="control-label" id="noticeboard_name_label">NoticeBoard Title:</label>
			<input type="text" name="Noticeboard_name" id="noticeboard_name" value="1" >			
			
			<hr><label for="expiry_date" class="control-label" id="expiry_label">Expiry date:</label>
			<input type="text" class="date span3" id="expiry_date" name="Date_expiry" placeholder="Click to pick date" ><br>
			<hr><label for="notice_description" class="control-label" id="description_label">A description of the notice</label>
			<textarea rows="5" width="500" name="Desc" id="notice_description" name="notice_description" placeholder="Click and drag the right bottom corner to increase size"></textarea><hr>
			<div id="additional" data-title='Please Note' data-trigger='hover' data-toggle='tooltip' data-placement='top' data-content="Image files must be in jpeg format and audio files in mp3 format">
				<input type='file' class="btn btn-large btn-block btn-info" name='file1' value='Please select a file to upload'>
			</div><hr>
			<input type="submit" class="btn btn-large btn-block btn-info" id="submit_notice" value="Submit Notice">
		</div>
	</form>
	</div>
END;
}

function make_notice_board(){
echo<<<END
<div id="make_notice_board" class="col-md-8 column main">
	<form method="post" class="form-horizontal" id="make_notice_board_form" role="form" enctype="multipart/form-data">
	<div id="noticeboard_message"></div>	
		<br><strong>Title:</strong><input type="text" class="col-md-12 text-center" id="noticeboard_title" placeholder="Enter the NoticeBoard title"><br>
		<hr>
		<div class="btn-group notice_type">
			<button class="btn btn-warning" data-toggle="dropdown">Select the type of Notice Board you want to create</button>
			<button class="btn btn-warning dropdown-toggle" data-toggle="dropdown">
			<span class="caret"></span>				
			</button>
			<ul class="dropdown-menu">
				<blockquote><h5>
					<input type="radio" name="notice_type_no" value="1"/> 1-Public<br>
					<input type="radio" name="notice_type_no" value="2"/> 2-Private<br>
					<input type="radio" name="notice_type_no" value="3"/> 3-Request</h5>
				</blockquote>
			</ul>
		</div>
		<hr>
		<div class="control-group">
			<label class="control-label text-center" for="description">Description</label>
			<div class="controls">
				<textarea rows="5" width="500" id="noticeboard_description" placeholder="Click and drag the right bottom corner to increase size"></textarea>
			</div>
		</div>
		<hr>
		<div class="control-group">
			<div class="controls">
				<button type="submit" class="btn btn-info btn-block" id="create_noticeboard_submit">Create Notice-Board</button>
			</div>
		</div>
	</form>
</div>
END;
}


?>