<?php 
/**
*	Rubric-Feedback Generator - Save Form
*	 1. saves the form to database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric-Feedback Generator
*/
if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$rubricAuthor = $username;
$rubricTitle = $_POST['form-title'];
$rubricDescription = addslashes($_POST['form-description']);
$rubricContent = addslashes($_POST['finalDelimitedText']);

// if there is no rubric title, set default title 
if ($rubricTitle == null) {
	$rubricTitle = "Untitled Rubric";
}

saveRubricToDatabase($rubricAuthor,$rubricTitle,$rubricDescription,$rubricContent);

?>

<body id="save">

<p>Your rubric was saved. <a href="user-admin.php">Click here to go back to User Admin.</a></p>

<?php require('includes/footer.php'); ?>