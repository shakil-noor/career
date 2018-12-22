<?php include("includes/header.php"); 

include("approvePost.php"); ?>


        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            
        <?php include("includes/top_nav.php") ?>

            <!-- Sidebar Menu Items -->
    
        <?php include("includes/side_nav.php"); ?>
           <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">                     
											
											<?php 

												//sql query to find out the user that still not approved
												$new_post_query = mysqli_query($con, "SELECT * FROM posts WHERE approved='no' AND deleted='no' ORDER BY id DESC");
												if(mysqli_num_rows($new_post_query) == 0){
													echo "<h3>There is no post to authorze</h3>";
												}else{
											?>
                        <h1 class="page-header">
                            New Posts
                         
                        </h1>
                          <p class="bg-success">
                            <?php //echo $message; ?>
                        </p>

                        <div class="col-md-12">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Body</th>
                                        <th>Needed Skills</th>
                                        <th>Added By</th>
                                        <th>Date Added</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php foreach($new_post_query as $post){ ?>
                                    <tr>
                                      <td><?php echo $post['id']; ?></td>
                                      <td style="width: 700px; text-align: justify;"><?php echo $post['body']; ?> </td>  
                                      <td><?php echo $post['skills_needed']; ?></td>
                                      <td><?php echo $post['added_by']; ?></td>
																			<td><?php echo $post['date_added']; ?></td>
																			
                                      <td><button class="btn btn-success"><a href="approvePost.php?id=<?php echo $post['id']; ?>&username=<?php echo $post['added_by'];?>" style="color:#fff; text-decoration:none" id="confirmApprove">Approve</a></button></td>
                                    </tr>


                                <?php } //end foreach
                                   ?>
        
                                </tbody>
                            </table> <!--End of Table-->
                        

                        </div>
                        <?php } ?>
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->
  <?php include("includes/footer.php"); ?>