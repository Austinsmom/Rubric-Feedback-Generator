<?php 
/**
*	Rubric-Feedback Generator - User Register
*	 1. Registration form
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric-Feedback Generator
*/

require('includes/header.php'); ?>

<body id="register">

<h1>Register</h1>

<p>Fill out the following form to register for a Rubric-Feedback Generator account.</p>

<form id="form-register" name="form-register" method="post">
	<p>
		<label for="username">Username:</label>
		<input type="text" name="username" id="username" />
	</p>
	
	<p>
		<label for="password">Password:</label>
		<input type="password" name="password" id="password" />
	</p>
	
	<p>
		<label for="nicename">Display Name:</label>
		<input type="text" name="nicename" id="nicename" />
	</p>
		
	<p>
		<label for="email">Email Address:</label>
		<input type="email" name="email" id="email" />
	</p>

	<input type="hidden" name="form-origin" value="register">	
	<input type="submit" value="Submit" id="user-register" />
</form>

<?php require('includes/footer.php'); ?>