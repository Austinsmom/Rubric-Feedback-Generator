<?php 
/**
*	Rubric-Feedback Generator - Functions: Class
*		1. Saves Class to the database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

/**
* Saves Class to the database
* @param $title - title of class
* @param $author - id of user creating assignment
* @param $time - semester and year of class
* @param $notes - class notes
*/
function saveClassToDatabase( $title, $author, $time, $notes ) {
	mysql_query("INSERT INTO rubric_class (class_title, class_author, class_meetingtime, class_notes) VALUES ('$title', '$author', '$time', '$notes')") or die('There was an error saving: ' . mysql_error());
}

/** 
* Deletes given class from the database
* @param $id - id of class to be deleted
*/
function deleteClass($id) {
	// remove class from database
	mysql_query("DELETE FROM rubric_class WHERE class_id = '$id'") or die();	
}

?>