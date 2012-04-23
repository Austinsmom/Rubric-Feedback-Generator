<?php 
/**
*	Rubric-Feedback Generator - User Login
*	 1. Login form
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

require('includes/header.php'); 
 
?>

<body id="login">

	<div id="title-box">
		<h1>Rubric-Feedback Generator</h1>
		<h2>Login</h2>
	</div>

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