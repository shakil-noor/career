<?php
	if(isset($_POST['login'])){
		$email = filter_var($_POST['log_email'], FILTER_SANITIZE_EMAIL); //Sanitize email
		
		$_SESSION['log_email'] = $email; //store email into session variable
		$password = md5($_POST['log_password']); // get password

		$check_approved_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password' AND approved='no' ");
		$check_found_or_not = mysqli_num_rows($check_approved_query);
		
		
		$check_database_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND password='$password' AND approved='yes' ");
		//var_dump($check_database_query); exit;
		$check_login_query = mysqli_num_rows($check_database_query);
		
		if($check_login_query == 1){
			$row = mysqli_fetch_array($check_database_query);
			$username = $row['username'];
			
			//code for reopen account
			$user_closed_query = mysqli_query($con, "SELECT * FROM users WHERE email='$email' AND user_colsed= 'yes'");
			if(mysqli_num_rows($user_closed_query) ==1){
				$reopen_account = mysqli_query($con, "UPDATE users SET user_closed='no' WHERE email='$email'");
			}
			
			$_SESSION['username'] = $username;
			header("location: index.php");
			
		}else if ($check_found_or_not == 1) {
			array_push($error_array, "Sorry your account still not approved. please wait...");
		}else{
			array_push($error_array, "Email or Password was incorrect");
		}
	}
?>