<?php 
/**
*	Rubric Creator - Functions: Save Rubric
*	 1. Saves rubric to the database
*	 2. Shows list of all rubrics created
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

function saveRubricToDatabase($author, $title, $content) {
	$content = mysql_real_escape_string($content);
	mysql_query("INSERT INTO rubric_form (rubric_author, rubric_title, rubric_content) VALUES ('$author', '$title', '$content')") or die('There was an error saving: ' . mysql_error());
}

?>