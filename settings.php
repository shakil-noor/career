<?php 
include("includes/header.php");
include("includes/form_handlers/settings_handler.php");

?>


<div class="main_column column">


	<h3>Account Settings</h3>

	<div class="settings_img_section">
		<?php
		echo "<img src='" . $user['profile_pic'] ."' class='small_profile_pic'>";
		?>
		<br>
		<a href="upload.php" class="btn-info"><i class="fa fa-cloud-upload"></i> Upload</a> <br><br><br>
		
	</div>

	<div class="settings_details_section">
		<h4>Modify the values and click 'Update Details'</h4>

		<?php
		$user_data_query = mysqli_query($con, "SELECT first_name, last_name, email FROM users WHERE username='$userLoggedIn'");
		$row = mysqli_fetch_array($user_data_query);

		$first_name = $row['first_name'];
		$last_name = $row['last_name'];
		$email = $row['email'];
		?>

		<form action="settings.php" method="POST">
			First Name: <input type="text" name="first_name" value="<?php echo $first_name; ?>" ><br>
			Last Name: <input type="text" name="last_name" value="<?php echo $last_name; ?>" ><br>
			Email: <input type="text" name="email" value="<?php echo $email; ?>" ><br>

			<?php //echo $message; ?>

			<input type="submit" name="update_details" value="Update Details" class="btn-info settings_submit"><br>
		</form>
		<hr>

		<form action="settings.php" method="POST">
			<b>Select Your Skills</b> <br>
			<select class="select_option" name="skills[ ]" multiple="multiple" style="width: 100%; height: 113px; margin-bottom: 5px;">
                <option value="HTML">HTML</option>
                <option value="CSS">CSS</option>
                <option value="JS">JS</option>
                <option value="PHP">PHP</option>
                <option value="Laravel">Laravel</option>
                <option value="JAVA">JAVA</option>
                <option value="Spring">Spring</option>
                <option value="JSF">JSF</option>
                <option value="Agile">Agile</option>
                <option value="UI/UX">UI/UX</option>
            </select><br>
			

			<input type="submit" name="update_skills" value="Update Details" class="btn-info settings_submit"><br>
		</form>
		<hr>

		<h4>Change Password</h4>
		<form action="settings.php" method="POST">
			Old Password: <input type="password" name="old_password"  ><br>
			New Password: <input type="password" name="new_password_1"  ><br>
			New Password Again: <input type="password" name="new_password_2"  ><br>

			

			<input type="submit" name="update_password"  value="Update Password" class="btn-info settings_submit"><br>
		</form>

		<!-- <h4>Close Account</h4>
		<form action="settings.php" method="POST">
			<input type="submit" name="close_account" id="close_account" value="Close Account" class="danger settings_submit">
		</form> -->
	</div>

</div>