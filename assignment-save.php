<?php 
/**
*	Rubric Creator - Assignment Save
*	 1. Saves assignment to database
*	 2. Links user back to admin
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
$title = $_POST['assignment-title'];
$description = $_POST['assignment-description'];
$class = $_POST['assignment-class'];
$dueDate = $_POST['assignment-duedate'];
$rubric = $_POST['assignment-rubric'];

saveAssignmentToDatabase($title, $author, $description, $class, $dueDate, $rubric);

?>

<body id="save">

Your assignment was saved. <a href="user-admin.php">Go to admin to view it.</a>

<?php require('includes/footer.php'); ?>