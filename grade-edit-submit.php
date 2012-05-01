<?php 
/**
*	Rubric-Feedback Generator - Edit Grade Submit
*	 1. Updates grade in the database after user edits
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
	 	
	 	$gradedRows = mysql_query("SELECT * FROM rubric_grade_answer WHERE answer_grade_id = '$gradeID' AND answer_criteria_id = '$gradeCriteriaID' AND answer_is_comment= '0' AND answer_is_textbox = '0'");
	 	$gradedRowsCount = mysql_num_rows($gradedRows);
	 	
	 	if ( $gradedRowsCount == 1 ) {
	 		// if radio was already graded, update in database
	 		mysql_query("UPDATE rubric_grade_answer SET answer_value = '$value' WHERE answer_grade_id = '$gradeID' AND answer_criteria_id = '$gradeCriteriaID' AND answer_is_comment = '0' AND answer_is_textbox = '0'");	
	 	}
	 	else if ( $gradedRowsCount == 0 ) {
	 			// if radio was added after first grade made, add to database 	
	 			mysql_query("INSERT INTO rubric_grade_answer (answer_grade_id, answer_criteria_id, answer_value, answer_is_comment, answer_is_textbox) VALUES ('$gradeID', '$gradeCriteriaID', '$value', '0','0')") or die('There was an error saving: ' . mysql_error());
	 		}
	 		else { /* do nothing */ }
	} 
	// updates comments from database
	else if ( (strpos($field, 'comment') !== false) ) {
			$gradeCriteriaID = substr($field,8);
		 	
		 	$gradedRows = mysql_query("SELECT * FROM rubric_grade_answer WHERE answer_grade_id = '$gradeID' AND answer_criteria_id = '$gradeCriteriaID' AND answer_is_comment= '1' AND answer_is_textbox = '0'");
	 		$gradedRowsCount = mysql_num_rows($gradedRows);
	 	
	 		if ( $gradedRowsCount == 1 ) {
	 			// if comment was already added, update in database
		 		mysql_query("UPDATE rubric_grade_answer SET answer_value = '$value' WHERE answer_grade_id = '$gradeID' AND answer_criteria_id = '$gradeCriteriaID' AND answer_is_comment = '1' AND answer_is_textbox = '0'");
		 	}
		 	else if ( $gradedRowsCount == 0 ) {
		 			// if comment was added after first grade made, add to database
		 			mysql_query("INSERT INTO rubric_grade_answer (answer_grade_id, answer_criteria_id, answer_value, answer_is_comment, answer_is_textbox) VALUES ('$gradeID', '$gradeCriteriaID', '$value', '1','0')") or die('There was an error saving: ' . mysql_error());
		 		}
		 		else { /* do nothing */ }
		} 
		// updates textbox content from database
		else if ( (strpos($field, 'textbox') !== false) ) {
				$gradeCriteriaID = substr($field,8);
			 	
		 		$gradedRows = mysql_query("SELECT * FROM rubric_grade_answer WHERE answer_grade_id = '$gradeID' AND answer_criteria_id = '$gradeCriteriaID' AND answer_is_comment= '0' AND answer_is_textbox = '1'");
	 			$gradedRowsCount = mysql_num_rows($gradedRows);

				if ( $gradedRowsCount == 1 ) {
			 		// if textbox was already added, update in database
			 		mysql_query("UPDATE rubric_grade_answer SET answer_value = '$value' WHERE answer_grade_id = '$gradeID' AND answer_criteria_id = '$gradeCriteriaID' AND answer_is_comment = '0' AND answer_is_textbox = '1'");
			 	}
			 	else if ( $gradedRowsCount == 0 ) {
			 			// if textbox was added after first grade made, add to database
			 			mysql_query("INSERT INTO rubric_grade_answer (answer_grade_id, answer_criteria_id, answer_value, answer_is_comment, answer_is_textbox) VALUES ('$gradeID', '$gradeCriteriaID', '$value', '0', '1')") or die('There was an error saving: ' . mysql_error());
			 		}
			 		else { /* do nothing */ }
			} 
}				


?>

<body id="save">

<p>Your grade was saved. <a href="user-admin.php">Click here to go back to User Admin.</a></p>

<?php require('includes/footer.php'); ?>