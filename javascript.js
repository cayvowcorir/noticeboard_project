/*********************************

Author: Kevin Kibet Korir
Date Created: 12/10/2014

**********************************/


//Global variables
var user_file="phplib/user.php";
var user_setup= "phplib/setup.php"//contains all user transactions
var data_file="phplib/html_data.php";//contains html documents
var homeboard="homeboard.php";//user page for logged in users
var image_location="phplib/avatarmedium/";
var upload_notice="phplib/notice.php";
var create_noticeboard="phplib/noticeboard.php";
var landing_page="index.php";

//index page popovers
$(document).ready(function(){
	$('.menu_button_prohib').popover();
	$('.carousel').carousel('cycle');	
})

/***************************************************

			to login/logout a user

***************************************************/
$(document).on("click", "#login", function(){
	var username=$("#user_login").val();
	var password=$("#pass_login").val();
	$.ajax({
		type: "POST",
		url: user_file,
		data: { 'Type': 'login_user', 'User_name': username, 'User_pass': password },
		success: function(data){
			var response=jQuery.parseJSON(data); 
			if(response.res>0){
				var user_no=response.res;
				user_info(user_no);
			}
			else{
				$("#popover_alerts").html("Sorry. Wrong username/password combination").dialog({
					title: "Error",
					modal: true
				});
			}
		}
	});
});

//logout
$(document).on("click", "#logout", function(){
	$(location).attr("href", landing_page+"?logout=true");
});


/***************************************************

			to create an account

****************************************************/

//to display the signup form

	$(document).ready(function(){
		$("#sign_up").on("click", function(){
			$.ajax({
				url: data_file,
				type: "POST",
				data: {"document": "sign_up_form"},
				success: function(data){
					$('#upload_avatar, #upload_avatar, .drop_down_sort, #error, #notices, #noticeboards').fadeOut();
					$('#about_us, #contact_us_form').addClass('hidden');
					$('.add_content').html(data).fadeIn();
				}
			});
		});
	});

//email validation

$(document).on("change", "#email", function () {
	var e_mail=$("#email").val();
	var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
    if (!(filter.test(e_mail))) {
    	$(".email_validation").html("<p class='error'>Please enter a valid email address</p>");
    }
    else{
    	$(".email_validation").empty();
    }						
});		

//check for username availability

	$(document).on("change", "#username", function(){
		var user=$(this).val();
		if(user.length<4){
			$("#display_availability").html("<p class='error'>The username should be more than four characters</p>");
		}
		else{
			$.ajax({
				type: "POST",
				url: user_file,
				data: { "Type": "username_exists", "User_name": user},
				success: function(data){
					resp=jQuery.parseJSON(data);

					if(resp.res==0){
						$("#display_availability").html("<p class='success'>The username is available</p>");
					}
					else{
						$("#display_availability").html("<p class='error'>Sorry, the username has been taken</p>");
					}
				}
			})
		}
	});

//Password validation

	$(document).on("keyup", "#password", function(){
		$('#warning').remove();
		var pass=$('#password');
		if (pass.val().length<6) {
			message=document.getElementById("pwords").innerHTML="<p1 class='text-warning' id='warning'>The Password must be more than six charaters</p1>";
			return message;
		}
	});
	$(document).on("change" ,"#confirm_password", function(){
		$('#warning').remove();
		var pass2=$('#confirm_password');
		if(pass2.val()!=($('#password').val())){
			message=document.getElementById('pwords').innerHTML="<p1 class='warning' id='warning'>The Passwords do not match</p1>";
			return message;
		}

	});	
	

//to check the sign-up form for empty fields; else create account

	$(document).on("click", "#submit2", function(e){
		e.preventDefault();
		var name=$("#name").val();
		var uname=$("#username").val();
		var e_mail=$("#email").val();
		var pword=$("#password").val();
		var pword2=$("#confirm_password").val();
		var agree=$("#agrement").is(':checked');

		if((name=="")||(uname=="")||(e_mail=="")||(pword=="")||(pword2=="")||(agree==false)){
			$(".message").html("<p class='error text-center'>Oops! You have left something out</p>");
		}

		else{
			$.ajax({
				type: "POST",
				url: user_file,
				data: { "Type": "add_user", "User_name": uname, "Email": e_mail, "User_pass": pword },
				success: function(data){
					var resp=jQuery.parseJSON(data);
					var user_no=resp.no;
					if(resp.res==1){
						user_info(user_no);						
					}
					else{
						$(".message").html("<p class='text-warning text-center'>Something went wrong... :( ...Please try again</p>");
					}
				}
			});
		}
	});


/*****************************************

User Homeboard

******************************************/
//getting all the user info specific to the user
function user_info(data){
	var user_no=data;
	$.ajax({
		type: "POST",
		url: user_setup,
		data: {"Type": "setup", "User_no": user_no},
		success: function(data){
			var response=jQuery.parseJSON(data);
			var username= response.user_name;
			var user_info_no= response.user_info_no;
			var avatar_isset=response.avatar.is_set;
			var avatar_no=response.avatar_no;			
			var url=homeboard+"?u_na="+username+"&u_no="+user_no+"&a_no="+avatar_no+"&a_set="+avatar_isset+"&u_i_no="+user_info_no;		
			var new_location=$(location).attr("href", url);	


		}
	})	

}
//function to load the avatar
function load_avatar(data){
	var avatar_isset=data;
	if(avatar_isset==1){
		var user_no=$("#user_no").html();
		$.ajax({
			type: "POST",
			url: user_setup,
			data: {"Type": "setup", "User_no": user_no},
			success: function(data){
				var response=jQuery.parseJSON(data);
				var avatar_no=response.avatar_no;
				var avatar_location=image_location+avatar_no+".jpg";
				$("#modal-625298").html("<img alt='profile_image' id='profile_image_preview' src='"+avatar_location+"' class='img-thumbnail' width='250' height='250'>");
				$("#image_preview").html("<img alt='profile_image' id='profile_image' src='"+avatar_location+"' class='img-thumbnail' width='500' height='200'>");
			}
		});	
	}
	else{
		$("#modal-625298").html("<img alt='profile_image' id='profile_image_preview' src='phplib/avatarmedium/default_avatar.png' class='img-thumbnail' width='250' height='250'>");
		$("#image_preview").html("<img alt='profile_image' id='profile_image' src='phplib/avatarmedium/default_avatar.png' class='img-thumbnail' width='400' height='200'>");
	}

}

// display form for changing the avatar
$(document).on("click", "#change_avatar", function(){
	$('#error, #notices, #noticeboards').fadeOut('slow');
	$('#about_us, #contact_us_form').addClass('hidden');
	$("#upload_avatar, #avatar_upload").removeClass("hidden").fadeIn("slow");
})

//change avatar

function avatar_upload_response(data){
	var response=jQuery.parseJSON(data);
	var user_no=$("#user_no").html();
	if(response.success==1){
		$("#submit_avatar").on("click", function(e){
			e.preventDefault();
			$(".add_content").html("Profile image successfully updated").dialog({
				modal: true,
				title: "Success",
				close: function(){user_info(user_no);}
			});
		})
	}
	else{
		$(".add_content").html("Oops! Something went wrong. Please try again. Note that the images must not exceed 2 MB").dialog({
			modal: true,
			title: "Error",
			close: function(){location.reload();}
		});
		
	}
}
/**************************************************

Main menu items

**************************************************/

//contact us
$(document).on("click", "#contact_us", function(){
	$.ajax({
		url: data_file,
		type: "POST",
		data: {"document": "contact_us"},
		success: function(data){
			$(' #upload_avatar, #notices, #noticeboards').empty();
			$('#about_us, .drop_down_sort, #error').addClass('hidden');
			$('#contact_us_form').removeClass('hidden').fadeIn();
		}
	});
})


//about us menu
$(document).on('click', '#about_us_menu', function(){
	$('.add_content, #notices, #noticeboards').empty();
	$('#contact_us_form, .drop_down_sort, #error').addClass('hidden');
	$('#about_us').removeClass('hidden');


});

/**************************************************

side-bar items

**************************************************/


$(document).ready(function(){

	$('#inner_settings, #inner_notifications, #inner_messages').hide();
	$('#notifications').on("click", function(){
		$('#inner_notifications').html("here is some crap").slideToggle(500);
	});
	$('#messages').on("click", function(){
		
		$('#inner_messages').slideToggle(500);

	});	
	$('#settings').on("click", function(){
		var html="";
		html+="<div class='account_settings'><br>";
		html+="<p class='one'><a href='#' class='text-info' id='general_settings'>General settings</a></p>";
		html+="<p><a href='#' class='text-info' id='security_settings'>Security settings</a></p>";
		html+="<p><a href='#' class='text-info' id='privacy_settings'>Privacy</a><br><br>";
		html+="</div>";
		$('#inner_settings').html(html);
		$('#inner_settings').slideToggle(500);

		
	});

});

//to load the general settings form into the main view

$(document).on("click", '#general_settings', function(){
	$('#error, #notices, #noticeboards').fadeOut('slow');
	$('#about_us, #contact_us_form').addClass('hidden');
	html="";
	html+="<form><div class='general_settings_inner'>";
	html+="<div id='general_settings_message text-center'></div> "
	html+="<p class='change_username'>Userame: </p><hr>";
	html+="<p class='change_password'>Password: <a href='#modal-container-625299' class='preview_details' role='button' id='modal-625299' data-toggle='modal'>Click to change</a> <span class='ui-icon hidden pull-right ui-icon-pencil'></span></p><hr>";
	html+="<p data-toggle='tooltip' title='Click to change values' class='change_email'>Email: <span class='ui-icon hidden pull-right ui-icon-pencil'></span></p><input type='text' id='new_email' class='hidden text-info form-control general_settings_input'><hr>";	
	html+="<p data-toggle='tooltip' title='Click to change values' class='change_name'>Full Name: <span class=' hidden ui-icon pull-right ui-icon-pencil'></span></p><input type='text' id='full_name' class='hidden text-info form-control general_settings_input'><hr>";	
	html+="<p data-toggle='tooltip' title='Click to change values' class='change_phone'>Phone: <span class='ui-icon hidden pull-right ui-icon-pencil'></span></p><input type='text' placeholder='+[code][number]i.e +254 71098183' id='new_phone' class='hidden text-info form-control general_settings_input'><hr>";
	html+="<input type='submit' class='btn btn-block btn-info disabled' value='Submit' id='change_info_btn'><hr>";
	html+="</form>";
	$('.add_content').html(html).fadeIn('slow');

	//to add tooltip
	$('.change_name, .change_email, .change_phone').on('mouseover, mouseout').tooltip();

	//displaying the user info from the server
	var user_no=$("#user_no").html();
		$.ajax({
			type: "POST",
			url: user_setup,
			data: {"Type": "setup", "User_no": user_no},
			success: function(data){
				var response=jQuery.parseJSON(data);
				var username=response.user_name;
				var phone=response.user_info.phone;
				var email=response.user_info.email;
				var name=response.user_info.fullname;
				if((username=="")){
					username="Not Set";
				}
				if((phone=="")){
					phone="Not Set";
				}
				if((email=="")){
					email="Not Set";
				}
				if((name=="")){
					name="Not Set";
				}
				$(".change_name").append('<p class="preview_details">'+name+'</p>');
				$(".change_username").append('<p class="preview_details">'+username+'</p>');
				$(".change_phone").append('<p class="preview_details">'+phone+'</p>');
				$(".change_email").append('<p class="preview_details">'+email+'</p>');
			}
		})


//to change passwords
	$("#original_password").on("change", function(){
		var password=$(this).val();
		var username=$("#username").html();
			$.ajax({
				type: "POST",
				url: user_file,
				data: { 'Type': 'login_user', 'User_name': username, 'User_pass': password },
				success: function(data){
					var response=jQuery.parseJSON(data); 
					if(response.res>0){
						$("#wrong_password").addClass("hidden");
						$("#div_original_pass").removeClass("error").addClass("success");
						$("#password_valid").removeClass("hidden");
						$("#confirm_pass_change").removeClass('disabled');
					}
					else{
						$("#password_valid").addClass("hidden");
						$("#wrong_password").removeClass("hidden");
						$("#div_original_pass").removeClass("success").addClass("error");
						$("#confirm_pass_change").addClass('disabled');
					}
				}
			});
	})

	//check length of new password
	$("#new_password").on("change", function(){
		var password=$(this).val();
		if(password.length<6){
			$("#password_not_ok").removeClass("hidden");
			$("#div_new_pass").removeClass("success").addClass("error");
			$("#password_ok").addClass("hidden");
			$("#confirm_pass_change").addClass('disabled');
		}
		else{

			$("#password_not_ok").addClass("hidden");
			$("#password_ok").removeClass("hidden");
			$("#div_new_pass").removeClass("warning").addClass("success");
			$("#confirm_pass_change").removeClass('disabled');
		}
	})

	//check if the passwords match
	$("#new_password2").on("keyup", function(){
		var password2=$(this).val();
		var password=$("#new_password").val();
		if(password2!=password){
			$("#password_match").addClass("hidden");
			$("#password_mismatch").removeClass("hidden");
			$("#div_new_pass2").removeClass('success').addClass("error");
			$("#confirm_pass_change").addClass('disabled');
		}
		else{
			$("#password_match").removeClass("hidden");
			$("#password_mismatch").addClass("hidden");
			$("#div_new_pass2").removeClass('error').addClass("success");
			$("#confirm_pass_change").removeClass('disabled');
		}
	})


})

 
//on-mouse-over event for general settings to add icon

$(document).on('mouseover', '.change_name, .change_email, .change_password, .change_phone', function(){
	$(this).children('span').removeClass("hidden");
});

//on mouse out event to remove icon
$(document).on('mouseout', '.change_name, .change_email, .change_password, .change_phone', function(){
	$(this).children('span').addClass("hidden");
});

//to display the input field
$(document).on("click", '.change_name, .change_email, .change_phone', function(){
	$(this).siblings().removeClass("hidden");
});

//to make changes to user info
$(document).on("keyup", "#full_name, #new_email, #new_phone", function(){
	if(($("#full_name").val()!='')&&($("#new_mail").val()!='')&&($("#new_phone").val()!='')){
		$("#change_info_btn").removeClass("disabled");
	}
	else{
		$(".email_validation").empty();
		$("#change_info_btn").addClass("disabled");
	}
})

//validate email
$(document).on('change', '#new_email', function(){

	var filter = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
	if(!(filter.test($('#new_email').val()))) {
	    $("#general_settings_message").html("<p class='error'>Please enter a valid email address</p>");
	    $("#change_info_btn").addClass("disabled");
	}
	else{
		$("#general_settings_message").empty();
		$("#change_info_btn").removeClass("disabled");
	}
})
	
	
$(document).on("click", "#change_info_btn", function(e){
	e.preventDefault();
	var fullname=$("#full_name").val();
	var email=$("#new_email").val();
	var phone=$("#new_phone").val();
	var user_info_no=$("#user_info_no").html();

	$.ajax({
		type: 'POST',
		url: user_file,
		data: {"Type": "update_info", "User_info_no": user_info_no, "Fullname": fullname, "Phone": phone, "Email": email },
		success: function(data){
			var response=jQuery.parseJSON(data); 
			if(response.res==1){
				$('#popover_alerts').html("You have successfully changed your info. Thank you").dialog({
					modal: true,
					title: "success",
					close: function(){
						location.reload();
					}
				});
			}
			else{
				$("#general_settings_message").html("Oops! Something went wrong. Please try again");
			}
		}

	});

	
})

	



/*********************************************

		uploading notices

**********************************************/

//dropdown to choose the type of notice

$(document).ready(function(){
	$('#post_notice').on('focus', function(){
		$(this).dropdown();
	})
})

$(document).ready(function(){
	$('#load_notice_boards').autocomplete({
		source: 'phplib/search.php'
	});	
})


//to load text notice upload form
$(document).on("click", "#text_notice", function(){
	$('.modal').detach();
	$('.modal-backdrop').detach();
	$('#upload_avatar, .drop_down_sort, #error, #notices, #noticeboards').effect('puff');
	$('#about_us, #contact_us_form').addClass('hidden');
	load_notice_uploadform('text_notice');
	
});

//to load image notice upload form
$(document).on("click", "#image_notice", function(){
	$('.modal').detach();
	$('.modal-backdrop').detach();
	$('#upload_avatar, .drop_down_sort, #upload_avatar, #error, #notices, #noticeboards').effect('puff');
	$('#about_us, #contact_us_form').addClass('hidden');
	load_notice_uploadform('image_notice');
	
});

//to load audio notice upload form
$(document).on("click", "#audio_notice", function(){
	$('.modal').detach();
	$('.modal-backdrop').detach();
	$('#upload_avatar, #upload_avatar, .drop_down_sort, #error, #notices, #noticeboards').effect('puff');
	$('#about_us, #contact_us_form').addClass('hidden');
	load_notice_uploadform('audio_notice');
	
});

//common function to load all the notice upload forms
function load_notice_uploadform(data){
	var type=data;
	$.ajax({
		type: "POST",
		url: data_file,
		data: {"document": "upload_notice"},
		success: function(data){
			$(".add_content").html(data);
			if(type=='text_notice'){
				$('#additional').empty();
				$('#submit_notice').on('click', function(e){
					e.preventDefault();
					upload_text_notice();
				})
			}
			else if(type=='audio_notice'){
				$('#additional').attr('data-content', 'Audio files must be in mp3 format');
				$('#additional').popover();
				$('#additional').append("<input type='hidden' name='code' value='2010'>");
				$('#upload_notice').attr('action', 'phplib/upload_notice_audio.php');
			}
			else{
				$('#additional').attr('data-content', 'Image notices must be in jpeg format');
				$('#additional').popover();
				$('#additional').append("<input type='hidden' name='code' value='2010'>");
				$('#upload_notice').attr('action', 'phplib/upload_notice_image.php');
			}
		}
	});

}


//to submit the form for uploading text notices

function upload_text_notice(){
	var type=$("input:radio[name=Type_no]").val();
	var noticeboard_no= $("#noticeboard_no").val();
	var title=$("#notice_title").val();
	var desc=$("#notice_description").val();
	var expiry=$("#expiry_date").val();

	if((type=='')||(noticeboard_no=='')||(title=='')||(desc=='')||(expiry=='')){
		$("#notice_upload_message").html("You have left one or more fields");
	}
	else{
		$.ajax({
			type: "POST",
			url: upload_notice,
			data: { "Type": "add_notice", "Noticeboard_no": noticeboard_no, "Type_no": type, "Title": title, "Desc": desc, "Date_expiry": expiry}, 
			success: function(data){			
				var response=jQuery.parseJSON(data);
				if(response.res==1){
					$("#popover_alerts").html("The notice has been added. Thank you").dialog({
						title: "Success",
						modal: "true",
						close: function(){
							location.reload();
						}
					});					
				}
				else{
					$("#notice_upload_message").html("Oops! :( Something went wrong. Please try again");
				}
				
			}
		});
	}
}


//datepicker for the form

$(document).on("mouseover", "#expiry_date", function(){
	$("#expiry_date").datepicker({
		dateFormat: 'yy-mm-dd',
		numberOfMonths: 3
	});
});




/*******************************************

			Making a notice-board

********************************************/
$(document).on("click", "#create_noticeboard", function(){
	$.ajax({
		type: "POST",
		url: data_file,
		data: {"document": "make_notice_board"},
		success: function(data){
			$('.modal').detach();
			$('#upload_avatar, #upload_avatar, .drop_down_sort, #error, #notices, #noticeboards').effect('puff');
			$('#about_us, #contact_us_form').addClass('hidden');
			$(".add_content").html(data).slideDown("slow");
		}
	});
});

$(document).on("click", "#create_noticeboard_submit", function(event){
	event.preventDefault();
	var type=$("input:radio[name=notice_type_no]:checked").val();
	var title=$("#noticeboard_title").val();
	var desc=$("#noticeboard_description").val();
	var user_no=$("#user_no").html();

	if((type=='')||(title=='')||(desc=='')){
		$("#noticeboard_message").html("<p class='error text-center'>You have left out a field</p>");
	}
	else{
		$.ajax({
			type: "POST",
			url: create_noticeboard,
			data: {"Type": "add_noticeboard", "User_no": user_no , "Type_no": type , "Title": title , "Desc": desc },
			success: function(data){
				var response=jQuery.parseJSON(data);
				var notice_avatar_no=response.avatar_no;
				$("#noticeboard_message").html("Noticeboard has been created succesfully").dialog({
					title: "Success",
					modal: "true",
					close: function(){
						location.reload();
					}
				});
			}
		});
	}
});


/***************************************************************

				LOADING NOTICES AND NOTICEBOARDS

****************************************************************/

$(document).ready(function(){

	$('.home_button').on('click', function(){location.reload();});

	var user_no=$("#user_no").html();

	$('#notice_type_loaded').on('change', function(){
		var fieldval=$('#notice_type_loaded').val();
		if(fieldval=='text_notices'){	
			load_text_notices();
		}
		else if(fieldval=='audio_notices'){
			load_audio_notices();
		}
		else{
			load_image_notices();
		}
	});	

	//loading animation before notices load NB for illustration purposes only
	//the default type of notices loaded are text notices
	$('.add_content').empty();
	$('.add_content').html("<img id='loading-anim' src='images/loader.gif'>");	

	setTimeout(function(){load_text_notices()}, 3000);
	

	//load text notices
	function load_text_notices(){
		$('#notices').empty();
		$.ajax({
			type: "POST",
			url: user_setup,
			data: {"Type": "setup", "User_no": user_no },
			beforeSend: function(){$('.add_content').html("<img id='loading-anim' src='images/loader.gif'>");},
			success: function(data){
				var response=jQuery.parseJSON(data);				
				var no_of_noticeboards= response.noticeboards.count;
				
				if(no_of_noticeboards=='0'){
					$('#error').html("<p class='error' id='no_notices'>Ooops! Its lonely in here... Create a noticeboard, <br>then upload your notices... or follow a noticeboard</p>")
				}
				else{
					//number of  notices
					$('#number_of_notices').html(4);

					var count1=0;			
					while(count1<no_of_noticeboards){	//filter the noticeboards into different types(public, request, private)
						var noticeboard_type=response.noticeboards[count1].type;									
						var notice_count=response.noticeboards[count1].notices.count;
						var notice_count_total=0;
						notice_count+=notice_count_total;
						console.log(notice_count);					
						var count2=0;
						while(count2<notice_count){     //filter the notices into different types(public, request, private)
							//variables to hold the notices from the selection statement below
							var htmldata= {
								notices: [],
								count: []
							};
							var notice_type=response.noticeboards[count1].notices[count2].type;
							if(notice_type=='1'){ //all public notices												
								var notice_title=response.noticeboards[count1].notices[count2].title;
								var notice_desc=response.noticeboards[count1].notices[count2].desc;
								var notice_date_added=response.noticeboards[count1].notices[count2].date_added;
								var notice_date_expiry=response.noticeboards[count1].notices[count2].date_expiry;														
								var html="<div class='thumbnail col-md-4' style='height:150px;overflow:hidden; text-overflow:ellipsis;'><button class='close pull-right'>&times;</button>";
								html+="<div><a class='pull-left' href='#'><img class='media-object' src='images/notice_text.png' width='64' height='64'></a></div>";
								html+="<div class='media-body'><h4 class='media-heading'>"+notice_title+"</h4>";
								html+="<div id='desc'><div id='preview'><span class='toTrim'>"+notice_desc+"</span></div></div>";
								html+="<div id='date_added' class='pull-left'> Date Added: "+notice_date_added+"</div>";
								html+="<div id='date_added' class='pull-right'> Expiry Date: "+notice_date_expiry+"</div>";
								html+="</div></div>";

								//divide into even and odd groups for easy arrangements	

									htmldata.notices.push(html);
									htmldata.count.push(count2);
								
							}

							count2++;
							$('.add_content').empty();
							for (var i=0; i<4; i++){
								var data=htmldata.notices.pop();
								$('#notices').prepend(data);

							};

						

							
						}
						
						count1++	 				 
					};
				}
			}
		})
	}

	//load image notices
	function load_image_notices(){
		$('#notices').empty();

		if(no_of_noticeboards=='0'){
			$('#error').html("<p class='error' id='no_notices'>Ooops! Its lonely in here... Create a noticeboard, <br>then upload your notices... or follow a noticeboard</p>")
		}
		else{
			$.ajax({
				type: "POST",
				url: user_setup,
				data: {"Type": "setup", "User_no": user_no },
				beforeSend: function(){$('.add_content').html("<img id='loading-anim' src='images/loader.gif'>");},
				success: function(data){
					var response=jQuery.parseJSON(data);				
					var no_of_noticeboards= response.noticeboards.count;				
					var count1=0;			
					while(count1<no_of_noticeboards){	//filter the noticeboards into different types(public, request, private)
						var noticeboard_type=response.noticeboards[count1].type;				
						var notice_count=response.noticeboards[count1].notices.count;
						var count2=0;
						while(count2<notice_count){     //filter the notices into different types(public, request, private)
							//variables to hold the notices from the selection statement below
							var htmldata= {
								notices: []
							};
							var notice_type=response.noticeboards[count1].notices[count2].type;
							var notice_ext=response.noticeboards[count1].notices[count2].file_ext;

							//all public notices of type image

							if((notice_type=='1')&&(notice_ext==(('jpg')||('gif')||('png')))){ 										
								var notice_title=response.noticeboards[count1].notices[count2].title;
								var notice_desc=response.noticeboards[count1].notices[count2].desc;
								var notice_date_added=response.noticeboards[count1].notices[count2].date_added;
								var notice_date_expiry=response.noticeboards[count1].notices[count2].date_expiry;														
								var html="<div class='thumbnail col-md-4'><button class='close pull-right'>&times;</button>";
								html+="<div><a class='pull-left' href='#'><img width='300' height='120' class='media-object' src='phplib/noticeimage/"+count2+".jpg'></a></div>";
								html+="<div class='caption'><h3>"+notice_title+"</h3>";
								html+="<div id='desc'><div id='preview'><p>"+notice_desc+"</p></div></div>";
								html+="<div id='date_added' class='pull-left'> Date Added: "+notice_date_added+"</div>";
								html+="<div id='date_added' class='pull-left'> Expiry Date: "+notice_date_expiry+"</div>";
								html+="</div></div>";


								//push to the variable
								
									htmldata.notices.push(html);
								
							}

							count2++;

							//loop through of the entries into the variable and display in order, starting from the latest

							$('.add_content').empty();
							$.each(htmldata, function(key, data){
								$('#notices').prepend(data);
							});
							
						}
						
						count1++	 				 
					};
					
				}
			})
		}
	}

	//load audio notices
	function load_audio_notices(){
		$('#notices').empty();
		if(no_of_noticeboards=='0'){
			$('#error').html("<p class='error' id='no_notices'>Ooops! Its lonely in here... Create a noticeboard, <br>then upload your notices... or follow a noticeboard</p>")
		}
		else{
			$.ajax({
				type: "POST",
				url: user_setup,
				data: {"Type": "setup", "User_no": user_no },
				beforeSend: function(){$('.add_content').html("<img id='loading-anim' src='images/loader.gif'>");},
				success: function(data){
					var response=jQuery.parseJSON(data);				
					var no_of_noticeboards= response.noticeboards.count;
					var count1=0;			
					while(count1<no_of_noticeboards){	//filter the noticeboards into different types(public, request, private)
						var noticeboard_type=response.noticeboards[count1].type;					
						var notice_count=response.noticeboards[count1].notices.count;
						var count2=0;
						while(count2<notice_count){     //filter the notices into different types(public, request, private)
							//variables to hold the notices from the selection statement below
							var htmldata= {
								notices: []
							};
							var notice_type=response.noticeboards[count1].notices[count2].type;
							var notice_ext=response.noticeboards[count1].notices[count2].file_ext;

							//all public notices	of type image

							if((notice_type=='1')&&(notice_ext==(('mp3')||('wav')||('3gp')))){ 										
								var notice_title=response.noticeboards[count1].notices[count2].title;
								var notice_desc=response.noticeboards[count1].notices[count2].desc;
								var notice_date_added=response.noticeboards[count1].notices[count2].date_added;
								var notice_date_expiry=response.noticeboards[count1].notices[count2].date_expiry;														
								var html="<div class='thumbnail col-md-4'><button class='close pull-right'>&times;</button>";
								html+="<div><a class='pull-left' href='#'><img width='300' height='120' class='media-object' src='phplib/noticeimage/"+count2+".jpg'></a></div>";
								html+="<div class='caption'><h3>"+notice_title+"</h3>";
								html+="<div id='desc'><div id='preview'><p>"+notice_desc+"</p></div></div>";
								html+="<div id='date_added' class='pull-left'> Date Added: "+notice_date_added+"</div>";
								html+="<div id='date_added' class='pull-left'> Expiry Date: "+notice_date_expiry+"</div>";
								html+="</div></div>";


								//push to the variable
								
									htmldata.notices.push(html);
								
							}

							count2++;

							//loop through of the entries into the variable and display in order, starting from the latest

							$('.add_content').empty();
							$.each(htmldata, function(key, data){
								$('#notices').prepend(data);
							});
							
						}
						
						count1++	 				 
					};
					
				}
			})
		}
	}

	

})

//to delete the notices that appear on the screen when the user wants to
$(document).on('click','.close', function(){
	$(this).parent().remove();
})


/************************************************

            Load a user's noticeboards

*************************************************/

$(document).on('click', '#menu_notice_boards', function(){
	var user_no=$("#user_no").html();
	
	$.ajax({
		type: "POST",
		url: user_setup,
		data: {"Type": "setup", "User_no": user_no },
		success: function(data){
			var response=jQuery.parseJSON(data);
			count1=0;
			var number_of_noticeboards=response.noticeboards.count;
			var noticeboard_data={
				data: []
			};
			while(count1<number_of_noticeboards){
				var title=response.noticeboards[count1].title;
				var description=response.noticeboards[count1].desc;
				var avatar=response.noticeboards[count1].avatar_no;

				var html="<div class='thumbnail col-md-6'><button class='close pull-right'>&times;</button>";
				html+="<div><a class='pull-left' href='#'><img width='150' height='50' class='media-object' src='images/noticeboard_icon.jpg'></div>";
				html+="<br><div class='caption'><h3>"+title+"</h3>";
				html+="<div id='desc'><div id='preview'><p>"+description+"</p></div></div>";
				html+="</a></div>";
				noticeboard_data.data.push(html);
				count1++;
			}
			$('.add_content, #notices').empty();
			$('#about_us, #contact_us_form, #error').addClass('hidden');
			$('.drop_down_sort').empty();
			$.each(noticeboard_data, function(key, data){
				$('#noticeboards').html(data);
			});
		}
	});
	
})

	


