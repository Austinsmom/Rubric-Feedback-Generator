<?php 
/**
*	Rubric-Feedback Generator - Assignment Edit
*	 1. Lets user edit assignment and submit those edits
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
		
<body id="class-edit">

	<div id="title-box">
		<h1>Rubric-Feedback Generator</h1>
		<h2>Edit Assignment:<br />
	
	<?php
		$assignmentTitle = stripslashes($_POST['assignment-title']);
		$classTitle = stripslashes($_POST['class-title']);

		echo $assignmentTitle . ' <em>for ' . $classTitle . '</em>'; ?></h2>
		
	</div>
	
	<?php  
		$assignmentID = $_POST['assignment-choice'];
		$assignmentRecords = mysql_query("SELECT * FROM rubric_assignment WHERE assignment_id='$assignmentID'");
		$count = mysql_num_rows($assignmentRecords);

		if ($count != 0) { 
			// get assignment info and repopulate form to edit it
			while ( $assignmentRow = mysql_fetch_array($assignmentRecords)) {
				$title = stripslashes($assignmentRow['assignment_title']);
				$description = stripslashes($assignmentRow['assignment_description']);
				$date = $assignmentRow['assignment_duedate'];
				$rubric = $assignmentRow['assignment_rubric_id'];
		?>
				<form id="form-assignment-edit" name="form-assignment-edit" method="post">
					
					<p>
						<label for="assignment-title">Title:</label>
						<input type="text" name="assignment-title" id="assignment-title" class="text" value="<?php echo htmlspecialchars($title); ?>" />
					</p>
					
					<p>
						<label for="assignment-description">Description:</label>
						<input type="text" name="assignment-description" id="assignment-description" class="text" value="<?php echo htmlspecialchars($description); ?>" />
					</p>
				
					<p>
					<label for="assignment-rubric">Rubric</label>
					
						<?php 
						
							// see if there are grades for this assignment already
							$assignmentGrades = mysql_query("SELECT * FROM rubric_grade WHERE grade_assignment_id = '$assignmentID'");
							$assignmentGradesCount = mysql_num_rows($assignmentGrades);
							
							if ( $assignmentGradesCount != 0 ) {
								echo '[<em>You already have ' . $assignmentGradesCount . ' grade(s) for this assignment. You cannot change the rubric unless you delete them.</em>]';							
							}
							else {
								// get rubrics to choose for this assignment
								$rubricRecord = mysql_query("SELECT * FROM rubric_form WHERE rubric_author='$username'");
								$count = mysql_num_rows($rubricRecord);
							
								if ( $count == 0 ) {
									// if there are no rubrics, tell user to make one
									echo '[<em>You have not created any rubrics. <a href="rubric-new.php">Click here to create one</a>.</em>]';
								}
								else {
									// select current rubric, let user select other options
									echo '<select name="assignment-rubric">';
									while ( $rubricRow = mysql_fetch_array($rubricRecord)) {
										$rubricID = $rubricRow['rubric_id'];
										$rubricTitle = stripslashes($rubricRow['rubric_title']);
										
										if ( $rubric == $rubricID ){
											echo '<option value="' . $rubricID . '" selected>' . $rubricTitle . '</option>';
										}
										else {
											echo '<option value="' . $rubricID . '">' . $rubricTitle . '</option>';
										}
									}
									echo '</select>';
								}
							}						
						?>
					</p>
					
					<p>
					<label for="assignment-duedate">Due Date (yyyy-mm-dd):</label>
					<input type="text" name="assignment-duedate" id="assignment-duedate" class="text" value="<?php echo $date; ?>" />
					</p>

					<input type="hidden" name="assignment-id" value="<?php echo $assignmentID; ?>" />
					<input type="submit" value="Submit Assignment Edits" id="submit-assignment-edit" />
									
				</form>
	<?php 	}
		}
		else { echo 'Error - No assignment with this ID. Contact admin for help.'; } ?>

<?php require('includes/footer.php'); ?>