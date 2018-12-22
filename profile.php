 <?php 
	include("includes/header.php");

	if (isset($_GET['profile_username'])) {
		$username = $_GET['profile_username'];
		$user_details_query = mysqli_query($con, "SELECT * FROM users WHERE username='$username'");
		$user_array = mysqli_fetch_array($user_details_query);
		//$num_friends = (substr_count($user_array['friend_array'], ",")) ;
	}


?>
	<style type="text/css">
		.wrapper{
			margin-left: 0;
			padding-left: 0;
		}
	</style>


	<div class="profile_left">
		<img src="<?php echo $user_array['profile_pic']; ?>">

		<div class="profile_info">
			<p><?php echo "Post: ". $user_array['num_post']; ?></p>
			<p><?php echo "Likes: ". $user_array['num_like']; ?></p>
		</div>

		

		<button type="button" class="btn btn-primary" style= "margin: 5px;"> <a style="text-decoration: none; color: #fff;" href="messages.php?u=<?php echo $username;?>"><i class="fa fa-pencil-square-o" aria-hidden="true"></i>Send Messages </a></button>
	</div>
	<div class="main_column column">

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
				url: "includes/handlers/ajax_load_profile_posts.php",
				type: "POST",
				data: "page=1&userLoggedIn=" + userLoggedIn,
				cache:false,

				success: function(data) {
					$('#loading').hide();
					$('.posts_area').html(data);
				}
			});

			$(window).scroll(function() {
			//$('#load_more').on("click", function() {

				var height = $('.posts_area').height(); //Div containing posts
				var scroll_top = $(this).scrollTop();
				var page = $('.posts_area').find('.nextPage').val();
				var noMorePosts = $('.posts_area').find('.noMorePosts').val();

				if ((document.body.scrollHeight == document.body.scrollTop + window.innerHeight) && noMorePosts == 'false') {
				//if (noMorePosts == 'false') {
					$('#loading').show();

					var ajaxReq = $.ajax({
						url: "includes/handlers/ajax_load_profile_posts.php",
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

	</div>





</body>
</html>