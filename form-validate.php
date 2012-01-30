<?php 
/**
*	Rubric Creator - Form Validate
*	 1. Validates forms
*	 2. Notifies user if their form validation failed
*	 3. Creates sessions and changes header locations accordingly
*
*	TO DO: check for injections, encrypt passwords
*		   should I create a separate validation-fail.php page?
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

	/* validate login */
	$username = $_POST['username'];
	$password = $_POST['password'];
	$sql = "SELECT * FROM rubric_user WHERE user_login='$username' and user_password='$password'";
	$result = mysql_query($sql) or die('Database connection error.');
	$count = mysql_num_rows($result);
	
	if ($count == 1) {
		setcookie("user", $username, time()+43200);
		header("Location: user-admin.php");
	}
	else {
		echo 'Wrong username and password. <a href="../index.php">Try again.</a>';
	}
	
	/* set cookie here? */
	
}
else if ($formOrigin == 'register') {
		
		/* validate registration */
		$username = $_POST['username'];
		$password = $_POST['password'];
		$email = $_POST['email'];
		$nicename = $_POST['nicename'];
		$role = "grader";
		
		$sql = "SELECT * FROM rubric_user WHERE user_login='$username'";
		$result = mysql_query($sql) or die('oh nooo');
		$count = mysql_num_rows($result);
		
		if ($count != 0) {
			echo 'That username already exists. <a href="user-register.php">Try again.</a>';
		}
		else {
			/* add user to database & celebrate */
			addUsertoDatabase($username, $password, $email, $nicename, $role);
			header('Location: /success-register.php');
		}

	}
	else {
			echo 'Okay, there seems to be some type of error. Not sure 
						what form you came from!';
		 }
?>