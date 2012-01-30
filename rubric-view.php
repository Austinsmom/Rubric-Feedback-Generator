<?php 
/**
*	Rubric Creator - Rubric View
*	 View of a chosen rubric
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); ?>

<body id="rubric">

	<p>Welcome to the admin page, <?php echo $_COOKIE["user"]; ?>!</p>
	
	<p><a href="user-logout.php">Click here to log out.</a></p>

<?php require('includes/footer.php'); ?>