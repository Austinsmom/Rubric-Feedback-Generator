<?php 
/**
*	Rubric Creator - Rubric View
*	 1. Shows the rubric in it's form format with email field (and default assignment = 1)
*	 2. Lets user save form data to a grade database
*	 3. Provides links to edit or delete the rubric
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
  		$rubricID = $_POST['rubric-choice'];
		$sql = "SELECT * FROM rubric_form WHERE rubric_id='$rubricID'";
		$result = mysql_query($sql);
	
while ( $row = mysql_fetch_array($result)) {
		$title = stripslashes($row['rubric_title']);

?>
		
		<div id="title-box">
			<h1>Rubric-Feedback Generator</h1>
			<h2>Rubric Completion: <em><?php echo $title; ?></em></h2>
		</div>

		<form id="form-output-fill" name="form-output-fill" action="grade-submit.php" method="post">
			
			<fieldset>
				<p>
				<label for="rubric-assignment">Assignment</label>
				
					<?php 
						$sql = "SELECT * FROM rubric_assignment WHERE assignment_author='$username'";
						$result = mysql_query($sql);
						$count = mysql_num_rows($result);
					
						if ( $count == 0 ) {
							echo '[<strong>You have not created any assignments. <a href="assignment-new.php">Click here to create one</a>.</strong>]';
						}
						
						else {
							echo '<select name="rubric-assignment">';
							
							while ( $row = mysql_fetch_array($result)) {
								/* go through each class record and print a list to choose from */
								$id = $row['assignment_id'];
								$title = stripslashes($row['assignment_title']);
							
								echo '<option value="' . $id . '">' . $title . '</option>';
							}
			
							echo '</select>';
						}
					
					
					?>
				</p>
				
				<p>
					<label for="user-email">
						Student's email address: 
						<input type="email" name="student" />
					</label>
				</p>
				

				<input type="hidden" name="rubric-id" value="<?php echo $rubricID; ?>" />
			</fieldset>
			
			<div id="form-output">
			<?php printRubric($rubricID, false); ?>
			</div>
			
			<div id="form-save">
				<input class="save" type="submit" value="Save Grade" />
			</div>
		
		</form>

	<?php } ?>
	

	

<?php require('includes/footer.php'); ?>