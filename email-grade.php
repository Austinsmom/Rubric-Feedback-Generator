<?php 
/**
*	Rubric Creator - Save Rubric Edits
*	 1. saves the rubric edit to database
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

<body id="email">

<?php
if(count($_POST)) {

	$emailTo = "jjschiffer@gmail.com"; // (student's email) for example: strip_tags($_POST['email']);
	$emailFrom = "schifferj@mail.montclair.edu"; // (faculty/user's email)
	$emailSubject = "Your rubric test email works!"; // Your Grade & Feedback for (assignment name) 
	$emailText = "Here is your grade content!\r\n"; // Grade content
	
	$emailHeaders = "From: " . $emailFrom . "\r\n" .
     "X-Mailer: php";
	
	if ( @mail( $emailTo, $emailSubject, $emailText, $emailHeaders) ) {
		echo "IT WORRRRRRKED!!!!!! - <em>I think?</em>";
	}
	else {
		die('It didn\'t work :/ ' . mysql_error()); 
	}
}

require('includes/footer.php'); ?>