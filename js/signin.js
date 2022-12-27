$(document).ready(function(){});
	$('#response').text("");
	$(document).on('submit', '#signin', function(event){
		$("#submit").html('<img src="user/assets/images/utility/spinner.gif" class="py-1">&nbsp;&nbsp;signing in');
		$("#submit").prop('disabled', true);
		$('#response').text("");
		event.preventDefault();
		$.ajax({
			url:"user/assets/scripts/signin",
			method:"POST",
			data:new FormData(this),
			contentType:false,
			processData:false,
			dataType:"json",
			success:function(data){
				if (data.success) {
					$(".login-heading").html("Logged in, redirecting...");
					setTimeout(function(){window.location = 'user/login'; }, 1500);
				}else{
					$('#response').text(data.error);
					$("#submit").prop('disabled', false);
					$("#submit").html("Sign In");
				}
			},
			error: function(XMLHttpRequest, textStatus, errorThrown) {
		    	$("#submit").prop('disabled', false);
				$("#submit").html("Sign In");
				$('#response').text("Network error, please try again");
		  	}
		});
	});