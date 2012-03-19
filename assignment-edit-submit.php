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

$assignmentID = $_POST['id'];
$assignmentTitle = $_POST['title'];
$assignmentDueDate = $_POST['date'];
$assignmentDescription = $_POST['description'];

mysql_query("UPDATE rubric_assignment SET assignment_title = '$assignmentTitle', assignment_duedate = '$assignmentDueDate', assignment_description = '$assignmentDescription' WHERE assignment_id = '$assignmentID';");	 	

echo '<p>' . $assignmentID . '</p>';
echo '<p>' . $assignmentTitle . '</p>';
echo '<p>' . $assignmentDueDate . '</p>';
echo '<p>' . $assignmentDescription . '</p>';

?>

<body id="save">

Your assignment was saved. <a href="class-admin.php">Click here to go back to your class list.</a>


<?php require('includes/footer.php'); ?>