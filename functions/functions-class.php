<?php 
/**
*	Rubric Creator - Functions: Class
*		1. Saves Class to the database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

/**
* Saves Class to the database
* @param $title
* @param $time
* @param $notes
*/
function saveClassToDatabase( $title, $author, $time, $notes ) {
	mysql_query("INSERT INTO rubric_class (class_title, class_author, class_meetingtime, class_notes) VALUES ('$title', '$author', '$time', '$notes')") or die('There was an error saving: ' . mysql_error());
}
?>