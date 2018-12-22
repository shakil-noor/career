<?php 
include_once 'includes/config.php';

if (isset($_GET['id'])){
 $post_id = $_GET['id'];
 $delete_sql = "UPDATE posts SET deleted='yes' WHERE id='$post_id'";
 $result = mysqli_query($con, $delete_sql);
 
 
 if ($result){
   header('location:posts.php');
 }else{
  
 }
}
?>