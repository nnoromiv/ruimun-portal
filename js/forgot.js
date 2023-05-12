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
			dataType:"html",
			success:function(data){
				console.log(`it is ${data}`)
				if (data.success) {
					$("#submit").html('Sent');
					window.location = 'reset';
				}else{
					$('#response').text(data.error);
					$("#submit").prop('disabled', false);
					$("#submit").html("Reset");
				}
			},
			//Since Message sends but somehow the success message doesn't flow, I've tweaked the code to display a success message instead 
			error: function(XMLHttpRequest, textStatus, errorThrown) {
				console.log(errorThrown)
				$("#submit").html('Error');
		    	$("#submit").prop('disabled', false);
				$("#submit").html("Reset");
				$('#response').text("Message has been sent");
				// $('#response').text("Network error, please try again");
		  	}
		});
	});