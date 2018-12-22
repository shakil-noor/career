<?php
	class Post{
		private $user_obj;
		private $con;
		
		public function __construct($con, $user){
			$this->con = $con;
			$this->user_obj = new User($con, $user);
		}
		
		public function submitPost($body, $user_to, $skills, $err_msg){
			$body = strip_tags($body); // remove html tags
			$body = mysqli_real_escape_string($this->con, $body);
			$body = ucfirst(strtolower($body));
			$value = $skills;
			$skills = implode(',', $skills);
			$check_empty = preg_replace('/\s+/', '', $body); //deletes all spaces

			//var_dump($value); 			
			if($check_empty !=""){
				//Current date and time
				$date_added = date("Y-m-d H:i:s");
				//Get username
				$added_by = $this->user_obj->getUsername();

				//If user is on own profile, user_to is 'none'
				if($user_to == $added_by){
					$user_to = "none";
				}
				
				//insert post
				$query = mysqli_query($this->con, "INSERT INTO posts VALUES('', '$body', '$skills', '$added_by', '$user_to', '$date_added', 'no', 'no', '0', 'no')");
				$returned_id = mysqli_insert_id($this->con);

				//insert post's skills into database
				foreach ($value as $sk) {
					$insert_skills = mysqli_query($this->con, "INSERT INTO post_skills VALUES('','$returned_id','$sk')");
					//echo $insert_skills; exit();
				}

				if ($query) {
					?>
					<script>
						swal({
						  title: "Your post is successfully submited",
						  text: "Please wait for admin's approval",
						  icon: "success",
						  button: "Done!",
						});
					</script>
					<?php 
				}
						
				//Update post count for user
				$num_posts = $this->user_obj->getNumPosts();
				$num_posts++;
				$update_query = mysqli_query($this->con, "UPDATE users SET num_post='$num_posts' WHERE username ='$added_by'");

			}
			
		}
		public function loadPostsFriends($data, $limit) {

			$page = $data['page']; 
			$userLoggedIn = $this->user_obj->getUsername();
			$user_id = $this->user_obj->getUserId();

			if($page == 1) 
				$start = 0;
			else 
				$start = ($page - 1) * $limit;


			$str = ""; //String to return 
			$data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no' AND approved='yes' AND id IN
					(SELECT post_id FROM post_skills WHERE skill IN(SELECT skill FROM user_skills WHERE user_id='$user_id') GROUP BY post_id) ORDER BY id DESC");

			if(mysqli_num_rows($data_query) > 0) {


				$num_iterations = 0; //Number of results checked (not necasserily posted)
				$count = 1;

				while($row = mysqli_fetch_array($data_query)) {
					$id = $row['id'];
					$body = $row['body'];
					$skills = $row['skills_needed'];
					$added_by = $row['added_by'];
					$date_time = $row['date_added'];
					//$imagePath = $row['image'];

					//Prepare user_to string so it can be included even if not posted to a user
					if($row['user_to'] == "none") {
						$user_to = "";
					}
					else {
						$user_to_obj = new User($this->con, $row['user_to']);
						$user_to_name = $user_to_obj->getFirstAndLastName();
						$user_to = "to <a href='" . $row['user_to'] ."'>" . $user_to_name . "</a>";
					}

					//Check if user who posted, has their account closed
					$added_by_obj = new User($this->con, $added_by);
					if($added_by_obj->isClosed()) {
						continue;
					}

					if($num_iterations++ < $start)
						continue; 


					//Once 10 posts have been loaded, break
					if($count > $limit) {
						break;
					}
					else {
						$count++;
					}

					if($userLoggedIn == $added_by){
						$delete_button = "<button class='delete_button btn-danger' id='post$id'>X</button>";
						// $delete_button = "<button class='delete_button btn-danger'> <a onclick='return confirm('Are you sure to delete this food item?')' href='includes/form_handlers/delete_post.php?post_id=$id' style='color:#fff; text-decoration:none'>X</a></button>";
					}else {
						$delete_button = "";
					}

					$user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
					$user_row = mysqli_fetch_array($user_details_query);
					$first_name = $user_row['first_name'];
					$last_name = $user_row['last_name'];
					$profile_pic = $user_row['profile_pic'];


					?>
					<script> 
						function toggle<?php echo $id; ?>() {

							var target = $(event.target);
							if (!target.is("a")) {
								var element = document.getElementById("toggleComment<?php echo $id; ?>");

								if(element.style.display == "block") 
									element.style.display = "none";
								else 
									element.style.display = "block";
							}
						}

					</script>
					<?php

					$comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE post_id='$id'");
					$comments_check_num = mysqli_num_rows($comments_check);


					//Timeframe
					$date_time_now = date("Y-m-d H:i:s");
					$start_date = new DateTime($date_time); //Time of post
					$end_date = new DateTime($date_time_now); //Current time
					$interval = $start_date->diff($end_date); //Difference between dates 
					if($interval->y >= 1) {
						if($interval->y == 1)
							$time_message = $interval->y . " year ago"; //1 year ago
						else 
							$time_message = $interval->y . " years ago"; //1+ year ago
					}
					else if ($interval->m >= 1) {
						if($interval->d == 0) {
							$days = " ago";
						}
						else if($interval->d == 1) {
							$days = $interval->d . " day ago";
						}
						else {
							$days = $interval->d . " days ago";
						}

						if($interval->m == 1) {
							$time_message = $interval->m . " month ". $days;
						}
						else {
							$time_message = $interval->m . " months ". $days;
						}
					}
					else if($interval->d >= 1) {
						if($interval->d == 1) {
							$time_message = "Yesterday";
						}
						else {
							$time_message = $interval->d . " days ago";
						}
					}
					else if($interval->h >= 1) {
						if($interval->h == 1) {
							$time_message = $interval->h . " hour ago";
						}
						else {
							$time_message = $interval->h . " hours ago";
						}
					}
					else if($interval->i >= 1) {
						if($interval->i == 1) {
							$time_message = $interval->i . " minute ago";
						}
						else {
							$time_message = $interval->i . " minutes ago";
						}
					}
					else {
						if($interval->s < 30) {
							$time_message = "Just now";
						}
						else {
							$time_message = $interval->s . " seconds ago";
						}
					}

					$str .= "<div class='status_post' onClick='javascript:toggle$id()'>
								<div class='post_profile_pic'>
									<img src='$profile_pic' width='50'>
								</div>

								<div class='posted_by' style='color:#ACACAC;'>
									<a href='$added_by'> $first_name $last_name </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message
									$delete_button
								</div>
								<div id='post_body'>
									$body
									<br><br>
									Needed Skills: $skills
									<br>
									<br>
								</div>

								<div class='newsfeedPostOptions'>
									Comments($comments_check_num)&nbsp;&nbsp;&nbsp;
									<iframe src='like.php?post_id=$id' scrolling='no'></iframe>
								</div>

							</div>
							<div class='post_comment' id='toggleComment$id' style='display:none;'>
								<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
							</div>
							<hr>";
					

					?>
					<script>

					$(document).ready(function() {

						$('#post<?php echo $id; ?>').on('click', function() {
							bootbox.confirm("Are you sure you want to delete this post?", function(result) {

								$.post("includes/form_handlers/delete_post.php?post_id=<?php echo $id; ?>", {result:result});

								if(result)
									location.reload();

							});
						});


					});

				</script>
					<?php

				} //End while loop

				if($count > $limit) 
					$str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
								<input type='hidden' class='noMorePosts' value='false'>";
				else 
					$str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align: centre;' class='noMorePostsText'> No more posts to show! </p>";
			}

			echo $str;
		}

		public function getSinglePost($post_id) {

			$userLoggedIn = $this->user_obj->getUsername();

			$opened_query = mysqli_query($this->con, "UPDATE notifications SET opened='yes' WHERE user_to='$userLoggedIn' AND link LIKE '%=$post_id'");

			$str = ""; //String to return 
			$data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE deleted='no' AND id='$post_id'");

			if(mysqli_num_rows($data_query) > 0) {


				$row = mysqli_fetch_array($data_query); 
					$id = $row['id'];
					$body = $row['body'];
					$added_by = $row['added_by'];
					$date_time = $row['date_added'];

					//Prepare user_to string so it can be included even if not posted to a user
					if($row['user_to'] == "none") {
						$user_to = "";
					}
					else {
						$user_to_obj = new User($this->con, $row['user_to']);
						$user_to_name = $user_to_obj->getFirstAndLastName();
						$user_to = "to <a href='" . $row['user_to'] ."'>" . $user_to_name . "</a>";
					}

					//Check if user who posted, has their account closed
					$added_by_obj = new User($this->con, $added_by);
					if($added_by_obj->isClosed()) {
						return;
					}

					if($userLoggedIn == $added_by)
						$delete_button = "<button class='delete_button btn-danger' id='post$id'>X</button>";
					else 
						$delete_button = "";


					$user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
					$user_row = mysqli_fetch_array($user_details_query);
					$first_name = $user_row['first_name'];
					$last_name = $user_row['last_name'];
					$profile_pic = $user_row['profile_pic'];


					?>
					<script> 
						function toggle<?php echo $id; ?>(e) {

 							if( !e ) e = window.event;

							var target = $(e.target);
							if (!target.is("a")) {
								var element = document.getElementById("toggleComment<?php echo $id; ?>");

								if(element.style.display == "block") 
									element.style.display = "none";
								else 
									element.style.display = "block";
							}
						}
					</script>
					<?php

					$comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE post_id='$id'");
					$comments_check_num = mysqli_num_rows($comments_check);


					//Timeframe
					$date_time_now = date("Y-m-d H:i:s");
					$start_date = new DateTime($date_time); //Time of post
					$end_date = new DateTime($date_time_now); //Current time
					$interval = $start_date->diff($end_date); //Difference between dates 
					if($interval->y >= 1) {
						if($interval == 1)
							$time_message = $interval->y . " year ago"; //1 year ago
						else 
							$time_message = $interval->y . " years ago"; //1+ year ago
					}
					else if ($interval->m >= 1) {
						if($interval->d == 0) {
							$days = " ago";
						}
						else if($interval->d == 1) {
							$days = $interval->d . " day ago";
						}
						else {
							$days = $interval->d . " days ago";
						}


						if($interval->m == 1) {
							$time_message = $interval->m . " month". $days;
						}
						else {
							$time_message = $interval->m . " months". $days;
						}
					}
					else if($interval->d >= 1) {
						if($interval->d == 1) {
							$time_message = "Yesterday";
						}
						else {
							$time_message = $interval->d . " days ago";
						}
					}
					else if($interval->h >= 1) {
						if($interval->h == 1) {
							$time_message = $interval->h . " hour ago";
						}
						else {
							$time_message = $interval->h . " hours ago";
						}
					}
					else if($interval->i >= 1) {
						if($interval->i == 1) {
							$time_message = $interval->i . " minute ago";
						}
						else {
							$time_message = $interval->i . " minutes ago";
						}
					}
					else {
						if($interval->s < 30) {
							$time_message = "Just now";
						}
						else {
							$time_message = $interval->s . " seconds ago";
						}
					}

					$str .= "<div class='status_post' onClick='javascript:toggle$id()'>
								<div class='post_profile_pic'>
									<img src='$profile_pic' width='50'>
								</div>

								<div class='posted_by' style='color:#ACACAC;'>
									<a href='$added_by'> $first_name $last_name </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message
									$delete_button
								</div>
								<div id='post_body'>
									$body
									<br>
									<br>
									<br>
								</div>

								<div class='newsfeedPostOptions'>
									Comments($comments_check_num)&nbsp;&nbsp;&nbsp;
									<iframe src='like.php?post_id=$id' scrolling='no'></iframe>
								</div>
							</div>
							<div class='post_comment' id='toggleComment$id' style='display:none;'>
								<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
							</div>
							<hr>";


					?>
					<script>

					$(document).ready(function() {

						$('#post<?php echo $id; ?>').on('click', function() {
							bootbox.confirm("Are you sure you want to delete this post?", function(result) {

								$.post("includes/form_handlers/delete_post.php?post_id=<?php echo $id; ?>", {result:result});

								if(result)
									location.reload();

							});
						});


					});

				</script>
					<?php
			}
			else {
				echo "<p>No post found. If you clicked a link, it may be broken.</p>";
						return;
			}

			echo $str;
		}
	
		public function loadOwnPosts($data, $limit){
			$page = $data['page']; 
			$userLoggedIn = $this->user_obj->getUsername();
			$user_id = $this->user_obj->getUserId();
			
			if($page == 1) 
				$start = 0;
			else 
				$start = ($page - 1) * $limit;


			$str = ""; //String to return 
			$data_query = mysqli_query($this->con, "SELECT * FROM posts WHERE added_by='$userLoggedIn' AND deleted='no' ORDER BY id DESC");

			if(mysqli_num_rows($data_query) > 0) {


				$num_iterations = 0; //Number of results checked (not necasserily posted)
				$count = 1;

				while($row = mysqli_fetch_array($data_query)) {
					$id = $row['id'];
					$body = $row['body'];
					$skills = $row['skills_needed'];
					$added_by = $row['added_by'];
					$date_time = $row['date_added'];
					$approved = $row['approved'];

					//check approve or not 
					if ($row['approved'] == 'yes') {
						$a = "<i class='fa fa-check' style='color:#4cd137; font-size: 20px;'></i>";
					}else{
						$a = "<i class='fa fa-spinner' style='color:#44bd32; font-size: 20px;' ></i>";
					}

					//Prepare user_to string so it can be included even if not posted to a user
					if($row['user_to'] == "none") {
						$user_to = "";
					}
					else {
						$user_to_obj = new User($this->con, $row['user_to']);
						$user_to_name = $user_to_obj->getFirstAndLastName();
						$user_to = "to <a href='" . $row['user_to'] ."'>" . $user_to_name . "</a>";
					}

					//Check if user who posted, has their account closed
					$added_by_obj = new User($this->con, $added_by);
					if($added_by_obj->isClosed()) {
						continue;
					}

					if($num_iterations++ < $start)
						continue; 


					//Once 10 posts have been loaded, break
					if($count > $limit) {
						break;
					}
					else {
						$count++;
					}

					if($userLoggedIn == $added_by){
						$delete_button = "<button class='delete_button btn-danger' id='post$id'>X</button>";
					}else {
						$delete_button = "";
					}

					$user_details_query = mysqli_query($this->con, "SELECT first_name, last_name, profile_pic FROM users WHERE username='$added_by'");
					$user_row = mysqli_fetch_array($user_details_query);
					$first_name = $user_row['first_name'];
					$last_name = $user_row['last_name'];
					$profile_pic = $user_row['profile_pic'];


					?>
					<script> 
						function toggle<?php echo $id; ?>() {

							var target = $(event.target);
							if (!target.is("a")) {
								var element = document.getElementById("toggleComment<?php echo $id; ?>");

								if(element.style.display == "block") 
									element.style.display = "none";
								else 
									element.style.display = "block";
							}
						}

					</script>
					<?php

					$comments_check = mysqli_query($this->con, "SELECT * FROM comments WHERE post_id='$id'");
					$comments_check_num = mysqli_num_rows($comments_check);


					//Timeframe
					$date_time_now = date("Y-m-d H:i:s");
					$start_date = new DateTime($date_time); //Time of post
					$end_date = new DateTime($date_time_now); //Current time
					$interval = $start_date->diff($end_date); //Difference between dates 
					if($interval->y >= 1) {
						if($interval->y == 1)
							$time_message = $interval->y . " year ago"; //1 year ago
						else 
							$time_message = $interval->y . " years ago"; //1+ year ago
					}
					else if ($interval->m >= 1) {
						if($interval->d == 0) {
							$days = " ago";
						}
						else if($interval->d == 1) {
							$days = $interval->d . " day ago";
						}
						else {
							$days = $interval->d . " days ago";
						}


						if($interval->m == 1) {
							$time_message = $interval->m . " month ". $days;
						}
						else {
							$time_message = $interval->m . " months ". $days;
						}

					}
					else if($interval->d >= 1) {
						if($interval->d == 1) {
							$time_message = "Yesterday";
						}
						else {
							$time_message = $interval->d . " days ago";
						}
					}
					else if($interval->h >= 1) {
						if($interval->h == 1) {
							$time_message = $interval->h . " hour ago";
						}
						else {
							$time_message = $interval->h . " hours ago";
						}
					}
					else if($interval->i >= 1) {
						if($interval->i == 1) {
							$time_message = $interval->i . " minute ago";
						}
						else {
							$time_message = $interval->i . " minutes ago";
						}
					}
					else {
						if($interval->s < 30) {
							$time_message = "Just now";
						}
						else {
							$time_message = $interval->s . " seconds ago";
						}
					}

					$str .= "<div class='status_post' onClick='javascript:toggle$id()'>
								<div class='post_profile_pic'>
									<img src='$profile_pic' width='50'>
								</div>

								<div class='posted_by' style='color:#ACACAC;'>
									<a href='$added_by'> $first_name $last_name </a> $user_to &nbsp;&nbsp;&nbsp;&nbsp;$time_message  &nbsp;&nbsp;&nbsp;&nbsp;
									$a $delete_button
								</div>
								<div id='post_body'>
									$body
									<br><br>
									Needed Skills: $skills
									<br>
									<br>
								</div>

								<div class='newsfeedPostOptions'>
									Comments($comments_check_num)&nbsp;&nbsp;&nbsp;
									<iframe src='like.php?post_id=$id' scrolling='no'></iframe>
								</div>

							</div>
							<div class='post_comment' id='toggleComment$id' style='display:none;'>
								<iframe src='comment_frame.php?post_id=$id' id='comment_iframe' frameborder='0'></iframe>
							</div>
							<hr>";
					

					?>
					<script>

						$(document).ready(function() {

							$('#post<?php echo $id; ?>').on('click', function() {
								bootbox.confirm("Are you sure you want to delete this post?", function(result) {

									$.post("includes/form_handlers/delete_post.php?post_id=<?php echo $id; ?>", {result:result});

									if(result)
										location.reload();

								});
							});


						});

					</script>
					<?php

				} //End while loop

				if($count > $limit) 
					$str .= "<input type='hidden' class='nextPage' value='" . ($page + 1) . "'>
								<input type='hidden' class='noMorePosts' value='false'>";
				else 
					$str .= "<input type='hidden' class='noMorePosts' value='true'><p style='text-align: centre;' class='noMorePostsText'> No more posts to show! </p>";
			}else{
				echo "<h3> You have no post! </h3>";
			}

			echo $str;
		}
	}
?>