<?php 
/**
*	Rubric Creator - Functions: Connect to MySQL
*		1. Functions necessary to connect the database of the Rubric Creator
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

/**
* Connects to the mysql database
*/
function rubricCreatorConnect() {
	
	// your host, your username, your password
	$link = mysql_connect('localhost', 'root', 'root');
	if (!$link) {
		die('Could not connect to mysql: ' . mysql_error());
	}
	
	// your database name
	$rubricDatabase = mysql_select_db("rubric_creator", $link);
	if (!$rubricDatabase) {
		die('Could not reach database: ' . mysql_error());
	}
}

?>