<?php 
/**
*	Rubric-Feedback Generator - Grade Submit
*	 1. Saves grade to database
*	 2. Links user back to admin
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 


// Get Grade content from POST
$gradeTotal = 0;
$inputCount = 1; 
$gradeRubric = $_POST['rubric-id'];
$gradeAssignment = $_POST['rubric-assignment'];
$gradeArray = $_POST;

while( list( $field, $value ) = each( $_POST )) {
	if ( $field == 'student' ) {
		$gradeStudent = $value;
	}
}			


// Save Grade to database
saveGradeToDatabase($gradeStudent, $gradeRubric, $gradeAssignment);						


// Save this Grade's Grade Answers to database
$gradeID = mysql_insert_id();

while( list( $field, $value ) = each( $gradeArray )) {
	if ( (strpos($field, 'criteria') !== false) && is_numeric($value) ) {
	 	$gradeCriteriaID = substr($field,9);
	 	mysql_query("INSERT INTO rubric_grade_answer (answer_grade_id, answer_criteria_id, answer_value, answer_is_comment, answer_is_textbox) VALUES ('$gradeID', '$gradeCriteriaID', '$value', '0','0')") or die('There was an error saving: ' . mysql_error());
	} 
	else if ( (strpos($field, 'comment') !== false) ) {
		 	$gradeCriteriaID = substr($field,8);
		 	mysql_query("INSERT INTO rubric_grade_answer (answer_grade_id, answer_criteria_id, answer_value, answer_is_comment, answer_is_textbox) VALUES ('$gradeID', '$gradeCriteriaID', '$value', '1','0')") or die('There was an error saving: ' . mysql_error());
		} 
		else if ( (strpos($field, 'textbox') !== false) ) {
			 	$gradeCriteriaID = substr($field,8);
			 	mysql_query("INSERT INTO rubric_grade_answer (answer_grade_id, answer_criteria_id, answer_value, answer_is_comment, answer_is_textbox) VALUES ('$gradeID', '$gradeCriteriaID', '$value', '0', '1')") or die('There was an error saving: ' . mysql_error());
			}
}				

?>

<body id="save">

<p>Your grade was saved. <a href="user-admin.php">Click here to go back to User Admin.</a></p>

<?php require('includes/footer.php'); ?>