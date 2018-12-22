<?php 
if(isset($_SESSION['username']) & !empty($_SESSION['username'])){
		header("Location: index.php");
	}
	require_once 'config/config.php';
	require_once 'includes/form_handlers/register_handler.php';
	require_once 'includes/form_handlers/login_handler.php';
?>

<head>
	<meta charset="UTF-8">
	<title>Welcome to Caree View</title>
	<link rel="shortcut icon" href="assets/images/2.png">
	<link rel="stylesheet" href="assets/css/register_style.css" />
	<script src="https://ajax.googleapis.com/ajax/libs/jquery/2.1.3/jquery.min.js"></script>
	<script type="text/javascript" src="assets/js/register.js"></script>
</head>
<body>
	
	<?php 
		if(isset($_POST['submit'])){
			echo'
			<script>
			$(document).ready(function(){
				$("#first").hide();
				$("#second").show();
			});
			</script>';
		}
	?>

	<div class ="wrapper">
		<div class='login_box'>
			<div class ="login_header">
			<h1>Career View</h1>
			Login or Sign up below!
			
			</div>
			<div id="first">
				<form action="" method="POST">
					<input type="email" name="log_email" placeholder="Email" value= "<?php 
					if(isset($_SESSION['log_email'])) {
						echo $_SESSION['log_email'];
					}  
					?>" required /> 
					<br />
					<input type="password" name="log_password" placeholder="Password" /> <br />
					<?php if(in_array("Email or Password was incorrect",$error_array)) echo "<span style='color: #e74c3c;'>Email or password was incorrect</span> <br>"; ?>
					<?php if(in_array("Sorry your account still not approved. please wait...",$error_array)) echo "<span style='color: #e74c3c;'>Sorry your account still not approved. please wait...</span> <br>"; ?>
					
					<input type="submit" name ="login" value="Login" required /> <br />
					<a href="#" id="signup" class="signup">Need an account? Register Here!</a>
				</form>
			</div>
			
			<div id="second">
				<form action="" method="POST">
					<!-- First Name -->
					<input type="text" name ="fname" placeholder="First Name" 
					value= "<?php if(isset($_SESSION['fname'])) {
								echo $_SESSION['fname'];
							} ?>" 
					required /> <br /> 
					<?php if(in_array("Your name must be between 2 and 25 characters", $error_array)) 
						echo "<span style='color: #e74c3c;'>Your name must be between 2 and 25 characters</span><br>";?> 
					
					<!-- Last Name -->
					<input type="text" name ="lname" placeholder="Last Name" 
					value= "<?php if(isset($_SESSION['lname'])) {
								echo $_SESSION['lname'];
							}  ?>" 
					required />  
					<?php if(in_array("Your name must be between 2 and 25 characters", $error_array)) 
						echo "<span style='color: #e74c3c;'>Your name must be between 2 and 25 characters</span><br>";
					?><br />

					<!-- ID Number -->
					<input type="text" name ="uni_id"  placeholder="ID Number"
					value= "<?php if(isset($_SESSION['uni_id'])) {
								echo $_SESSION['uni_id'];
							}  ?>" required /> <br />
					<!-- Error showing for ID Number -->
					<?php if(in_array("This ID is already has an account", $error_array)) 
						echo "<span style='color: #e74c3c;'>This ID is already has an account</span><br>";
					?>

					<!-- email -->
					<input type="email" name ="email" placeholder="Email"
					value= "<?php if(isset($_SESSION['email'])) {
								echo $_SESSION['email'];
							}  ?>"
					required /> <br />
					
					<!-- email 2 -->
					<input type="email" name ="email2" placeholder="confirm Email" 
					value= "<?php if(isset($_SESSION['email2'])) {
								echo $_SESSION['email2'];
							}  ?>" 
					required /> <br />
					
					<!-- Error showing for email -->
					<?php if(in_array("Email already exist", $error_array)) echo "<span style='color: #e74c3c;'>Email already exist.</span><br />";
						else if(in_array("Invalid email format", $error_array)) echo "<span style='color: #e74c3c;'>Invalid email format.</span> <br />";
						else if(in_array("Emails don't match", $error_array)) echo "<span style='color: #e74c3c;'>Emails don't match.</span> <br />";
					?>
					
					<!-- Password -->
					<input type="password" name ="password" placeholder="Password" required /> <br />
					<input type="password" name ="password2" placeholder="Confirm Password" required /> <br />
					<!-- Error showing for password -->
					<?php if(in_array("Your password dont match", $error_array)) echo "<span style='color: #e74c3c;'>Your password dont match</span></br>";
						else if(in_array("Password should only contain english character or number", $error_array)) echo "<span style='color: #e74c3c;'>Password should only contain english character or number.</span> <br />";
						else if(in_array("Password must be more then 5 characters", $error_array)) echo "<span style='color: #e74c3c;'>Password must be more then 5 characters.</span><br />";
					?>

					<!-- Submit Button -->
					<input type="submit" name ="submit" value="Register" required /> <br />
					
					<?php if(in_array("<span style='color: #14C800;'>Your Registration is almost done<br> Please wait for admin confirmation</span><br>", $error_array)) echo "<span style='color: #14C800;'>Your Registration is almost done<br> Please wait for admin confirmation</span><br>"; ?>
					
					<a href="#" id="signin" class="signin">Already have an account? Sign in here!</a>
				</form>
			</div>
		</div>
	</div>
</body>
</html>