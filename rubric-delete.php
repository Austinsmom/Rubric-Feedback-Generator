<?php 
/**
*	Rubric Creator - rubric Delete
*	 1. Removes rubric from the database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php');
?>

<body id="rubric">

<?php 

$rubricID = $_POST['rubric-choice'];

// get assignments with assignment_rubric_id = $rubricID
$assignmentRecords = mysql_query("SELECT * FROM rubric_assignment WHERE assignment_rubric_id = '$rubricID'");
$assignmentCount = mysql_num_rows($assignmentRecords);

// if no assignments, delete rubric from database
if ( $assignmentCount == 0 ){
	deleteRubric($rubricID);
	echo '<p>Your rubric was deleted. <a href="user-admin.php">Click here to go back to User Admin.</a></p>';
}
else {
	// else, warn user that they cannot delete rubrics with assignments
	echo '<p>You cannot delete this rubric, as there are assignments associated with it (' . $assignmentCount . ', to be exact).</p><p>Delete those assignments before deleting this rubric. <a href="user-admin.php">Click here to go back to User Admin.</a></p>';
}

?>

<?php require('includes/footer.php'); ?>