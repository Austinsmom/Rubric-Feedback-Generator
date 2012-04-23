<?php 
/**
*	Rubric-Feedback Generator - Send Email Grade
*	 1. Emails grade to individual user
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$emailTo = $_POST['email-to'];
$emailFrom = $_POST['email-from'];
$assignment = $_POST['email-assignment'];
$emailSubject = stripSlashes($_POST['email-subject']);
$gradeID = $_POST['grade-id'];
$userNicename = $_POST['email-nicename'];
$emailContent = stripSlashes(gradeEmailContent($gradeID, $userNicename, $assignment));
?>

<body id="grade-email-send">

<?php
if(count($_POST)) {
	// email header setup
	$emailHeaders = 'MIME-Version: 1.0' . "\r\n";
	$emailHeaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
	$emailHeaders .= 'To: ' . $emailTo . "\r\n";
	$emailHeaders .= 'From: ' . $emailFrom . "\r\n";
	
	// send email
	if ( @mail( $emailTo, $emailSubject, $emailContent, $emailHeaders) ) {
		echo '<p>The grade was successfully sent via email. <a href="user-admin.php">Click here to go back to User Admin.</a></p>';
	}
	else {
		die('Error: Unable to send email. Contact admin for help.' . mysql_error()); 
	}
}

require('includes/footer.php'); ?>