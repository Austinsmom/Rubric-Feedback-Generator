<?php 
/**
*	Rubric Creator - Grade Edit
*	 1. Repopulates Rubric to 
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

$student = $_POST['grade-student'];
$assignment = $_POST['grade-assignment'];
$content = $_POST['grade-content'];
$points = $_POST['grade-points'];

saveGradeToDatabase($student, $assignment, $content, $points);

?>

<body id="save">

Your grade was saved. <a href="user-admin.php">Go to admin to view it.</a>

<?php require('includes/footer.php'); ?>