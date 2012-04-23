<?php 
/**
*	Rubric-Feedback Generator - Assignment Save
*	 1. Saves assignment to database
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
$title = $_POST['assignment-title'];
$description = $_POST['assignment-description'];
$class = $_POST['assignment-class'];
$dueDate = $_POST['assignment-duedate'];
$rubric = $_POST['assignment-rubric'];

saveAssignmentToDatabase($title, $author, $description, $class, $dueDate, $rubric);

?>

<body id="save">

<p>Your assignment was saved. <a href="user-admin.php">Click here to go back to User Admin.</a></p>

<?php require('includes/footer.php'); ?>