<?php 
/**
*	Rubric-Feedback Generator - Grade Assignment
*	 1. Shows the rubric form for the assignment to be graded
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
				$assignmentTitle = stripslashes($row['assignment_title']);
				$rubricID = $row['assignment_rubric_id'];
			}
		}
?>
		
		<div id="title-box">
			<h1>Rubric-Feedback Generator</h1>
			<h2>Grading Assignment: <em><?php echo $assignmentTitle; ?></em></h2>
		</div>

		<form id="form-grade-assignment" name="form-grade-assignment" method="post">
			
			<fieldset class="check">
					<label for="user-email">Student's email address: </label>
					<input type="email" name="student" id="student-email" class="email text" />
				
				<input type="hidden" name="rubric-assignment" value="<?php echo $assignmentID; ?>" />
				<input type="hidden" name="rubric-id" value="<?php echo $rubricID; ?>" />
			</fieldset>
			
			<div id="form-output">
				<?php printRubric($rubricID, false); ?>
			</div>
			
			<div id="form-save">
				<input id="submit-grade" class="save" type="submit" value="Save Grade" />
			</div>
		
		</form>	

<?php require('includes/footer.php'); ?>