<?php include("includes/header.php"); ?>


<?php 

$post_query = mysqli_query($con, "SELECT * FROM posts WHERE deleted='no' AND approved='yes' ORDER BY id DESC");
$result = mysqli_fetch_array($post_query);
$id = $result['id'];


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
                            Posts
                         
                        </h1>
                          <p class="bg-success">
                            <?php //echo $message; ?>
                        </p>

                        <div class="col-md-12">

                            <table class="table table-hover">
                                <thead>
                                    <tr>
                                        <th>Id</th>
                                        <th>Post Body</th>
                                        <th>Skills</th>
                                        <th>Added By</th>
                                        <th>Date</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                <?php foreach($post_query as $posts){ ?>
                                    <tr>
                                    	 <td><?php echo $posts['id']; ?> </td>
                                       <td style="width: 650px; text-align: justify;"><?php echo $posts['body']; ?> </td>       
                                       <td><?php echo $posts['skills_needed']; ?></td>
                                       <td><?php echo $posts['added_by']; ?></td>
                                       <td><?php echo $posts['date_added']; ?></td>
                                       <td><button class="btn btn-danger" ><a onclick="confirm('Are you sure to delete this item?')" href="deletePost.php?id=<?php echo $posts['id']; ?>" style="color:#fff; text-decoration:none" >Delete</a></button></td>
<!--																			<td><button class="btn btn-danger" id='post$id'>Delete</button></td>-->
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