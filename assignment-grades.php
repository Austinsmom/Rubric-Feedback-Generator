<?php 
/**
*	Rubric Creator - Assignment Grades List
*	 1. Lists grades from assignment user submited
*	 2. Lets user select grade to edit or email to students
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php');

$assignmentID = $_POST['assignment-choice'];
$assignmentTitle = $_POST['assignment-title'];

?>

<body id="admin">
	
	<h1>Grades for Assignment:<br /> <?php echo stripSlashes($assignmentTitle); ?></h1>
			
	 <?php
		$sqlGrade = "SELECT * FROM rubric_grade WHERE grade_assignment_id = '$assignmentID'";
		$resultGrade = mysql_query($sqlGrade);
		$count = mysql_num_rows($resultGrade);
			
		if ($count != 0) { ?>
			
			<form id="form-grade" name="form-grade" method="post">
			 <fieldset>
				 <legend>Select a grade to edit (or email - soon!):</legend>

				<?php 
				
					while ( $row = mysql_fetch_array($resultGrade)) {
					/* go through each grade record and print a list to choose from */
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
					
				
					echo '<p><input type="radio" name="grade-choice" id="grade-' . $id . '" value="' .$id. '"> Student: ' . $student . ' | Total Points: ' . $gradeTotal . '</p>';
				}		
				?>
			 </fieldset>	
			
			 <input type="submit" value="edit grade" id="edit-grade" />
			 <input type="submit" value="email grade" id="email-grade" />
			</form>		
	<?php } else { ?>
	
			<p>You have no grades yet.</p>
	
		<?php } ?>
	 
	<p><a href="user-admin.php">Click here to go back to User Admin.</a></p>
	<p><a href="user-logout.php">Click here to log out.</a></p>

<?php require('includes/footer.php'); ?>