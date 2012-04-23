<?php 
/**
*	Rubric-Feedback Generator - Save Class Edits
*	 1. saves the class edit to database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/
if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$classID = $_POST['class-id'];
$classTitle = $_POST['class-title'];
$classTime = $_POST['class-time'];
$classNotes = $_POST['class-notes'];

mysql_query("UPDATE rubric_class SET class_title = '$classTitle', class_meetingtime = '$classTime', class_notes = '$classNotes'  WHERE class_id = '$classID'");	 	

?>

<body id="save">

<p>Your class was saved. <a href="user-admin.php">Click here to go back to User Admin.</a></p>


<?php require('includes/footer.php'); ?>