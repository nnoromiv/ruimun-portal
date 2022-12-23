<?php
require_once 'user/assets/scripts/data.php';
if (all()) {
	redirect("user/login");
}
//$committee =  getCommittee();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <title>RUIMUN&nbsp;-&nbsp;Sign Up</title>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="icon" type="image/png" href="user/assets/images/utility/icon.png">
  <link rel="stylesheet" href="user/assets/bootstrap/bootstrap.css">
  <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>
<style type="text/css">
	.field-icon {
	  float: right;
	  margin-left: -25px;
	  margin-right: 10px;
	  margin-top: -30px;
	  position: relative;
	  z-index: 2;
	}
	:root {
	  --input-padding-x: 1.5rem;
	  --input-padding-y: 0.75rem;
	}
	.login,
	.image {
	  min-height: 100vh;
	}
	.bg-image {
	  background-image: url('user/assets/images/utility/rumiun.png');
	  background-size: cover;
	  background-position: center;
	  border-radius: 0 20px 20px 0;
	  object-fit: cover;
	  height: 100vh;
	  position: relative;
	}
	.login-heading {
	  font-weight: 300;
	}
	.btn-login {
	  font-size: 0.9rem;
	}
	.form-group {
	  position: relative;
	  margin-bottom: 1rem;
	}
	.form-group>input,
	.custom-select,
	.form-label-group>label {
	  padding: var(--input-padding-y) var(--input-padding-x);
	  height: auto;
	}
	.form-label-group input::-webkit-input-placeholder {
	  color: transparent;
	}
	.form-label-group input:-ms-input-placeholder {
	  color: transparent;
	}
	.form-label-group input::-ms-input-placeholder {
	  color: transparent;
	}
	.form-label-group input::-moz-placeholder {
	  color: transparent;
	}
	.form-label-group input::placeholder {
	  color: transparent;
	}
	.form-label-group input:not(:placeholder-shown) {
	  padding-top: calc(var(--input-padding-y) + var(--input-padding-y) * (2 / 3));
	  padding-bottom: calc(var(--input-padding-y) / 3);
	}
	.form-label-group input:not(:placeholder-shown)~label {
	  padding-top: calc(var(--input-padding-y) / 3);
	  padding-bottom: calc(var(--input-padding-y) / 3);
	  font-size: 2px;
	  color: #777;
	}
	@supports (-ms-ime-align: auto) {
	  .form-label-group>label {
	    display: none;
	  }
	  .form-label-group input::-ms-input-placeholder {
	    color: #777;
	  }
	}
	@media all and (-ms-high-contrast: none),
	(-ms-high-contrast: active) {
	  .form-label-group>label {
	    display: none;
	  }
	  .form-label-group input:-ms-input-placeholder {
	    color: #777;
	  }
	}
	input[type="text"]:focus,
	input[type="password"]:focus,
	input[type="datetime"]:focus,
	input[type="datetime-local"]:focus,
	input[type="date"]:focus,
	input[type="month"]:focus,
	input[type="time"]:focus,
	input[type="week"]:focus,
	input[type="number"]:focus,
	input[type="email"]:focus,
	input[type="url"]:focus,
	input[type="search"]:focus,
	input[type="tel"]:focus,
	input[type="color"]:focus,
	.uneditable-input:focus {
	  border-color: #494263;
	  box-shadow: none;
	  outline: 0 none;
	}
	.custom-select:focus {
        border-color: #494263;
        box-shadow: inherit;
    }

</style>
<body>
	<div class="container-fluid">
	  	<div class="row no-gutter">
	    	<div class="d-none d-md-flex col-md-4 col-lg-8 bg-image"></div>
		    <div class="col-md-8 col-lg-4">
		      <div class="login d-flex align-items-center py-5">
		        <div class="container">
		          <div class="row">
		            <div class="col-md-9 col-lg-8 mx-auto">
		              	<h4 class="login-heading mb-4" style="color:goldenrod"><strong>New Member Registration</strong></h4>
		              	<form id="signup" method="post" autocomplete="off">
			                <div class="form-group">
			                  <input type="text" id="name" name="name" class="form-control" placeholder="Full name" required autofocus>
			                  <span id="name_hint" style="font-size:15px;color:darkred;"></span>
			                </div>
                            <div class="form-group">
							  <select required class="custom-select" id="type" name="type">
							    <option value="">Select delegate type</option>
							    <option value="nigerian">Nigerian Delegate (₦55,000)</option>
							    <!-- <option value="sec_school">Secondary School Delegate (₦20,000)</option> -->
                                <option value="RUN">Redeemer's University (₦45,000)</option>
							    <!-- <option value="virtual">Virtual Delegate ($10)</option> -->
							    <option value="foreign">International Delegate ($150)</option>
							  </select>
							</div>
			                <div class="form-group">
			                  <input type="email" id="email" name="email" class="form-control" placeholder="Email address" required>
			                  <span id="email_hint" style="font-size:15px;color:darkred;"></span>
			                </div>
			                <div class="form-group">
			                  <input type="tel" id="phone" name="phone" class="form-control" placeholder="Phone number" required>
							  <small style="color:goldenrod">Preferably a WhatsApp number</small>
			                  <span id="phone_hint" style="font-size:15px;color:darkred;"></span>
			                </div>
                            <div class="form-group">
							  <select required class="custom-select" id="gender" name="gender">
							    <option value="">Select Gender</option>
							    <option value="male">Male</option>
							    <option value="female">Female</option>
							  </select>
							</div>
                            <div class="form-group">
			                  <textarea id="experience" name="experience" class="form-control" placeholder="Previous MUN experience" required autofocus></textarea>
							  <small style="color:goldenrod">Conference, Committee, Role, Awards</small>
			                  <span id="experience_hint" style="font-size:15px;color:darkred;"></span>
			                </div>
                            <div class="form-group">
			                  <input type="text" id="affiliation" name="affiliation" class="form-control" placeholder="Affiliated Institution" required autofocus>
							  <small style="color:goldenrod">University, secondary school, company or MUN</small>
			                  <span id="affiliation_hint" style="font-size:15px;color:darkred;"></span>
			                </div>
                            <div class="form-group">
			                  <input type="text" id="position" name="position" class="form-control" placeholder="Position" required autofocus>
							  <small style="color:goldenrod">University Level, Secondary School Class, position in company or MUN</small>
			                  <span id="position_hint" style="font-size:15px;color:darkred;"></span>
			                </div>
                            <div class="form-group runstudent">
			                  <input type="text" id="matric" name="matric" class="form-control" placeholder="Matric Number">
			                </div>
                            <div class="form-group runstudent">
			                  <input type="text" id="department" name="department" class="form-control" placeholder="Department">
			                </div>
                            <div class="form-group">
			                  <input type="text" id="city" name="city" class="form-control" placeholder="City" required autofocus>
			                  <span id="city_hint" style="font-size:15px;color:darkred;"></span>
			                </div>
                            <div class="form-group">
			                  <input type="text" id="state" name="state" class="form-control" placeholder="State" required autofocus>
			                  <span id="state_hint" style="font-size:15px;color:darkred;"></span>
			                </div>
                            <div class="form-group">
			                  <input type="text" id="country" name="country" class="form-control" placeholder="Country" required autofocus>
			                  <span id="country_hint" style="font-size:15px;color:darkred;"></span>
			                </div>
                            <div class="form-group">
			                  <input type="tel" id="zipcode" name="zipcode" class="form-control" placeholder="Zipcode" required autofocus>
			                  <span id="zipcode_hint" style="font-size:15px;color:darkred;"></span>
			                </div>
                            <div class="form-group">
							  <select required class="custom-select" id="tshirt" name="tshirt">
							    <option value="">Select Tshirt size</option>
							    <option value="xs">XS</option>
							    <option value="s">S</option>
							    <option value="m">M</option>
							    <option value="l">L</option>
							    <option value="xl">XL</option>
							    <option value="xxl">XXL</option>
							  </select>
							  <small style="color:goldenrod">Each participant receives a branded t-shirt. Let us know what size we need to reserve for you</small>
							</div>
							<div class="form-group">
			                  <textarea id="medical" name="medical" class="form-control" placeholder="Medical conditions or allergies" autofocus></textarea>
							  <small style="color:goldenrod">If yes, please specify</small>
			                  <span id="medical_hint" style="font-size:15px;color:darkred;"></span>
			                </div>
							<div class="form-group">
			                  <textarea id="diet" name="diet" class="form-control" placeholder="Dietary restrictions?" autofocus></textarea>
							  <small style="color:goldenrod">If yes, please specify</small>
			                  <span id="diet_hint" style="font-size:15px;color:darkred;"></span>
			                </div>
                            <div class="form-group">
							  <select required class="custom-select" id="advert" name="advert">
							    <option value="">How did you find out about RUIMUN?</option>
							    <option value="facebook">Facebook</option>
							    <option value="twitter">Twitter</option>
							    <option value="whatsapp">WhatsApp</option>
							    <option value="instagram">Instagram</option>
							    <option value="friend/colleague">Friend/Colleague</option>
							    <option value="university/institution">University/Institution</option>
							    <option value="ambassador">Campus Ambassador</option>
							    <option value="other">Other</option>
							  </select>
							</div>
							<div class="form-group">
			                  <input type="text" id="referral" name="referral" class="form-control" placeholder="Referral Code" autofocus>
							  <small style="color:goldenrod">If you do not have one, Kindly enter the name of your campus ambassador. 
								  In the Absence of Referral Code or Campus Ambassador, kindly type N/A.</small>
			                  <span id="referral_hint" style="font-size:15px;color:darkred;"></span>
			                </div>
							<!-- <div class="form-group">
							  <select required class="custom-select" id="committee1" name="committee1">
							    <option value="">Select Committee 1</option>
								<?php 
									$menu=" "; 
									foreach($committee as $key =>$var){
										
										$menu.="<option value=" . htmlentities($var['id']) . ">" . strval($var['committee']) ." </option>";
											}
										echo $menu;
								?>
							  </select>
							</div> -->
							<!-- <div class="form-group">
							  <select required class="custom-select" id="country1" name="country1">
							  </select>
							</div> -->
							<!-- <div class="form-group">
							  <select required class="custom-select" id="committee2" name="committee2">
							    <option value="">Select Committee 2</option>
								<?php 
									$menu=" "; 
									foreach($committee as $key =>$var){
										$menu.="<option value=\"" . htmlentities($var['id']) . "\">" . strval($var['committee']) ." </option>";
											}
										echo $menu;
								?>
							  </select>
							</div> -->
							<!-- <div class="form-group">
							  <select required class="custom-select" id="country2" name="country2">
							  </select>
							</div> -->
							<!-- <div class="form-group">
							  <select required class="custom-select" id="committee3" name="committee3">
							    <option value="">Select Committee 3</option>
								<?php 
									$menu=" "; 
									foreach($committee as $key =>$var){
										$menu.="<option value=\"" . htmlentities($var['id']) . "\">" . strval($var['committee']) ." </option>";
											}
										echo $menu;
								?>
							  </select>
							</div> -->
							<!-- <div class="form-group">
							  <select required class="custom-select" id="country3" name="country3">
							  </select>
							</div> -->
			                <div class="form-group">
			                  <input type="password" id="password" name="password" class="form-control" placeholder="Password" required>
			                  <span toggle="#password" class="fa fa-fw fa-eye field-icon toggle-password"></span>
			                  <span id="password_hint" style="font-size:15px;color:darkred;"></span>
			                </div>
			                <div class="form-group">
			                  <input type="password" id="c_password" name="c_password" class="form-control" placeholder="Confirm password" required>
			                  <span id="password_hint2" style="font-size:15px;color:darkred;">
			                </div>
			                
							<input required type="hidden" name="token" id="token" value="<?php echo tokenGenerator();?>">
			                <button class="btn btn-lg btn-block btn-login font-weight-bold" id="submit" style="background:#494263;color:white;" type="submit">Sign Up</button>
			                <hr>
			                <div class="text-center">
			                	Already have an account?&nbsp;<a href="signin" style="color:#7F6610;font-size:14px;font-weight:lighter;">Sign In</a>
		                  	</div>
		              	</form>
		            </div>
		          </div>
		        </div>
		      </div>
		    </div>
	  	</div>
	</div>
	<script src="user/assets/bootstrap/jquery.js"></script>
	<script src="user/assets/bootstrap/popper.js"></script>
	<script src="user/assets/bootstrap/bootstrap.js"></script>
	<script src="user/assets/bootstrap/bootstrap.js"></script>
	<script type="text/javascript">
		$(document).ready(function(){
            $(".runstudent").hide();
            $('#type').change(function () {
                if($(this).val() == "RUN"){
                    $(".runstudent").show();
                } 
                else {
                    $(".runstudent").hide();
                }
            }) 
			$(".toggle-password").click(function() {
			  	$(this).toggleClass("fa-eye fa-eye-slash");
			  	var input = $($(this).attr("toggle"));
			  	if (input.attr("type") == "password") {
			  		input.attr("type", "text");
			  	}else{
			  		input.attr("type", "password");
			  	}
			});

			// $("#committee1").change(function () {
			// 	var id= $("#committee1").val()
			// 	$.ajax({
			// 		url: 'user/assets/scripts/data',
			// 		data: {committee:id},
			// 		type: 'get',
			// 		success: function(response){
			// 			const countries = JSON.parse(response)
			// 			console.log(countries)
			// 			var match = countries.split(',')
			// 			console.log(match)
			// 			// for (var a in match)
			// 			// {
			// 			// 	var variable = match[a]
			// 			// 	console.log(variable)
			// 			// }
						

			// 			$("#country1").empty().append('<option>Select Country 1</option>')
			// 			match.forEach(element => {
			// 				$('#country1').append($('<option>', {
			// 					value: element,
			// 					text: element
			// 				}));
			// 			});
			// 		}
			// 	})
			// })

			// $("#committee2").change(function () {
			// 	var id= $("#committee2").val()
			// 	$.ajax({
			// 		url: 'user/assets/scripts/data',
			// 		data: {committee:id},
			// 		type: 'get',
			// 		success: function(response){
			// 			const countries = JSON.parse(response)
			// 			console.log(countries)
			// 			var match = countries.split(',')
			// 			console.log(match)						

			// 			$("#country2").empty().append('<option>Select Country 2</option>')
			// 			match.forEach(element => {
			// 				$('#country2').append($('<option>', {
			// 					value: element,
			// 					text: element
			// 				}));
			// 			});
			// 		}
			// 	})
			// })

			// $("#committee3").change(function () {
			// 	var id= $("#committee3").val()
			// 	$.ajax({
			// 		url: 'user/assets/scripts/data',
			// 		data: {committee:id},
			// 		type: 'get',
			// 		success: function(response){
			// 			const countries = JSON.parse(response)
			// 			console.log(countries)
			// 			var match = countries.split(',')
			// 			console.log(match)						

			// 			$("#country3").empty().append('<option>Select Country 3</option>')
			// 			match.forEach(element => {
			// 				$('#country3').append($('<option>', {
			// 					value: element,
			// 					text: element
			// 				}));
			// 			});
			// 		}
			// 	})
			// })

			$('#name_hint').text("");
			$('#email_hint').text("");
			$('#phone_hint').text("");

			$('#experience_hint').text("");
			$('#affiliation_hint').text("");
			$('#position_hint').text("");
			$('#city_hint').text("");
			$('#state_hint').text("");
			$('#country_hint').text("");
			$('#zipcode_hint').text("");  
			$('#medical_hint').text("");
			$('#diet_hint').text("");
			$('#referral_hint').text("");    
            
			$('#password_hint').text("");
			$('#password_hint2').text("");
			$("#password").keyup(function(){
				var password = $(this).val();
				var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
			  	if (!pattern.test(password)) {
				    $("#password_hint").text("Password must contain at least 8 characters including an uppercase and a lower case letter and a number");
			  	}else{
			  		$("#password_hint").text("");
			  	}
			});
			$("#c_password").keyup(function(){
				var c_password = $(this).val();
				var password = $("#password").val();;
				var pattern = /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])[0-9a-zA-Z]{8,}$/;
			  	if (password != c_password) {
				    $("#password_hint2").text("Passwords do not match");
			  	}else{
			  		$("#password_hint2").text("");
			  	}
			});
			$(document).on('submit', '#signup', function(event){
				$("#submit").html('<img src="user/assets/images/utility/spinner.gif" class="py-1">&nbsp;&nbsp;Signing up');
				$("#submit").prop('disabled', true);
				$('#name_hint').text("");
				$('#email_hint').text("");
				$('#phone_hint').text("");
                $('#experience_hint').text("");
                $('#affiliation_hint').text("");
                $('#position_hint').text("");
                $('#city_hint').text("");
                $('#state_hint').text("");
                $('#country_hint').text("");
                $('#zipcode_hint').text(""); 
				$('#medical_hint').text("");
				$('#diet_hint').text("");
				$('#referral_hint').text("");  
				$('#password_hint').text("");
				$('#password_hint2').text("");
				event.preventDefault();
				$.ajax({
					url:"user/assets/scripts/signup",
					method:"POST",
					data:new FormData(this),
					contentType:false,
					processData:false,
					dataType:"json",
					success:function(data){
						console.log(data);
						if (data.success) {
							alert("Registration was successful, proceed to log in");
							window.location = 'user/login';
							//setTimeout(function(){window.location = 'user/login'; }, 2000);
							//window.location = 'validate?request_from=validate&email='+data.mail+'&token='+data.token;
						}else if (data.error){
							$('#name_hint').text(data.error);
						}else{
							$('#name_hint').text(data.name);
							$('#email_hint').text(data.email);
							$('#phone_hint').text(data.phone);
							$('#password_hint').text(data.pass);
							$('#password_hint2').text(data.pass2);
							$("#submit").prop('disabled', false);
							$("#submit").html("Sign Up");
						}
					},
					error: function(XMLHttpRequest, textStatus, errorThrown) {
						alert("Network error, please try again");
				    	$("#submit").prop('disabled', false);
						$("#submit").html("Sign Up");
				  	}
				});
			});
		});		
	</script>
</body>
</html>