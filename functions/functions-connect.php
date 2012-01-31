<?php 
/**
*	Rubric Creator - Functions: Connect to MySQL
*	Functions necessary to connect the database of the Rubric Creator
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

/**
* Connects to the mysql database
*/
function rubricCreatorConnect() {
	
	$link = mysql_connect('localhost', 'root', 'root');
	if (!$link) {
		die('Could not connect to mysql: ' . mysql_error());
	}
	
	$rubricDatabase = mysql_select_db("rubric_creator", $link);
	if (!$rubricDatabase) {
		die('Could not reach database: ' . mysql_error());
	}
}

?>