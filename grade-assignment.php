<?php 
/**
*	Rubric Creator - Grade Assignment
*	 1. Shows the rubric for the assignment to be graded
*	 2. Lets user save form data to a grade database
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

<body id="rubric">

  <?php  
  		// get assignment id
  		$assignmentID = $_POST['assignment-choice'];
  		
  		// get rubric id
		$sql = "SELECT * FROM rubric_assignment WHERE assignment_id='$assignmentID'";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
	
		if ( $count == 0 ) {
			echo 'You have not created any assignments. Go back to admin to create one.';
		}
		else {
			
			while ( $row = mysql_fetch_array($result) ) {
				$assignmentTitle = $row['assignment_title'];
				$rubricID = $row['assignment_rubric_id'];
			}
		}

?>
		
		<h1>Grading Assignment: <em><?php echo $assignmentTitle; ?></em></h1>

		<form id="form-output-fill" name="form-output-fill" action="grade-submit.php" method="post">
			
			<fieldset>
				
				<p>
					<label for="user-email">
						Student's email address: 
						<input type="email" name="student" />
					</label>
				</p>
				
				<input type="hidden" name="rubric-assignment" value="<?php echo $assignmentID; ?>" />
				<input type="hidden" name="rubric-id" value="<?php echo $rubricID; ?>" />
			</fieldset>
			
			<div id="form-output">
			<?php printRubric($rubricID, false); ?>
			</div>
			
			<div id="form-save">
				<input class="save button" type="submit" value="Save Grade" />
			</div>
		
		</form>	

<?php require('includes/footer.php'); ?>