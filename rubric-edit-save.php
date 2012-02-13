<?php 
/**
*	Rubric Creator - Save Rubric Edits
*	 1. saves the rubric edit to database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/
if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$rubricID = $_POST['rubric-id'];
$rubricAuthor = $username;
$rubricTitle = $_POST['form-title'];
$rubricDescription = $_POST['form-description'];
$rubricContent = stripslashes($_POST['finalDelimitedText']);

/* if there is no rubric title, set default title */
if ($rubricTitle == null) {
	$rubricTitle = "Untitled Rubric";
}

editRubric($rubricID,$rubricAuthor,$rubricTitle,$rubricDescription,$rubricContent);

?>

<body id="save">

Your rubric was saved. <a href="user-admin.php">Go to admin to view it.</a>


<?php require('includes/footer.php'); ?>