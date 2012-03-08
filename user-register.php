<?php 
/**
*	Rubric Creator - User Register
*	 1. Registration form
*	 2. Validation of Registration form entry
*	 3. Valid registration takes user to Login page
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

require('includes/header.php'); ?>

<body id="register">

<h1>Rubric Creator - Register</h1>

<p>Fill out the following form to register for a Rubric Creator account.</p>

<form id="form-register" name="form-register" action="user-validate.php" method="post">
	<p>
		<label for="username">Username: 
		<input type="text" name="username" /></label>
	</p>
	
	<p>
		<label for="password">Password: 
		<input type="password" name="password" /></label>
	</p>
	
	<p>
		<label for="nicename">Display Name: 
		<input type="nicename" name="nicename" /></label>
	</p>
		
	<p>
		<label for="email">Email Address: 
		<input type="email" name="email" /></label>
	</p>

	<input type="hidden" name="form-origin" value="register">	
	<input type="submit" value="submit" />
</form>


<?php require('includes/footer.php'); ?>