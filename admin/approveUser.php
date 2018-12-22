<?php 
include_once 'includes/config.php';

if (isset($_GET['username'])){
 $username = $_GET['username'];
 $update_sql = "UPDATE users SET approved='yes' WHERE username='$username'";
 $result = mysqli_query($con, $update_sql);
 $msg = $username ." has been approved";
 
 if ($result){
   header('location:users.php');
 }else{
  
 }
}
?>