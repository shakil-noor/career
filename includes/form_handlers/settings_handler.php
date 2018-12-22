<?php  
if(isset($_POST['update_details'])) {
	$first_name = $_POST['first_name'];
	$last_name = $_POST['last_name'];
	$email = $_POST['email'];

	$email_check = mysqli_query($con, "SELECT * FROM users WHERE email='$email'");
	$row = mysqli_fetch_array($email_check);
	$matched_user = $row['username'];
	$user_id = $row['id'];

	if($matched_user == "" || $matched_user == $userLoggedIn) {
		//$message = "Details updated!<br><br>";

		$query = mysqli_query($con, "UPDATE users SET first_name='$first_name', last_name='$last_name', email='$email' WHERE username='$userLoggedIn'");
		
		if ($query) {
			?>
			<script>
				swal({
				  title: "Good Job",
				  text: "Update success",
				  icon: "success",
				  button: "Done!",
				});
			</script>
			<?php 
		}
	}
	else {
		// $message = "That email is already in use!<br><br>";
		?>
		<script>
			swal({
			  title: "Wrong",
			  text: "That email is already in use!",
			  icon: "error",
			  button: "Try again",
			});
		</script>
		<?php 
	}
}
else 
	$message = "";

//set skill


if(isset($_POST['update_skills']) & !empty($_POST['update_skills'])) {
	$skills = $_POST['skills'];

	$user_check = mysqli_query($con, "SELECT * FROM users WHERE username='$userLoggedIn'");
	$row = mysqli_fetch_array($user_check);
	$user_id = $row['id'];

	$skills_query = mysqli_query($con, "SELECT * FROM user_skills WHERE user_id='$user_id' ");
	$check_skills_row = mysqli_num_rows($skills_query);
	if ($check_skills_row > 0) {
		$delete_query = mysqli_query($con, "DELETE FROM user_skills WHERE user_id=$user_id");
	}


	foreach ($skills as $sk) {
		$insert_user_skills = mysqli_query($con, "INSERT INTO user_skills VALUES('', '$user_id', '$sk') ");
	}

	if ($insert_user_skills) {
		?>
		<script>
			swal({
			  title: "Good Job",
			  text: "Update success",
			  icon: "success",
			  button: "Done!",
			});
		</script>
		<?php 
	}
}else if(isset($_POST['update_skills']) & empty($_POST['update_skills'])) {
	//$message = "Please select your skill";
	?>
		<script>
			swal({
			  title: "Please select your skill",
			  text: "",
			  icon: "warning",
			  button: "Try again",
			});
		</script>
	<?php 
} 
	


//**************************************************

if(isset($_POST['update_password'])) {

	$old_password = strip_tags($_POST['old_password']);
	$new_password_1 = strip_tags($_POST['new_password_1']);
	$new_password_2 = strip_tags($_POST['new_password_2']);

	$password_query = mysqli_query($con, "SELECT password FROM users WHERE username='$userLoggedIn'");
	$row = mysqli_fetch_array($password_query);
	$db_password = $row['password'];

	if(md5($old_password) == $db_password) {

		if($new_password_1 == $new_password_2) {


			if(strlen($new_password_1) <= 4) {
				?>
					<script>
						swal({
						  title: "Password is too short",
						  text: "Sorry, your password must be greater than 4 characters",
						  icon: "warning",
						  button: "Try again",
						});
					</script>
					<?php 
			}else {
				$new_password_md5 = md5($new_password_1);
				$password_query = mysqli_query($con, "UPDATE users SET password='$new_password_md5' WHERE username='$userLoggedIn'");
				//$password_message = "Password has been changed!<br><br>";
				if ($password_query) {
					?>
					<script>
						swal({
						  title: "Good Job",
						  text: "Password updated successfully",
						  icon: "success",
						  button: "Done!",
						});
					</script>
					<?php 
				}
			}


		}
		else {
			?>
				<script>
					swal({
					  title: "Your two new passwords need to match!",
					  text: "",
					  icon: "error",
					  button: "Try again",
					});
				</script>
			<?php 
		}
	}
	else {
		?>
			<script>
				swal({
				  title: "The old password is incorrect!",
				  text: "",
				  icon: "error",
				  button: "Try again",
				});
			</script>
		<?php 
	}

}


// if(isset($_POST['close_account'])) {
// 	header("Location: close_account.php");
// }


?>