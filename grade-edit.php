<?php 
/**
*	Rubric Creator - Grade Edit
*	 1. Repopulates Rubric from Grade content field content
*	 2. Allows user to submit to save grade
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

?>

<body id="grade">

	<h1>Grade Edit</h1>
	
	<?php  
  		$gradeID = $_POST['grade-choice'];
		$sql = "SELECT * FROM rubric_grade WHERE grade_id='$gradeID'";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);

		if ($count != 0) { 
		
			while ( $row = mysql_fetch_array($result)) {
				
				$student = $row['grade_student'];
				$assignmentID = $row['grade_assignment_id'];
				$assignmentQuery = mysql_query("SELECT * FROM rubric_assignment WHERE assignment_id = '$assignmentID';");
				
				while ( $assignmentRow = mysql_fetch_array($assignmentQuery)) {
					$assignment = $assignmentRow['assignment_title'];
				}
				
				
				echo '<p>Student: ' . $student . '<br />Assignment: ' . $assignment . '</p>';
		?>
				<form id="form-output-fill" name="form-output-fill" action="grade-edit-submit.php" method="post">
					
					<div id="form-output">
					<?php 
						$rubricID = $row['grade_rubric_id'];
						printRubric($rubricID, $gradeID); 
					?>
					</div>
					
					<div id="form-save">
						<input type="hidden" name="grade-id" value="<?php echo $gradeID; ?>" />
						<input class="save button" type="submit" value="Save Grade" />
					</div>
				
				</form>
	<?php 	}
		}
		else { echo 'Error - No Grade with this ID!'; } ?>


<?php require('includes/footer.php'); ?>