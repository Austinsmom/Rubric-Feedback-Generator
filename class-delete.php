<?php 
/**
*	Rubric-Feedback Generator - Class Delete
*	 1. Removes class from the database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php');
?>

<body id="class">

<?php 

$classID = $_POST['class-choice'];

// get assignments with assignment_class_id = $classID
$assignmentRecords = mysql_query("SELECT * FROM rubric_assignment WHERE assignment_class_id = $classID");
$assignmentCount = mysql_num_rows($assignmentRecords);

// if no assignments, delete class from database
if ( $assignmentCount == 0 ){
	deleteClass($classID);
	echo '<p>Your class was deleted. <a href="user-admin.php">Click here to go back to User Admin.</a></p>';
}
else {
	// else, warn user that they cannot delete classes with assignments
	echo '<p>You cannot delete this class, as there are assignments associated with it (' . $assignmentCount . ', to be exact).</p><p>Delete those assignments before deleting this class. <a href="user-admin.php">Click here to go back to User Admin.</a></p>';
}

?>

<?php require('includes/footer.php'); ?>