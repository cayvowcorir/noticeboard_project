$(document).ready(function(){
	
	//to load options on the dropdown
	$.ajax({
		type: "POST", 
		url: 'load_daa.php',
		data: {Type:'load_location'},
		success: function(data){
			alert(data);
			var response = jQuery.parseJSON(data);
			$.each(response.value, function(key,data){
				$('#route').html('<option>'+data+'</option>');
			});
		}
	});
	
	$('#submit').on('click', function(){

		$.ajax({
		type: "POST", 
		url: 'load_daa.php',
		data: {Type:'load_location'},
		success: function(data){
			alert(data);
			var response = jQuery.parseJSON(data);
			$.each(response.value, function(key,data){
				$('#route').html('<option>'+data+'</option>');
			});
		}
	});
		
		var name = $('#name').val();
		
		//alert(name);
		/*
		//values sent to server
		$.ajax({
			type:"POST",
			data:{"name": name, "name": name},
			url:'',
			success: function(){
				alert('success');
			}	
		});**/
	});

});
