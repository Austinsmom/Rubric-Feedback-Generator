<?php 
/**
*	Rubric Creator - Grade Edit Submit
*	 1. Updates grade in the database after user edits
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

<body id="grade">

<?php 
$gradeArray = $_POST;
$gradeID = $_POST['grade-id'];
$student = $_POST['student'];

// update student email
mysql_query("UPDATE rubric_grade SET grade_student = '$student' WHERE grade_id = '$gradeID'");

while( list( $field, $value ) = each( $gradeArray )) {
	 
	// updates radio criteria answers from database
	if ( (strpos($field, 'criteria') !== false) && is_numeric($value) ) {
	 	$gradeCriteriaID = substr($field,9);
	 	mysql_query("UPDATE rubric_grade_answers SET answer_value = '$value' WHERE answer_grade_id = '$gradeID' AND answer_criteria_id = '$gradeCriteriaID' AND is_comment = '0' AND is_textbox = '0'");	 	
	} 
	// updates comments from database
	else if ( (strpos($field, 'comment') !== false) ) {
		 	$gradeCriteriaID = substr($field,8);
		 	mysql_query("UPDATE rubric_grade_answers SET answer_value = '$value' WHERE answer_grade_id = '$gradeID' AND answer_criteria_id = '$gradeCriteriaID' AND is_comment = '1' AND is_textbox = '0'");
		} 
		// updates textbox content from database
		else if ( (strpos($field, 'textbox') !== false) ) {
			 	$gradeCriteriaID = substr($field,8);
			 	mysql_query("UPDATE rubric_grade_answers SET answer_value = '$value' WHERE answer_grade_id = '$gradeID' AND answer_criteria_id = '$gradeCriteriaID' AND is_comment = '0' AND is_textbox = '1'");
			} 
}				


?>

<body id="save">

<p>Your grade was saved. <a href="user-admin.php">Click here to go back to User Admin.</a></p>

<?php require('includes/footer.php'); ?>