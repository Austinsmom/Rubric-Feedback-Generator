<?php 
/**
*	Rubric Creator - Generate Email Grade
*	 1. Generates grade email content
*	 2. Lets user confirm the sending of grade email
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/
if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$gradeID = $_POST['grade-choice'];
$gradeQuery = mysql_query("SELECT * FROM rubric_grade WHERE grade_id = '$gradeID'");
$gradeCount = mysql_num_rows($gradeQuery);					
if ($gradeCount == 1 ) {
	while ( $gradeRow = mysql_fetch_array($gradeQuery) ) {
		$student = $gradeRow['grade_student'];
		$assignmentID = $gradeRow['grade_assignment_id'];
	}
}
else {
	echo "Error - multiple grades with this ID exists. Contact admin for help.";
}

$userQuery = mysql_query("SELECT * FROM rubric_user WHERE user_login = '$username'");
$userCount = mysql_num_rows($userQuery);					
if ($userCount == 1 ) {
	while ( $userRow = mysql_fetch_array($userQuery) ) {
		$userEmail = $userRow['user_email'];
		$userNicename = $userRow['user_nicename'];
	}
}
else {
	echo "Error - multiple users with this username exists. Contact admin for help.";
}

$assignmentQuery = mysql_query("SELECT * FROM rubric_assignment WHERE assignment_id = '$assignmentID'");
$assignmentCount = mysql_num_rows($assignmentQuery);					
if ($assignmentCount == 1 ) {
	while ( $assignmentRow = mysql_fetch_array($assignmentQuery) ) {
		$assignmentTitle = $assignmentRow['assignment_title'];
	}
}
else {
	echo "Error - multiple assignments with this ID exists. Contact admin for help.";
}

$emailSubject = '[' . $assignmentTitle . '] Assignment grade and feedback';

?>

<body id="grade-email">

<h1>Email grade confirmation</h1>

<form id="form-email" name="form-email" method="post">
	<fieldset>
	
		<legend>Here is what the email message will look like.</legend>
			
				<div id="email-header">
					<p>Sent to: <?php echo $student; ?></p>
					<p>Sent from: <?php echo $userEmail; ?></p>
					<p>Subject: <?php echo $emailSubject; ?></p>
				</div>
				
				<div id="email-content">

					<?php $emailContent = gradeEmailContent($gradeID, $userNicename, $assignmentTitle);
						  echo $emailContent;
					?>
					
				</div>
		
		</fieldset>
		
	<!--	<input type="hidden" name="email-to" value="<?php echo $student; ?>" />
		<input type="hidden" name="email-from" value="<?php echo $userEmail; ?>" />
		<input type="hidden" name="email-assignment" value="<?php echo $assignmentTitle; ?>" />
		<input type="hidden" name="email-subject" value="<?php echo $emailSubject; ?>" />
		<input type="hidden" name="email-content" value="<?php echo addslashes($emailContent); ?>" /> -->
		
		<input type="hidden" name="grade-id" value="<?php echo $gradeID; ?>" />
		
		<input type="submit" value="Send Email" id="send-email" />
	
</form>
			
<?php require('includes/footer.php'); ?>