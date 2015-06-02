$(document).ready(function(){

	//to load the options to the dropdown
	$.ajax({
		type: "POST",
		url: 'phploaddata.php',
		data: {option: 'option'},
		success: function(data){
			//assuming the data comes in json format
			var response=jQuery.parseJSON(data);
			$.each(response.value, function(key,data){
				$('#opt_group').html('<option>'+data+'</option>');
			});
			
		}
	});

	//on form submit 
	$('#submit').on('click', function(){

		//values from the form
		var first_name=$('#first_name').val();
		var last_name=$('#last_name').val();
		var username=$('#username').val();

		//values sent to server
		$.ajax({
			type: "POST",
			data: {"firstName": first_name, "lastName":last_name, "userName":username},
			url: 'phpfile.php',
			success: function(){
				alert('success');
			}
		});
		
	});
	
})
