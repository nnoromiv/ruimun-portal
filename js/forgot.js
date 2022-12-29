$(document).ready(function(){});
	$('#response').text("");
	$(document).on('submit', '#signin', function(event){
		$("#submit").html('<img src="user/assets/images/utility/spinner.gif" class="py-1">&nbsp;&nbsp;processing');
		$("#submit").prop('disabled', true);
		$('#response').text("");
		event.preventDefault();
		$.ajax({
			url:"user/assets/scripts/forgot",
			method:"POST",
			data:new FormData(this),
			contentType:false,
			processData:false,
			dataType:"json",
			success:function(data){
				if (data.success) {
					window.location = 'resetcode?request_from=reset&email='+data.mail+'&token='+data.token;
				}else{
					$('#response').text(data.error);
					$("#submit").prop('disabled', false);
					$("#submit").html("Reset");
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				console.log(`The error is ${XMLHttpRequest} with a status ${textStatus}, throw it as ${errorThrown}`);
		    	$("#submit").prop('disabled', false);
				$("#submit").html("Reset");
				$('#response').text("Network error, please try again");
		  	}
		});
	});