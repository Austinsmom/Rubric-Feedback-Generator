<?php 
/**
*	Rubric Creator - Send Email Grade
*	 1. Emails grade to individual user
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/
if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 
?>

<body id="grade-email-send">

<?php
if(count($_POST)) {

	$emailTo = "jjschiffer@gmail.com"; // (student's email) for example: strip_tags($_POST['email']);
	$emailFrom = "schifferj@mail.montclair.edu"; // (faculty/user's email)
	$emailSubject = "Your rubric test email works!"; // Your Grade & Feedback for (assignment name) 
	$emailText = "Here is your grade content!\r\n"; // Grade content
	
	$emailHeaders = "From: " . $emailFrom . "\r\n" .
     "X-Mailer: php";
	
	if ( @mail( $emailTo, $emailSubject, $emailText, $emailHeaders) ) {
		echo 'The grade was successfully sent via email. <a href="user-admin.php">Click here to go back to User Admin.</a>';
	}
	else {
		die('Error: Unable to send email. Contact admin for help.' . mysql_error()); 
	}
}

require('includes/footer.php'); ?>