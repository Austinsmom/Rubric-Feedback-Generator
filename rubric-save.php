<?php 
/**
*	Rubric Creator - Save Form
*	 1. saves the form to database
*	 2. allows the user to select form to start sending
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/
if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$rubricAuthor = $username;
$rubricTitle = "My Rubric";
$rubricContent = stripslashes($_POST['finalDelimitedText']);

saveRubricToDatabase($rubricAuthor,$rubricTitle,$rubricContent);

?>

<body id="save">

Your rubric was saved. <a href="user-admin.php">Go to admin to view it.</a>


<?php require('includes/footer.php'); ?>