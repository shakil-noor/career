<?php 
include_once 'includes/config.php';
include_once '../includes/classes/Notification.php';
if (isset($_GET['id']) AND isset($_GET['username'])){
 $post_id = $_GET['id'];
 $added_by = $_GET['username'];
	
	//echo $post_id . "". $added_by; exit();
 $update_sql = "UPDATE posts SET approved='yes' WHERE id='$post_id'";
 $result = mysqli_query($con, $update_sql);
 $msg = $post_id ." number post has been approved";
	
	//Insert notification 
		$get_users = mysqli_query($con, "SELECT * FROM users WHERE user_closed='no' AND id IN (SELECT user_id FROM user_skills WHERE skill IN(SELECT skill FROM post_skills WHERE post_id='$post_id') GROUP BY user_id)");
		$send_notification_to_users = array();
		while($row = mysqli_fetch_array($get_users)){
			if($row['username'] != $added_by) {
				$notification = new Notification($con, $added_by);
				$notification->insertNotification($post_id, $row['username'], "notify_according_skills");

				array_push($send_notification_to_users, $user_to);
			}
		}
 
 if ($result){
	 header('location:posts.php');
	 ?>
		<script>
			swal({
						  title: "Approve",
						  text: "$post_id no id has been approved",
						  icon: "success",
						  button: "Done!",
						});
		</script>


	<?php
   
 }else{
  
 }
}
?>