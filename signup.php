<?php
require_once 'user/assets/scripts/data.php';
if (all()) {
redirect("user/login");
}
$committee =  getCommittee();
?>
<!DOCTYPE html>
<html lang="en">
<head>
<title>RUIMUN&nbsp;-&nbsp;Sign Up</title>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1">
<link rel="icon" type="image/png" href="user/assets/images/utility/icon.png">
<script src="user/assets/bootstrap/jquery.js"></script>
<script src="user/assets/bootstrap/popper.js"></script>
<script src="user/assets/bootstrap/bootstrap.js"></script>
<script src="user/assets/bootstrap/bootstrap.js"></script>
<link rel="stylesheet" href="user/assets/bootstrap/bootstrap.css">
<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.7.0/css/all.css" integrity="sha384-lZN37f5QGtY3VHgisS14W3ExzMWZxybE1SJSEsQp9S+oqd12jhcu+A56Ebc1zFSJ" crossorigin="anonymous">
</head>
<style>
<?php include 'css/styles.css'; ?>
</style>
<body>
<div class="container-fluid">
	<div class="row no-gutter">
		<div class="d-none d-md-flex col-md-8 col-lg-8 bg-image"></div>
		<div class="col-md-4 col-lg-4">
			<div class="login d-flex align-items-center py-5">
			<div class="container">
				<div class="row">
				<div class="mx-3">
					<h4 class="login-heading mb-4" style="color:goldenrod"><strong>Registration</strong></h4>
					<form id="signup" method="post" autocomplete="off">
						<div class="form-group">
							<input type="text" id="name" name="name" class="form-control" placeholder="Full name" required autofocus>
							<span id="name_hint" style="font-size:15px;color:darkred;"></span>
						</div>
						<div class="form-group">
							<select required class="custom-select" id="type" name="type">
							<option value="">Delegate type</option>
							<option value="nigerian">Nigerian Delegate (₦55,000)</option>
							<!-- <option value="sec_school">Secondary School Delegate (₦20,000)</option> -->
							<option value="RUN">Redeemer's University (₦45,000)</option>
							<!-- <option value="virtual">Virtual Delegate ($10)</option> -->
							<option value="foreign">International Delegate ($100)</option>
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
							<option value="">Gender</option>
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
							<input type="text" id="matric" name="matric" class="form-control" placeholder="Matric Number" >
						</div>
						<div class="form-group runstudent">
							<input type="text" id="department" name="department" class="form-control" placeholder="Department" >
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
							<option value="">T-shirt size</option>
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
							<option value="">How did you find out about us?</option>
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
						<div class="form-group">
							<select required class="custom-select" id="committee1" name="committee1">
							<option value="">Committee 1</option>
							<?php 
								$menu=" "; 
								foreach($committee as $key =>$var){
									
									$menu.="<option value=" . htmlentities($var['id']) . ">" . strval($var['committee']) ." </option>";
										}
									echo $menu;
							?>
							</select>
						</div>
						<div class="form-group">
							<select required class="custom-select" id="country1" name="country1">
							</select>
						</div>
							<div class="form-group">
							<select required class="custom-select" id="committee2" name="committee2">
							<option value="">Committee 2</option>
							<?php 
								$menu=" "; 
								foreach($committee as $key =>$var){
									$menu.="<option value=\"" . htmlentities($var['id']) . "\">" . strval($var['committee']) ." </option>";
										}
									echo $menu;
							?>
							</select>
						</div>
						<div class="form-group">
							<select required class="custom-select" id="country2" name="country2">
							</select>
						</div>
							<div class="form-group">
							<select required class="custom-select" id="committee3" name="committee3">
							<option value="">Committee 3</option>
							<?php 
								$menu=" "; 
								foreach($committee as $key =>$var){
									$menu.="<option value=\"" . htmlentities($var['id']) . "\">" . strval($var['committee']) ." </option>";
										}
									echo $menu;
							?>
							</select>
						</div>
							<div class="form-group">
							<select required class="custom-select" id="country3" name="country3">
							</select>
						</div>
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
						<button class="btn btn-lg btn-block btn-login font-weight-bold" id="submit" style="background:#494263;color:white;border-radius:30px;" type="submit">Sign Up</button>
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
<script>
	<?php include 'js/signup.js' ?>
</script>
</body>
</html>