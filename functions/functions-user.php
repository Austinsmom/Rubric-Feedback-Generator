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
* Adds user from registerValidate() to database
* @param $username
* @param $password
* @param $email
* @param $nicename
* @param $role
*/
function addUserToDatabase( $username, $password, $email, $nicename, $role) {
	mysql_query("INSERT INTO rubric_user (user_login, user_password, user_email, user_nicename, user_role) VALUES ('$username', '$password', '$email', '$nicename', '$role')") or die('There was an error saving: ' . mysql_error());
}
?>