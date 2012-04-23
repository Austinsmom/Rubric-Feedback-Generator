<?php 
/**
*	Rubric-Feedback Generator - User Login
*	 1. Login form
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric-Feedback Generator
*/

require('includes/header.php'); 
 
?>

<body id="login">

<h1>Login</h1>

<p>Fill out the following form to log in. No login? <a href="user-register.php">Register for an account here.</a></p>

<form id="form-login" name="form-login" method="post">
	<p>
		<label for="username">Username: </label>
		<input type="text" name="username" id="username" class="text" />
	</p>
	
	<p>
		<label for="password">Password: </label>
		<input type="password" name="password" id="password" class="text" />
	</p>
	
	<input type="hidden" name="form-origin" value="login">
	<input type="submit" value="submit" id="user-login" />
</form>

<?php require('includes/footer.php'); ?>