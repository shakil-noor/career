<?php 
	include("includes/header.php");
	$err_msg = array();

	if(isset($_POST['post']) & !empty($_POST["post_text"]) & !empty($_POST['skills'])){
		$post = new Post($con, $userLoggedIn);
		$post->submitPost($_POST['post_text'], 'none', $_POST['skills'], $err_msg);
	}

	if(isset($_POST['post']) & empty($_POST['post_text'])){
		array_push($err_msg, "Please write the description");
	}else if(isset($_POST['post']) & empty($_POST['skills'])){
		array_push($err_msg, "Please select the needed skills");
	}

 ?>
	<div class="user_details column">
		<a href="<?php echo $userLoggedIn; ?>">  <img src="<?php echo $user['profile_pic']; ?>"> </a>

		<div class="user_details_left_right">
			<a href="<?php echo $userLoggedIn; ?>">
			<?php 
				echo $user['first_name'] . " " . $user['last_name'];
			 ?>
			</a>
			<br>
			<?php 
				echo "Posts: " . $user['num_post']. "<br>"; 
				echo "Likes: " . $user['num_like'];
			?>
		</div>

	</div>

	

	<div class="main_column column">
		<form class="post_form" action="index.php" method="POST">
			<textarea name="post_text" id="post_text" placeholder="Write about job advertisement..."></textarea><br/>
			<?php 
				if(in_array("Please write the description", $err_msg)) 
					echo "<span style='color: #e74c3c; font-size: 18px;'>Please write the description</span><br>";
			?>

			<h4>Select Needed skills</h4>
			<select class="select_option" name="skills[ ]" multiple="multiple" style="width: 80%; height: 98px;">
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
            </select>
            
			<input type="submit" name="post" id="post_button" value="Post"><br>
			<?php 
				if(in_array("Please select the needed skills", $err_msg)) 
					echo "<span style='color: #e74c3c; font-size: 18px;'>Please select the needed skills</span><br>";
			?>
			<?php 
				if(in_array("Your post is successfully submited please wait for admin's approve", $err_msg)) 
					echo "<span style='color: #14C800; font-size: 18px;'>Your post is successfully submited please wait for admin's approve</span><br>";
			?>
			<hr>

		</form>

		<div class="posts_area"></div>
		<!-- <button id="load_more">Load More Posts</button> -->
		<img id="loading" src="assets/images/icons/loading.gif">

	</div>
	
	<script>
	var userLoggedIn = '<?php echo $userLoggedIn; ?>';
	$(document).ready(function() {
		$('#loading').show();
		//Original ajax request for loading first posts 
		$.ajax({
			url: "includes/handlers/ajax_load_posts.php",
			type: "POST",
			data: "page=1&userLoggedIn=" + userLoggedIn,
			cache:false,

			success: function(data) {
				$('#loading').hide();
				$('.posts_area').html(data);
			}
		});
		$(window).scroll(function() {
			var height = $('.posts_area').height(); //Div containing posts
			var scroll_top = $(this).scrollTop();
			var page = $('.posts_area').find('.nextPage').val();
			var noMorePosts = $('.posts_area').find('.noMorePosts').val();

			if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
			//if (noMorePosts == 'false') {
				$('#loading').show();

				var ajaxReq = $.ajax({
					url: "includes/handlers/ajax_load_posts.php",
					type: "POST",
					data: "page=" + page + "&userLoggedIn=" + userLoggedIn,
					cache:false,

					success: function(response) {
						$('.posts_area').find('.nextPage').remove(); //Removes current .nextpage 
						$('.posts_area').find('.noMorePosts').remove(); //Removes current .nextpage 
						$('.posts_area').find('.noMorePostsText').remove(); //Removes current .nextpage 

						$('#loading').hide();
						$('.posts_area').append(response);
					}
				});
			} //End if 
			return false;
		}); //End (window).scroll(function())
	});
	</script>
	</div> <!-- Close wrapper class -->
</body>
</html>
