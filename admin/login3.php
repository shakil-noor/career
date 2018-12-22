<?php require_once("includes/config.php"); ?>

<?php
$this_message="";
	if(isset($_POST['submit'])){
		$username = trim($_POST['username']);
		
		$_SESSION['username'] = $username; //store username into session variable
		$password = md5($_POST['password']); // get password
		
		$check_database_query = mysqli_query($con, "SELECT * FROM admin WHERE username='$username' AND password='$password'");
		//var_dump($check_database_query); exit;
		$check_login_query = mysqli_num_rows($check_database_query);
		
		if($check_login_query == 1){
			$row = mysqli_fetch_array($check_database_query);
			$username = $row['username'];
			
			$_SESSION['username'] = $username;
			header("location: index.php");
		}else{
			$this_message ="Your password or username is incorrect";
		}
		}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Wellcome to Admin Panel</title>

    <!-- Bootstrap Core CSS -->
    <link href="css/bootstrap.css" rel="stylesheet">

    <!-- Custom Fonts -->
    <link href="font-awesome/css/font-awesome.min.css" rel="stylesheet" type="text/css">
	
    <!-- Custom CSS -->
    <link href="css/sb-admin.css" rel="stylesheet">
	
	  <!-- Bootbox JS -->
    <script src="js/bootbox.min.js"></script>

</head>

<body>
	<div id="wrapper">
		<div class="col-md-4 col-md-offset-3">
			<h4 class="bg-danger"><?php echo $this_message; ?></h4> 
			<form action="" method="post">
				<div class="form-group">
					<label for="username">Username</label>
					<input type="text" name="username"  value= "<?php 
							if(isset($_SESSION['username'])) {
								echo $_SESSION['username'];
							}  
							?>" required /> 
				</div>
				<div class="form-group">
					<label for="password">Password</label>
					<input type="password" name="password"  /> <br />
				</div>
		<!--     <?php /*if(in_array("Email or Password was incorrect <br>",$error_array)) echo "Email or password was incorrect <br>";*/ ?>-->
				<div class="form-group">
					<input type="submit" class="btn btn-primary" name="submit" value="Submit">
				</div>
			</form>
		</div>
	</div>
</body>
</html>