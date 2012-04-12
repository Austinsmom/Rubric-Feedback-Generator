<?php 
/**
*	Rubric Creator - Functions: User
*	 1. Adds new users to database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

/**
* Adds user from to database
* @param $username - username for user to login
* @param $password - password for user to login
* @param $email - user email
* @param $nicename - display name for user
* @param $role - user's role (default is "grader")
*/
function addUserToDatabase( $username, $password, $email, $nicename, $role) {
	mysql_query("INSERT INTO rubric_user (user_login, user_password, user_email, user_nicename, user_role) VALUES ('$username', '$password', '$email', '$nicename', '$role')") or die('There was an error saving: ' . mysql_error());
}

/**
* Updates user info in the database
* @param $username - username to edit
* @param $password - password for user to login
* @param $email - user email
* @param $nicename - display name for user
* @param $role - user's role (default is "grader")
*/
function updateUser( $username, $password, $email, $nicename, $role) {
	mysql_query("UPDATE rubric_user SET user_password = '$password', user_email = '$email', user_nicename = '$nicename', user_role = '$role' WHERE user_login = '$username'") or die('There was an error saving: ' . mysql_error());
}
?>