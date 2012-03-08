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

?>