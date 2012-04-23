<?php 
/**
*	Rubric-Feedback Generator - User Logout
*	 1. Deletes user cookie
*	 2. Returns user to login page
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

setcookie("user", "", time()-3600);
header('Location: index.php');

?>