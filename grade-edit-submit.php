<?php 
/**
*	Rubric Creator - Grade Edit Submit
*	 1. Updates grade in the database after user edits
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

$gradeArray = $_POST;
$gradeID = $_POST['grade-id'];

while( list( $field, $value ) = each( $gradeArray )) {
	 
	if ( (strpos($field, 'criteria') !== false) && is_numeric($value) ) {
	 	$gradeCriteriaID = substr($field,9);
	 	mysql_query("UPDATE rubric_grade_answers SET answer_value = '$value' WHERE answer_grade_id = '$gradeID' AND answer_criteria_id = '$gradeCriteriaID' AND is_comment = '0'");	 	
	} 
	else if ( (strpos($field, 'comment') !== false) ) {
		 	$gradeCriteriaID = substr($field,8);
		 	mysql_query("UPDATE rubric_grade_answers SET answer_value = '$value' WHERE answer_grade_id = '$gradeID' AND answer_criteria_id = '$gradeCriteriaID' AND is_comment = '1'");
		} 
}				


?>

<body id="save">

Your grade was saved. <a href="user-admin.php">Go to admin.</a>

<?php require('includes/footer.php'); ?>