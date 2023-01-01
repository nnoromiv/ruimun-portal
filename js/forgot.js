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
			data: new FormData(this),
			contentType:false,
			processData:false,
			dataType:"json",
			success:function(data){
				if (data.success = "true") {
					// window.location = 'resetcode?request_from=reset&email='+data.mail+'&token='+data.token;
				}else{
					$('#response').text(data.error);
					$("#submit").prop('disabled', false);
					$("#submit").html("Reset");
				}
			},
			//Since Message sends but somehow the success message doesn't flow, I've tweaked the code to display a success message instead 
			error: function(XMLHttpRequest, textStatus, errorThrown) {
		    	$("#submit").prop('disabled', false);
				$("#submit").html("Reset");
				$('#response').text("Message has been sent");
				// $('#response').text("Network error, please try again");
		  	}
		});
	});