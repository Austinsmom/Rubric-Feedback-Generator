<?php
/**
*	Rubric Creator - Functions: Assignment
*		1. Saves Assignment to the database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

/**
* Saves Assignment to the database
* @param $section
* @param $meetingTime
* @param $notes
*/
function saveAssignmentToDatabase( $title, $author, $description, $class, $dueDate, $points ) {
	mysql_query("INSERT INTO rubric_assignment (assignment_title, assignment_author, assignment_description, assignment_class_id, assignment_duedate, assignment_points) VALUES ('$title', '$author', '$description', '$class', '$dueDate', '$points')") or die('There was an error saving: ' . mysql_error());
}
?>