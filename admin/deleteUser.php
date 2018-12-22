<?php 
include_once 'includes/config.php';

if (isset($_GET['username'])){
 $username = $_GET['username'];
 $delete_sql = "Delete From users WHERE username='$username'";
 $result = mysqli_query($con, $delete_sql);
 
 
 if ($result){
   header('location:users.php');
 }else{
  
 }
}
?>