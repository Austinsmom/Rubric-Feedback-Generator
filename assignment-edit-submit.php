<?php 
/**
*	Rubric Creator - Save Assignment Edits
*	 1. saves the assignment edit to database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/
if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$assignmentID = $_POST['assignment-id'];
$assignmentTitle = $_POST['assignment-title'];
$assignmentDueDate = $_POST['assignment-duedate'];
$assignmentDescription = $_POST['assignment-description'];
$assignmentClass = $_POST['assignment-class'];
$assignmentRubric = $_POST['assignment-rubric'];

mysql_query("UPDATE rubric_assignment SET assignment_title = '$assignmentTitle', assignment_duedate = '$assignmentDueDate', assignment_description = '$assignmentDescription', assignment_class_id = '$assignmentClass', assignment_rubric_id = '$assignmentRubric' WHERE assignment_id = '$assignmentID';");	 	

?>

<body id="save">

Your assignment was saved. <a href="user-admin.php">Click here to go back to User Admin.</a>


<?php require('includes/footer.php'); ?>