<?php 
/**
*	Rubric-Feedback Generator - Send Batch Grade Emails
*	 1. Emails grade to each individual user in batch
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$gradeArray = unserialize(stripslashes($_POST['grade-array']));

$emailFrom = $_POST['email-from'];
$assignment = stripslashes($_POST['email-assignment']);
$emailSubject = stripslashes($_POST['email-subject']);
$userNicename = stripslashes($_POST['email-nicename']);

?>

<body id="grade-email-batch-send">

<?php
	// for each gradeID in batch array $gradeArray, send out email
	for ( $i = 0; $i < sizeOf($gradeArray); $i++ ) {
		
		//get this grade's id
		$gradeID = $gradeArray[$i];
		
		// get the emailTo address
		$gradeRecords = mysql_query("SELECT * FROM rubric_grade WHERE grade_id = '$gradeID'");
		$gradeRecordsCount = mysql_num_rows($gradeRecords);
		
		if ( $gradeRecordsCount == 1 ) {
			while ( $rowGrades = mysql_fetch_array($gradeRecords) )	{
				$emailTo = $rowGrades['grade_student'];
			}	
		}
		
		// get email content for this individual email
		$emailContent = gradeEmailContent($gradeID, $userNicename, $assignment);

		// email header setup
		$emailHeaders = 'MIME-Version: 1.0' . "\r\n";
		$emailHeaders .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
		$emailHeaders .= 'To: ' . $emailTo . "\r\n";
		$emailHeaders .= 'From: ' . $emailFrom . "\r\n";
		
		// send email
		if ( @mail( $emailTo, $emailSubject, $emailContent, $emailHeaders) ) {
			echo '<li>Grade was successfully sent to <em>'. $emailTo . '</em>.</li>';
		}
		else {
			die('Error: Unable to send email. Contact admin for help.' . mysql_error()); 
		}
		
	}
	
	echo '<p><a href="user-admin.php">Click here to go back to User Admin.</a></p>';

require('includes/footer.php'); ?>