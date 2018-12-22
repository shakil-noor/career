<?php include("includes/header.php"); ?>


<?php 
$msg ="";
$user_query = mysqli_query($con, "SELECT * FROM users WHERE approved='yes'");
//$result = mysqli_fetch_array($users);

 ?>
        <!-- Navigation -->
        <nav class="navbar navbar-inverse navbar-fixed-top" role="navigation">
            <!-- Brand and toggle get grouped for better mobile display -->
        <?php include("includes/top_nav.php") ?>

            <!-- Sidebar Menu Items - These collapse to the responsive navigation menu on small screens -->
    
        <?php include("includes/side_nav.php"); ?>
           <!-- /.navbar-collapse -->
        </nav>

        <div id="page-wrapper">

            <div class="container-fluid">

                <!-- Page Heading -->
                <div class="row">
                    <div class="col-lg-12">                     

                        <h1 class="page-header">
                            Users
                         
                        </h1>
                          <p class="bg-success">
                            <?php echo $msg; ?>
                        </p>

												<!--  <a href="add_user.php" class="btn btn-primary">Add User</a>-->

                        <div class="col-md-12">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Photo</th>
                                        <th>First Name</th>
                                        <th>Last Name </th>
                                        <th>Username</th>
                                        <th>Email</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php foreach($user_query as $user){ ?>
                                    <tr>
                                    	<td><?php echo $user['uni_ID_Number']; ?> </td>
                                    
                                      <td><img class="admin-user-thumbnail user_image user-img" src="<?php echo "../".$user['profile_pic']; ?>" alt="profile_pic"></td>
                                        
                                      <td><?php echo $user['first_name']; ?> </td>  
                                      <td><?php echo $user['last_name']; ?></td>
                                      <td><?php echo $user['username']; ?></td>
																			<td><?php echo $user['email']; ?></td>
																			
                                      <td><button class="btn btn-danger"><a href="deleteUser.php?username=<?php echo $user['username']; ?>" style="color:#fff; text-decoration:none">Delete</a></button></td>
                                    </tr>


                                <?php } //end foreach
                                   ?>
        
                                </tbody>
                            </table> <!--End of Table-->
                        

                        </div>
                        
                    </div>
                </div>
                <!-- /.row -->

            </div>
            <!-- /.container-fluid -->

        </div>
        <!-- /#page-wrapper -->

  <?php include("includes/footer.php"); ?>