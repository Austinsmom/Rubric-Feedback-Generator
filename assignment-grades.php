<?php 
/**
*	Rubric-Feedback Generator - Assignment Grades List
*	 1. Lists grades from assignment user submitted to edit, grade, or view grades
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php');

$assignmentID = $_POST['assignment-choice'];
$assignmentTitle = $_POST['assignment-title'];

?>

<body id="admin">
	
	<div id="title-box">
		<h1>Rubric-Feedback Generator</h1>
		<h2>Grades for Assignment:<br /> <?php echo stripSlashes($assignmentTitle); ?></h2>
	</div>
	
	 <?php
		$resultGrade = mysql_query("SELECT * FROM rubric_grade WHERE grade_assignment_id = '$assignmentID'");
		$resultGradeEmails = mysql_query("SELECT * FROM rubric_grade WHERE grade_assignment_id = '$assignmentID'");;
		$count = mysql_num_rows($resultGrade);
			
		if ($count != 0) { ?>
			
			
			<?php /* Form for sending/editing individually grades. Shown by default! */ ?>
			
			<input type="submit" value="Go To 'Batch Email' Menu" id="email-batch" class="button email" />
			
			<form id="form-grade" name="form-grade" method="post" class="clearfix">
			 <fieldset class="check">
				 <legend>Select an individual grade to edit or email:</legend>

				<?php 
					while ( $row = mysql_fetch_array($resultGrade)) {
						// list each grade so the user can edit or email
						$id = $row['grade_id'];
						$student = $row['grade_student'];
						$rubric = $row['grade_rubric_id'];
						$assignment = $row['grade_assignment_id'];
						$gradeTotal = calculateGradeTotal($id);
						
						$assignmentQuery = mysql_query("SELECT * FROM rubric_assignment WHERE assignment_id = '$assignment'");
						$assignmentCount = mysql_num_rows($assignmentQuery);
						
						if ($assignmentCount != 0 ) {
							while ($assignmentRow = mysql_fetch_array($assignmentQuery)) {
								$assignment = $assignmentRow['assignment_title'];
							}
						}
						
						echo '<p><input type="radio" name="grade-choice" id="grade-' . $id . '" value="' .$id. '"> Student: ' . $student . ' &bull; Total Points: ' . $gradeTotal . '</p>';
					}		
				?>	
			 </fieldset>	
			
			 
			 <div class="buttons-left">
			 	<input type="submit" value="Email Grade" id="email-grade" />
			  </div>
			 
			 <div class="buttons-right">
				<input type="submit" value="View/Edit Grade" id="edit-grade" /><br />
			 	<input type="submit" value="Delete Grade" id="delete-grade" />
			 </div>
			 
			</form> 
			 
			
			<?php /* Form for sending batch emails. Initially hidden! */ ?>
			
			<input type="submit" value="Go To Main Grade Menu" id="grade-view-edit" class="button" />
			
			<form id="form-batch" name="form-batch" method="post" class="clearfix">
			 <fieldset id="grade-choice">
				 <legend>Select multiple grades to email to students:</legend>

				<?php 
					while ( $rowEmails = mysql_fetch_array($resultGradeEmails)) {
						// list each grade so the user can edit or email
						$id = $rowEmails['grade_id'];
						$student = $rowEmails['grade_student'];
						$rubric = $rowEmails['grade_rubric_id'];
						$assignment = $rowEmails['grade_assignment_id'];
						$gradeTotal = calculateGradeTotal($id);
						
						$assignmentEmailsQuery = mysql_query("SELECT * FROM rubric_assignment WHERE assignment_id = '$assignment'");
						$assignmentEmailsCount = mysql_num_rows($assignmentEmailsQuery);
						
						if ($assignmentEmailsCount != 0 ) {
							while ($assignmentEmailsRow = mysql_fetch_array($assignmentEmailsQuery)) {
								$assignment = $assignmentEmailsRow['assignment_title'];
							}
						}
						echo '<p><input type="checkbox" class="checkbox" name="grades[]" id="grade-' . $id . '" value="' .$id. '"> Student: ' . $student . ' &bull; Total Points: ' . $gradeTotal . '</p>';
					}		
				?>	
			 </fieldset>	
			
			 
			 <div class="buttons-left">
			 	<input type="submit" value="Email Selected Grades" id="batch-email-grades" />
			  </div>
			 
			 <div class="buttons-right">
				<input type="submit" class="button select" id="select-all" value="Select All" />
				<input type="submit" class="button select" id="select-none" value="Unselect All" />
			 </div>
			 
			 
			</form>		
			
					
	<?php } else { ?>

			<p>You have no grades yet.</p>
	
		<?php } ?>
		
<div id="delete-prompt">
	<p>Are you sure you want to delete this grade?</p>
	<input type="submit" class="button delete cancel" id="cancel-grade-delete" value="Cancel" />
	<input type="submit" class="button delete" id="confirm-grade-delete" value="Yes, Delete Grade" />
</div>

<form id="grade-assignment" action="grade-assignment.php" method="post">
	<input type="hidden" name="assignment-choice" value="<?php echo $assignmentID; ?>" />
	<input type="submit" name="grade-assignment" value="Grade Assignment" />
</form>
		

	 
<?php require('includes/footer.php'); ?>