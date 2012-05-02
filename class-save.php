<?php 
/**
*	Rubric-Feedback Generator - Class Save
*	 1. Saves new class to database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$author = $username;
$title = addslashes($_POST['class-title']);
$time = addslashes($_POST['class-time']);
$notes = addslashes($_POST['class-notes']);

// saves new class to the database
saveClassToDatabase($title, $author, $time, $notes);

?>

<body id="save">

<p>Your class was saved. <a href="user-admin.php">Click here to go back to User Admin.</a></p>

<?php require('includes/footer.php'); ?>