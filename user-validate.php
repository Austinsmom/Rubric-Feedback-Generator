<?php 
/**
*	Rubric Creator - Form Validate
*	 1. Authenticates login and registration forms
*	 2. Notifies user if their authentication submissions failed
*	 3. Creates sessions and changes header locations accordingly
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

foreach (glob("functions/*.php") as $filename) { 
	include $filename;
} 
rubricCreatorConnect();
$formOrigin = $_POST['form-origin'];

if ($formOrigin == 'login') {

	/* make sure that username and password combination is valid */
	$username = $_POST['username'];
	$password = md5($_POST['password']);
	$result = mysql_query("SELECT * FROM rubric_user WHERE user_login='$username' and user_password='$password'") or die('Database connection error.');
	$count = mysql_num_rows($result);
	
	if ($count !== 1) {
		echo '<p style="font-family:Helvetica,Arial,sans-serif;margin:20px;">Wrong username and password. <a href="index.php">Try again.</a></p>';
	}
	else {
		setcookie("user", $username, time()+43200);
		header("Location: user-admin.php");
	}
	
}
else if ($formOrigin == 'register') {
		
		/* make sure you don't register a username that already exists */
		$username = $_POST['username'];
		$password = md5($_POST['password']);
		$email = $_POST['email'];
		$nicename = $_POST['nicename'];
		$role = "grader";
		
		$result = mysql_query("SELECT * FROM rubric_user WHERE user_login='$username'");
		$count = mysql_num_rows($result);
		
		if ($count != 0) {
			echo '<p style="font-family:Helvetica,Arial,sans-serif;margin:20px;">That username already exists. <a href="user-register.php">Try again.</a></p>';
		}
		else {
			/* add user to database & celebrate */
			addUsertoDatabase($username, $password, $email, $nicename, $role);
			header('Location: /user-register-success.php');
		}

	}
	else {
			echo 'Okay, there seems to be some type of error. Not sure 
						what form you came from!';
		 }
?>