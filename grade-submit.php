<?php 
/**
*	Rubric Creator - Grade Submit
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

$gradeTotal = 0;
$inputCount = 1; 
$gradeContent = "";
$gradeRubric = $_POST['rubric-id'];
$gradeAssignment = $_POST['rubric-assignment'];

$gradeArray = $_POST;

while( list( $field, $value ) = each( $_POST )) {
	 $gradeContent .= $field . ' ::: ' . htmlspecialchars($value) . '///';
	 
	if ( (strpos($field, 'criteria') !== false) && is_numeric($value) ) {
	// add grade point values for each radio criteria graded

		$gradeValue = mysql_query("SELECT * FROM rubric_criteria_values WHERE value_id='$value'");
		$count = mysql_num_rows($gradeValue);
	
		if ( $count != 0 ) {
			while ( $valueRecord = mysql_fetch_array($gradeValue)) {
	 			$valuePoints = $valueRecord['value_points'];
	 			$gradeTotal += $valuePoints;
	 		}
	 	}
	 	
	} else if ( $field == 'student' ) {
				$gradeStudent = $value;
			}
}			

saveGradeToDatabase($gradeStudent, $gradeRubric, $gradeAssignment, $gradeContent, $gradeTotal);						

$gradeID = mysql_insert_id();

while( list( $field, $value ) = each( $gradeArray )) {
	 
	if ( (strpos($field, 'criteria') !== false) && is_numeric($value) ) {
	 	$gradeCriteriaID = substr($field,9);
	 	mysql_query("INSERT INTO rubric_grade_answers (answer_grade_id, answer_criteria_id, answer_value, is_comment) VALUES ('$gradeID', '$gradeCriteriaID', '$value', '0')") or die('There was an error saving: ' . mysql_error());
	} 
	else if ( (strpos($field, 'comment') !== false) ) {
		 	$gradeCriteriaID = substr($field,8);
		 	mysql_query("INSERT INTO rubric_grade_answers (answer_grade_id, answer_criteria_id, answer_value, is_comment) VALUES ('$gradeID', '$gradeCriteriaID', '$value', '1')") or die('There was an error saving: ' . mysql_error());
		} 
}				


?>

<body id="save">

Your grade was saved. <a href="user-admin.php">Go to admin.</a>

<?php require('includes/footer.php'); ?>