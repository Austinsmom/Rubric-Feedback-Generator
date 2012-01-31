<?php 
/**
*	Rubric Creator - Edit Form
*	 1. allows the user to edit existing rubric
*	 2. allows the user to delete existing rubric
*	 3. allows the user to copy content to new rubric
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
$rubricTitle = $_POST['form-title'];
$rubricDescription = $_POST['form-description'];
$rubricContent = stripslashes($_POST['finalDelimitedText']);

saveRubricToDatabase($rubricAuthor,$rubricTitle,$rubricDescription,$rubricContent);

?>

<body id="save">

Your rubric was saved. <a href="user-admin.php">Go to admin to view it.</a>


<?php require('includes/footer.php'); ?>