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
		$assignmentTitle = $_POST['assignment-title'];
		$classTitle = $_POST['class-title'];

		echo stripSlashes($assignmentTitle) . ' <em>for ' . stripSlashes($classTitle) . '</em>'; ?></h2>
		
	</div>
	
	<?php  
		$assignmentID = $_POST['assignment-choice'];
		$assignmentRecords = mysql_query("SELECT * FROM rubric_assignment WHERE assignment_id='$assignmentID'");
		$count = mysql_num_rows($assignmentRecords);

		if ($count != 0) { 
			// get assignment info and repopulate form to edit it
			while ( $assignmentRow = mysql_fetch_array($assignmentRecords)) {
				$title = $assignmentRow['assignment_title'];
				$description = $assignmentRow['assignment_description'];
				$date = $assignmentRow['assignment_duedate'];
		?>
				<form id="form-assignment-edit" name="form-assignment-edit" method="post">
					
					<p>
						<label for="assignment-title">Title:</label>
						<input type="text" name="assignment-title" id="assignment-title" class="text" value="<?php echo $title; ?>" />
					</p>
					
					<p>
						<label for="assignment-description">Description:</label>
						<input type="text" name="assignment-description" id="assignment-description" class="text" value="<?php echo $description; ?>" />
					</p>
				
					<p>
					<label for="assignment-rubric">Rubric</label>
					
						<?php 
							// get rubrics to choose for this assignment
							$rubricRecord = mysql_query("SELECT * FROM rubric_form WHERE rubric_author='$username'");
							$count = mysql_num_rows($rubricRecord);
						
							if ( $count == 0 ) {
								// if there are no rubrics, tell user to make one
								echo '[<strong>You have not created any rubrics. <a href="rubric-new.php">Click here to create one</a>.</strong>]';
							}
							else {
								// if there are rubrics, let user select one for this assignment
								echo '<select name="assignment-rubric">';
								while ( $rubricRow = mysql_fetch_array($rubricRecord)) {
									$rubricID = $rubricRow['rubric_id'];
									$rubricTitle = $rubricRow['rubric_title'];
									echo '<option value="' . $rubricID . '">' . $rubricTitle . '</option>';
								}
								echo '</select>';
							}						
						?>
					</p>
					
					<p>
					<label for="assignment-duedate">Due Date (YYYY-MM-DD):</label>
					<input type="text" name="assignment-duedate" id="assignment-duedate" class="text" value="<?php echo $date; ?>" />
					</p>

					<input type="hidden" name="assignment-id" value="<?php echo $assignmentID; ?>" />
					<input type="submit" value="Submit Assignment Edits" id="submit-assignment-edit" />
									
				</form>
	<?php 	}
		}
		else { echo 'Error - No assignment with this ID. Contact admin for help.'; } ?>

<?php require('includes/footer.php'); ?>