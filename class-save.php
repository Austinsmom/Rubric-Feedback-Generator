<?php 
/**
*	Rubric Creator - Class Save
*	 1. Saves class to database
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
$title = $_POST['class-title'];
$time = $_POST['class-time'];
$notes = $_POST['class-notes'];

saveClassToDatabase($title, $author, $time, $notes);

?>

<body id="save">

Your class was saved. <a href="user-admin.php">Go to admin to view it.</a>

<?php require('includes/footer.php'); ?>