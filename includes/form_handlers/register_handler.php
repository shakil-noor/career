<?php 
	//Declaring variable to prevent errors
	$fname = "";
	$lname = "";
	$id = "";
	$email = "";
	$email2 = "";
	$password = "";
	$password2 = "";
	$date = "";
	$error_array = array();
	
	if(isset($_POST['submit'])){
		//Ragistration form values
		//First name
		$fname = strip_tags($_POST['fname']); //Remove html tags
		$fname = str_replace(' ', '', $fname); //remove spaces
		$fname = ucfirst(strtolower($fname)); // uppercase first letter
		$_SESSION['fname'] = $fname; // Store first name into session variable.
		
		//Last name
		$lname = strip_tags($_POST['lname']); //Remove html tags
		$lname = str_replace(' ', '', $lname); //remove spaces
		$lname = ucfirst(strtolower($lname)); // uppercase first letter
		$_SESSION['lname'] = $lname; // Store last name into session variable.

		//ID Number
		$uni_id = strip_tags($_POST['uni_id']); //Remove html tags
		$uni_id = str_replace(' ', '', $uni_id); //remove spaces
		$_SESSION['uni_id'] = $uni_id; // Store email into session variable.
		
		//Email
		$email = strip_tags($_POST['email']); //Remove html tags
		$email = str_replace(' ', '', $email); //remove spaces
		$email = ucfirst(strtolower($email)); // uppercase first letter
		$_SESSION['email'] = $email; // Store email into session variable.
		
		//email2
		$email2 = strip_tags($_POST['email2']); //Remove html tags
		$email2 = str_replace(' ', '', $email2); //remove spaces
		$email2 = ucfirst(strtolower($email2)); // uppercase first letter
		$_SESSION['email2'] = $email2; // Store email2 into session variable.
		
		
		//password
		$password = strip_tags($_POST['password']); //Remove html tags
		$password2 = strip_tags($_POST['password2']); //Remove html tags

	

		$date = date("Y-m-d");
		
		if($email == $email2){
			//check if email is in valid format 
			if (filter_var($email, FILTER_VALIDATE_EMAIL)){
				$email = filter_var($email, FILTER_VALIDATE_EMAIL);
				
				//Check if email already exist or not
				$email_check = mysqli_query($con, "SELECT email FROM users WHERE email = '$email'");
				//Count the number of rows returned
				
				$num_row = mysqli_num_rows($email_check);
				//print_r($num_row); exit;
				if($num_row > 0){
					array_push ($error_array,"Email already exist");
				}
			}else{
				array_push ($error_array,"Invalid Format");
			}
		}else{
			array_push ($error_array,"Emails don't match");
		}
		
		if(strlen($fname)> 25 || strlen($fname)<2){
			array_push ($error_array,"Your name must be between 2 and 25 characters");
		}
		if(strlen($lname)> 25 || strlen($lname)<2){
			array_push ($error_array,"Your name must be between 2 and 25 characters");
		}
		//check ID Number
		$id_query = mysqli_query($con, "SELECT uni_ID_Number FROM users WHERE uni_ID_Number='$uni_id'");
		$get_num_row = mysqli_num_rows($id_query);
		if ($get_num_row > 0) {
			array_push($error_array, "This ID is already has an account");
		}

		if($password != $password2){
			array_push ($error_array,"Your password dont match");
		}else{
			if(preg_match('/[^A-Za-z0-9]/',$password)){
				array_push ($error_array,"Password should only contain english character or number");
			}
		}
		if(strlen($password) < 5 ){
			array_push ($error_array,"Password must be more then 5 characters");
		}
		
		if(empty($error_array)){
			$password = md5($password); //encrypt password

			//generate unique username
			$username = strtolower($fname ."_". $lname);
			$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username = '$username'");

			$i=0;
			while (mysqli_num_rows($check_username_query) != 0) {
				$i++;
				$username =$username ."_". $i;
				$check_username_query = mysqli_query($con, "SELECT username FROM users WHERE username ='$username' ");
			}

			//Profile pictures assignment
			$rand = rand(1,2);
			if($rand == 1){
				$profile_pic = "assets/images/profile/default/head_wet_asphalt.png";
			}else if($rand == 2){
				$profile_pic = "assets/images/profile/default/head_turqoise.png";
			}
			
			$query = mysqli_query($con, "INSERT INTO users VALUE('', '$uni_id', '$fname', '$lname', '$username', '$email', '$password','$date','$profile_pic', '0','0','no', 'no')");
			
			array_push($error_array, "<span style='color: #14C800;'>Your Registration is almost done<br> Please wait for admin confirmation</span><br>");

			//Clear session variables 
			$_SESSION['fname'] = "";
			$_SESSION['lname'] = "";
			$_SESSION['email'] = "";
			$_SESSION['email2'] = "";
			$_SESSION['uni_id'] = "";
		}			
	}
?>