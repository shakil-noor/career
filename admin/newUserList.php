<?php include("includes/header.php"); ?>

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
												$new_user_query = mysqli_query($con, "SELECT * FROM users WHERE approved='no' ORDER BY id DESC");
												if(mysqli_num_rows($new_user_query) == 0){
													echo "<h3>There is no users to authorze</h3>";
												}else{
											?>
                        <h1 class="page-header">
                            New Users
                         
                        </h1>
                          <p class="bg-success">
                            <?php //echo $message; ?>
                        </p>

                        <div class="col-md-12">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Uni_id</th>
                                        <th>Photo</th>
                                        <th>First Name</th>
                                        <th>Last Name </th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php foreach($new_user_query as $user){ ?>
                                    <tr>
                                        <td><?php echo $user['uni_ID_Number']; ?> </td>
                                        <td><img class="admin-user-thumbnail user_image user-img" src="<?php echo "../".$user['profile_pic']; ?>" alt=""></td>
                                            
                                        <td><?php echo $user['first_name']; ?> </td>  
                                        <td><?php echo $user['last_name']; ?></td>
                                        <td><?php echo $user['username']; ?></td>
    									<td><?php echo $user['email']; ?></td>				
                                        <td><button class="btn btn-success"><a href="approveUser.php?username=<?php echo $user['username']; ?>" style="color:#fff; text-decoration:none">Approve</a></button></td>
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