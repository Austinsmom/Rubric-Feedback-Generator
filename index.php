<?php 
/**
*	Rubric Creator - User Login
*	 1. Login form
*	 2. Validation of Login form entry
*	 3. Valid login takes user to Admin page
* 	
*	TO DO: Allow a checkbox for user to say they want a year-long cookie?
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

require('includes/header.php'); 
 
?>


<body id="login">

<h1>Rubric Creator - Login</h1>

<p>Fill out the following form to log in. No login? <a href="user-register.php">Register for an account here.</a></p>

<form id="form-login" name="form-login" action="form-validate.php" method="post">
	<p>
		<label for="username">Username: 
		<input type="text" name="username" /></label>
	</p>
	
	<p>
		<label for="password">Password: 
		<input type="password" name="password" /></label>
	</p>
	
	<input type="hidden" name="form-origin" value="login">
	<input type="submit" value="submit" />
</form>

<?php require('includes/footer.php'); ?>