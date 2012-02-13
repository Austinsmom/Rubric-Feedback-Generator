<?php 
/**
*	Rubric Creator - Functions: Grade
*		1. Saves Grade to the database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

/**
* Saves Grade to the database
* @param $student
* @param $rubricID
* @param $assignment
* @param $content
* @param $points
*/
function saveGradeToDatabase( $student, $rubricID, $assignment, $content, $points ) {
	mysql_query("INSERT INTO rubric_grade (grade_student, grade_rubric_id, grade_assignment_id, grade_content, grade_points) VALUES ('$student', '$rubricID', '$assignment', '$content', '$points')") or die('There was an error saving: ' . mysql_error());
}

/**
* Converts Grade into $_POST data to repopulate form
* @param $gradeContent
*/
function gradeToPost( $gradeContent ) {

	$inputsArray = explode('///', $gradeContent);
	
	$criteria = array();
	$count = 1;
	
	foreach ($inputsArray as $lineItem) {
		$criteria[$count] = explode( ':::', $lineItem );
		$count++;
	}
	
	for ( $i = 0; $i <= count($criteria) - 1; $i++ ) {
	
		while( list( $field, $value ) = each( $criteria[$i] )) {
			echo '<p><strong>' . $field . ':</strong> ' . $value . '</p>';
		}	
		
	}

}


/**
* Converts Grade into HTML data, for view on web and sending email
* @param $gradeContent
*/
function gradeToHTML( $gradeContent ) {
	
}

?>