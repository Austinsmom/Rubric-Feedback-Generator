<?php 
/**
*	Rubric-Feedback Generator - Assignment Delete
*	 1. Removes assignment from the database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric-Feedback Generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php');
?>

<body id="assignment">

<?php 

$assignmentID = $_POST['assignment-choice'];

// get grades with grade_assignment_id = $assignmentID
$gradeRecords = mysql_query("SELECT * FROM rubric_grade WHERE grade_assignment_id = $assignmentID");
$gradeCount = mysql_num_rows($gradeRecords);

// if no grades, delete assignment from database
if ( $gradeCount == 0 ){
	deleteAssignment($assignmentID);
	echo '<p>Your assignment was deleted. <a href="user-admin.php">Click here to go back to User Admin.</a></p>';
}
else {
	// else, warn user that they cannot delete assignments with grades
	echo '<p>You cannot delete this assignment, as there are grades associated with it (' . $gradeCount . ', to be exact).</p><p>Delete those grades before deleting this assignment. <a href="user-admin.php">Click here to go back to User Admin.</a></p>';
}

?>

<?php require('includes/footer.php'); ?>