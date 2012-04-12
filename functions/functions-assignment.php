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
* @param $title - title of assignment
* @param $author - id user creating assignment
* @param $description - description of assignment
* @param $class - id of class this assignment was assigned to
* @param $dueDate - date assignment is due
* @param $rubric - id of rubric used to grade this assignment
*/
function saveAssignmentToDatabase( $title, $author, $description, $class, $dueDate, $rubric ) {
	mysql_query("INSERT INTO rubric_assignment (assignment_title, assignment_author, assignment_description, assignment_class_id, assignment_duedate, assignment_rubric_id) VALUES ('$title', '$author', '$description', '$class', '$dueDate', '$rubric')") or die('There was an error saving: ' . mysql_error());
}
?>