<?php 
/**
*	Rubric Creator - Save Class Edits
*	 1. saves the class edit to database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/
if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$classID = $_POST['id'];
$classTitle = $_POST['title'];
$classTime = $_POST['time'];
$classNotes = $_POST['notes'];

mysql_query("UPDATE rubric_class SET class_title = '$classTitle', class_meetingtime = '$classTime', class_notes = '$classNotes'  WHERE class_id = '$classID'");	 	

?>

<body id="save">

Your class was saved. <a href="class-admin.php">Go to your Class list to view it.</a>


<?php require('includes/footer.php'); ?>