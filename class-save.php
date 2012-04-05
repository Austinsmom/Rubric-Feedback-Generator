<?php 
/**
*	Rubric Creator - Class Save
*	 1. Saves new class to database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$author = $username;
$title = $_POST['class-title'];
$time = $_POST['class-time'];
$notes = $_POST['class-notes'];

// saves new class to the database
saveClassToDatabase($title, $author, $time, $notes);

?>

<body id="save">

<p>Your class was saved. <a href="user-admin.php">Click here to go back to User Admin.</a></p>

<?php require('includes/footer.php'); ?>