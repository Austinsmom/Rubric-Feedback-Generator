<?php 
/**
*	Rubric Creator - Grade Save
*	 1. Saves grade to database
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

$rubricID = $_POST['grade-rubric-id'];
$student = $_POST['grade-student'];
$assignment = $_POST['grade-assignment'];
$content = $_POST['grade-content'];
$points = $_POST['grade-points'];

saveGradeToDatabase($student, $rubricID, $assignment, $content, $points);

?>

<body id="save">

Your grade was saved. <a href="user-admin.php">Go to admin.</a>

<?php require('includes/footer.php'); ?>