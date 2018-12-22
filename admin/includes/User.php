<?php 
class User{
   public $id;
   public $name;
	 public $email;
	 public $username;
	 public $password;
   
   public function find_all_users(){
      $find_users = mysqli_query($con, "SELECT * FROM users");
      
   }

}
?>