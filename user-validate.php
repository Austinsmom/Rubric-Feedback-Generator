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
			header('Location: user-register-success.php');
		}

	}
	else if ($formOrigin == 'edit') {
		
			$username = $_POST['username'];
			$submittedPassword = $_POST['password'];
			$email = $_POST['email'];
			$nicename = $_POST['nicename'];
			$role = "grader";
			
			// if password is blank, then don't update password
			if ( $submittedPassword == "" ) {
				
				// get password from database
				$userRecord = mysql_query("SELECT * FROM rubric_user WHERE user_login='$username'");
				$userCount = mysql_num_rows($userRecord);
				if ($userCount == 1) {
					while ( $userRow = mysql_fetch_array($userRecord)) {
						$password = $userRow['user_password'];
					}
				}
			}
			else {
				$password = md5($submittedPassword);
			}
			
			// update user
			updateUser($username, $password, $email, $nicename, $role);
			header('Location: user-edit-success.php');
		}
		else {
				echo 'Okay, there seems to be some type of error. Contact admin for help.';
			 }
?>