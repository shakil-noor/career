<?php require_once("includes/config.php"); 
	if(isset($_SESSION['username'])){
		header("Location: index.php");
	}
?>
	
<?php
$this_message="";
	if(isset($_POST['submit'])){
		$email = trim($_POST['email']);
		
		$_SESSION['email'] = $email; //store email into session variable
		$password = md5($_POST['password']); // get password
		
		$check_database_query = mysqli_query($con, "SELECT * FROM admin WHERE email='$email' AND password='$password'");
		//var_dump($check_database_query); exit;
		$check_login_query = mysqli_num_rows($check_database_query);
		
		if($check_login_query == 1){
			$row = mysqli_fetch_array($check_database_query);
			$username = $row['username'];
			
			session_start();
			$_SESSION['username'] = $username;
			
			header("Location: index.php");
		}else{
			$this_message ="Your password or email is incorrect";
		}
		}
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
	<link href="css/login_style.css" rel="stylesheet">
	<title>Wellcome to Admin Panel</title>
</head>
<body>

<h1>Login Form</h1>

<form action="" method="POST">
  <div class="imgcontainer">
    <img src="img/myAvatar.png" alt="Avatar" class="avatar">
  </div>

  <div class="container">
    <label for="username"><b>Username</b></label>
    <input type="email" placeholder="Enter email" name="email" value= "<?php if(isset($_SESSION['email'])) {
								echo $_SESSION['email'];
							}  
							?>" required>

    <label for="password"><b>Password</b></label>
    <input type="password" placeholder="Enter Password" name="password" required>
		<h4 class="bg-danger"><?php echo $this_message; ?></h4>
        
    <button type="submit" name="submit" >Login</button>
  </div>

</form>

</body>
</html>
