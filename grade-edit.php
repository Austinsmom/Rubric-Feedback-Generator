<?php 
/**
*	Rubric-Feedback Generator - Edit Grade
*	 1. Repopulates Rubric from Grade content field content
*	 2. Allows user to submit to save grade
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

?>

<body id="grade">

	<div id="title-box">
		<h1>Rubric-Feedback Generator</h1>
		<h2>Edit Grade</h2>
	</div>
	
	<?php  
		// grab grade from the database
  		$gradeID = $_POST['grade-choice'];
		$gradeQuery = mysql_query("SELECT * FROM rubric_grade WHERE grade_id='$gradeID'");
		$gradeCount = mysql_num_rows($gradeQuery);

		if ($gradeCount != 0) { 
		
			while ( $gradeRow = mysql_fetch_array($gradeQuery)) {
				
				// get grade student & assignment and print to form/screen
				$student = $gradeRow['grade_student'];
				$assignmentID = $gradeRow['grade_assignment_id'];
				$assignmentQuery = mysql_query("SELECT * FROM rubric_assignment WHERE assignment_id = '$assignmentID';");
				
				while ( $assignmentRow = mysql_fetch_array($assignmentQuery)) {
					$assignment = stripslashes($assignmentRow['assignment_title']);
				}
		
		?>
				<form id="form-grade-edit" name="form-grade-edit" method="post">
					
					<?php echo '<h3>Assignment: ' . $assignment . '</h3>'; ?>

					<fieldset class="check">
						<label for="user-email">Student's email address: </label>
						<input type="email" name="student" id="student-email" class="email" value="<?php echo htmlspecialchars($student); ?>" />
					</fieldset>

					<div id="form-output">
					<?php 
						// print rubric with id $rubricID and answers from database
						$rubricID = $gradeRow['grade_rubric_id'];
						printRubric($rubricID, $gradeID); 
					?>
					</div>
					
					<div id="form-save">
						<input type="hidden" name="grade-id" value="<?php echo $gradeID; ?>" />
						<input id="submit-grade-edit" class="save" type="submit" value="Save Grade" />
					</div>
				
				</form>
	<?php 	}
		}
		else { echo 'Error - No Grade with this ID. Contact admin for help.'; } ?>

<?php require('includes/footer.php'); ?>