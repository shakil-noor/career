<?php
	include_once '../config/config.php';

	//SQL to drop database;
	$sqlToDropDB = "DROP DATABASE IF EXISTS career_view;";
	if ($con->query($sqlToDropDB) === TRUE) {
		echo "Database droped successfully<br>";
	} else {
		echo "Error: " . $sqlToDropDB . "<br>" . $con->error. "<br>";
	}
	//exit();

	//SQL to create database;
	$sqlToCreateDB = "CREATE DATABASE career_view;";
	if ($con->query($sqlToCreateDB) === TRUE) {
		echo "Database created successfully<br>";
	} else {
		echo "Error: " . $sqlToCreateDB . "<br>" . $con->error. "<br>";
	}
	
	$sqlToUseDB = "USE career_view;";
	if ($con->query($sqlToUseDB) === TRUE) {
		echo "Database selected successfully<br>";
	} else {
		echo "Error: " . $sqlToUseDB . "<br>" . $con->error. "<br>";
	}

	//SQL to create table admin
	$admin_sql = "CREATE TABLE admin (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `name` varchar(35) NOT NULL,
	  `username` varchar(50) NOT NULL,
	  `email` varchar(100) NOT NULL,
	  `password` varchar(255) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;";

	if ($con->query($admin_sql) === TRUE) {
		echo "admin table created successfully<br>";
	} else {
		echo "Error: " . $admin_sql . "<br>" . $con->error. "<br>";
	}

	//inser admin
	$insertsql = "INSERT INTO `career_view`.`admin` 
	(`name`,`username`, `email`, `password`) 
	VALUES 
	('Admin','admin', 'admin@daffodil.ac', 'e10adc3949ba59abbe56e057f20f883e');";

	if ($con->query($insertsql) === TRUE) {
		echo "Admin created successfully<br>
		<b>email:admin@daffodil.ac<br>password:123456</b><br>";
	} else {
		echo "Error: " . $insertsql2 . "<br>" . $con->error. "<br>";
	}

	//SQL to create table users
	$user_sql = "CREATE TABLE users (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `uni_ID_Number` varchar(20) NOT NULL,
	  `first_name` varchar(25) NOT NULL,
	  `last_name` varchar(25) NOT NULL,
	  `username` varchar(50) NOT NULL,
	  `email` varchar(100) NOT NULL,
	  `password` varchar(255) NOT NULL,
	  `signup_date` date NOT NULL,
	  `profile_pic` varchar(200) NOT NULL,
	  `num_post` int(11) NOT NULL,
	  `num_like` int(11) NOT NULL,
      `approved` varchar(4) NOT NULL,
	  `user_closed` varchar(4) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;";

	if ($con->query($user_sql) === TRUE) {
		echo "users table created successfully<br>";
	} else {
		echo "Error: " . $user_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create user_skills
	$user_skills = "CREATE TABLE user_skills (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `user_id` int(11) NOT NULL,
	  `skill` varchar(30) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;";

	if ($con->query($user_skills) === TRUE) {
		echo "user_skills table created successfully<br>";
	} else {
		echo "Error: " . $user_skills . "<br>" . $con->error. "<br>";
	}

	//SQL for create comment table
	$comment_sql = "CREATE TABLE comments (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `post_body` text NOT NULL,
	  `posted_by` varchar(50) NOT NULL,
	  `posted_to` varchar(50) NOT NULL,
	  `date_added` date NOT NULL,
	  `removed` varchar(5) NOT NULL,
	  `post_id` int(11) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;";

	if ($con->query($comment_sql) === TRUE) {
		echo "commenta table created successfully<br>";
	} else {
		echo "Error: " . $comment_sql . "<br>" . $con->error. "<br>";
	}

	//SQL for create likes table
	$likes_sql = "CREATE TABLE likes (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `username` varchar(50) NOT NULL,
	  `post_id` varchar(50) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;";

	if ($con->query($likes_sql) === TRUE) {
		echo "likes table created successfully<br>";
	} else {
		echo "Error: " . $likes_sql . "<br>" . $con->error. "<br>";
	}

	//SQL for create posts table
	$posts_sql = "CREATE TABLE posts (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `body` text NOT NULL,
	  `skills_needed` varchar(255) NOT NULL,
	  `added_by` varchar(50) NOT NULL,
	  `user_to` varchar(50) NOT NULL,
	  `date_added` datetime NOT NULL,
	  `user_closed` varchar(4) NOT NULL,
	  `deleted` varchar(4) NOT NULL,
	  `likes` int(11) NOT NULL,
	  `approved` varchar(4) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;";

	if ($con->query($posts_sql) === TRUE) {
		echo "likes table created successfully<br>";
	} else {
		echo "Error: " . $posts_sql . "<br>" . $con->error. "<br>";
	}

	//SQL to create post_skills
	$post_skills = "CREATE TABLE post_skills (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `post_id` int(11) NOT NULL,
	  `skill` varchar(30) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;";

	if ($con->query($post_skills) === TRUE) {
		echo "post_skills table created successfully<br>";
	} else {
		echo "Error: " . $post_skills . "<br>" . $con->error. "<br>";
	}

	//SQL for create messages table
	$messages_sql = "CREATE TABLE messages (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `user_to` varchar(50) NOT NULL,
	  `user_from` varchar(50) NOT NULL,
	  `body` text NOT NULL,
	  `date` datetime NOT NULL,
	  `opened` varchar(3) NOT NULL,
	  `viewed` varchar(3) NOT NULL,
	  `deleted` varchar(3) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;";

	if ($con->query($messages_sql) === TRUE) {
		echo "notifications table created successfully<br>";
	} else {
		echo "Error: " . $messages_sql . "<br>" . $con->error. "<br>";
	}

	//SQL for create notifications table
	$notifications_sql = "CREATE TABLE notifications (
	  `id` int(11) NOT NULL AUTO_INCREMENT,
	  `user_to` varchar(50) NOT NULL,
	  `user_from` varchar(50) NOT NULL,
	  `message` text NOT NULL,
	  `link` varchar(100) NOT NULL,
	  `datetime` datetime NOT NULL,
	  `opened` varchar(3) NOT NULL,
	  `viewed` varchar(3) NOT NULL,
	  PRIMARY KEY (`id`)
	) ENGINE=InnoDB AUTO_INCREMENT=16 DEFAULT CHARSET=latin1;";

	if ($con->query($notifications_sql) === TRUE) {
		echo "notifications table created successfully<br>";
	} else {
		echo "Error: " . $notifications_sql . "<br>" . $con->error. "<br>";
	}
?>