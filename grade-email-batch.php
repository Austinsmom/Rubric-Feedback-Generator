<?php 
/**
*	Rubric-Feedback Generator - Verify Batch Grade Emails
*	 1. Generates example grade email content for user to confirm before sending
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$gradeArray = $_POST['grades'];
$serializedGrades = serialize($_POST['grades']);

// get grade info
$gradeID = $gradeArray[0];
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

// get logged in user info for "from" address and nicename
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

// get assignment info for this grade
$assignmentQuery = mysql_query("SELECT * FROM rubric_assignment WHERE assignment_id = '$assignmentID'");
$assignmentCount = mysql_num_rows($assignmentQuery);					
if ($assignmentCount == 1 ) {
	while ( $assignmentRow = mysql_fetch_array($assignmentQuery) ) {
		$assignmentTitle = stripslashes($assignmentRow['assignment_title']);
		$classID = $assignmentRow['assignment_class_id'];
		
		// get class title for this class
		$classQuery = mysql_query("SELECT * FROM rubric_class WHERE class_id = '$classID'");
		$classCount = mysql_num_rows($classQuery);					
		if ($classCount == 1 ) {
			while ( $classRow = mysql_fetch_array($classQuery) ) {
				$classTitle = stripslashes($classRow['class_title']);
			}
		}
		else {
			echo "Error - multiple classes with this ID exists. Contact admin for help.";
		}
	}
}
else {
	echo "Error - multiple assignments with this ID exists. Contact admin for help.";
}

$emailSubject = '[' . $classTitle . '] Assignment grade and feedback for ' . $assignmentTitle;

?>

<body id="grade-email">

	<div id="title-box">
		<h1>Rubric-Feedback Generator</h1>
		<h2>Email grade confirmation</h2>
	</div>

	<form id="form-email" name="form-email" action="grade-email-batch-send.php" method="post">
	
		<fieldset>
			<legend>Grades will be sent out to the following email(s):</legend>
			
			<ul>
			<?php 
				for ( $i = 0; $i <= sizeOf($gradeArray); $i++ ) {
				
					$gradeListID = $gradeArray[$i];
					$gradeRecords = mysql_query("SELECT * FROM rubric_grade WHERE grade_id = '$gradeListID'");
					
					while ( $rowGrades = mysql_fetch_array($gradeRecords) ) {
						// list all emails that will be receiving grades
						echo '<li>' . $rowGrades['grade_student'] . '</li>';
					}
				}
			
			?>
			</ul>
			
		</fieldset>
		
		<fieldset>
			<legend>Here is an example of what the email messages will look like.</legend>
				
			<div id="email-header">
				<p>Sent to: <?php echo $student; ?></p>
				<p>Sent from: <?php echo $userEmail; ?></p>
				<p>Subject: <?php echo $emailSubject; ?></p>
			</div>
			
			<div id="email-content">

				<?php 
					$emailContent = gradeEmailContent($gradeID, $userNicename, $assignmentTitle);
					echo $emailContent;
				?>
				
			</div>
		</fieldset>
			
		<input type="hidden" name="email-from" value="<?php echo $userEmail; ?>" />
		<input type="hidden" name="email-nicename" value="<?php echo addslashes($userNicename); ?>" />
		<input type="hidden" name="email-assignment" value="<?php echo addslashes($assignmentTitle); ?>" />
		<input type="hidden" name="email-subject" value="<?php echo addslashes($emailSubject); ?>" />
		<input type="hidden" name="grade-array" value='<?php echo $serializedGrades; ?>' />
		
		<input type="submit" value="Send Batch Emails" id="send-batch-email" />
	</form>
			
<?php require('includes/footer.php'); ?>