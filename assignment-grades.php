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
		$count = mysql_num_rows($resultGrade);
			
		if ($count != 0) { ?>
			
			<form id="form-grade" name="form-grade" method="post" class="clearfix">
			 <fieldset class="check">
				 <legend>Select a grade to edit or send to student:</legend>

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
						
						echo '<input type="radio" name="grade-choice" id="grade-' . $id . '" value="' .$id. '"> Student: ' . $student . ' &bull; Total Points: ' . $gradeTotal . '<br />';
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
	<?php } else { ?>

			<p>You have no grades yet.</p>
	
		<?php } ?>
		
<div id="delete-prompt">
	Are you sure you want to delete this grade? 
	<input type="submit" class="button delete" id="cancel-grade-delete" value="Cancel" />
	<input type="submit" class="button delete" id="confirm-grade-delete" value="Yes, Delete Grade" />
</div>
	 
<?php require('includes/footer.php'); ?>