<?php 
/**
*	Rubric Creator - Grade Delete
*	 1. Removes grade from the database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php');
?>

<body id="grade">

<?php 

$gradeID = $_POST['grade-choice'];
deleteGrade($gradeID);

?>

<p>Your grade was deleted. <a href="user-admin.php">Click here to go back to User Admin.</a></p>

<?php require('includes/footer.php'); ?>