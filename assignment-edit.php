<?php 
/**
*	Rubric Creator - Class Edit
*	 1. Lets user edit Class and submit those edits
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$assignmentTitle = $_POST['assignment-title'];
$classTitle = $_POST['class-title'];

?>
		
<body id="class-edit">

	<h1>Edit Assignment:<br />
	<?php echo stripSlashes($assignmentTitle) . ' <em>for ' . stripSlashes($classTitle) . '</em>'; ?></h1>
	
	<?php  
		$assignmentID = $_POST['assignment-choice'];
		$sql = "SELECT * FROM rubric_assignment WHERE assignment_id='$assignmentID'";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);

		if ($count != 0) { 
		
			while ( $row = mysql_fetch_array($result)) {
				
				$title = $row['assignment_title'];
				$description = $row['assignment_description'];
				$date = $row['assignment_duedate'];
				
		?>
				<form id="form-assignment-edit" name="form-assignment-edit" action="assignment-edit-submit.php" method="post">
					
					<p>
					<label for="assignment-title">Title:</label>
					<input type="text" name="assignment-title" value="<?php echo $title; ?>" />
					</p>
					
					<p>
					<label for="assignment-description">Description:</label>
					<input type="textarea" name="assignment-description" value="<?php echo $description; ?>" />
					</p>
					
					<p>
					<label for="assignment-class">Class</label>
					
						<?php 
							$sql = "SELECT * FROM rubric_class WHERE class_author='$username'";
							$result = mysql_query($sql);
							$count = mysql_num_rows($result);
						
							if ( $count == 0 ) {
								echo '[<strong>You have not created any classes. <a href="class-new.php">Click here to create one</a>.</strong>]';
							}
							
							else {
								echo '<select name="assignment-class">';
								
								while ( $row = mysql_fetch_array($result)) {
									/* go through each class record and print a list to choose from */
									$id = $row['class_id'];
									$title = $row['class_title'];
								
									echo '<option value="' . $id . '">' . $title . '</option>';
								}
				
								echo '</select>';
							}
						
						
						?>
					</p>
				
					<p>
					<label for="assignment-rubric">Rubric</label>
					
						<?php 
							$sql = "SELECT * FROM rubric_form WHERE rubric_author='$username'";
							$result = mysql_query($sql);
							$count = mysql_num_rows($result);
						
							if ( $count == 0 ) {
								echo '[<strong>You have not created any rubrics. <a href="rubric-new.php">Click here to create one</a>.</strong>]';
							}
							
							else {
								echo '<select name="assignment-rubric">';
								
								while ( $row = mysql_fetch_array($result)) {
									/* go through each class record and print a list to choose from */
									$id = $row['rubric_id'];
									$title = $row['rubric_title'];
								
									echo '<option value="' . $id . '">' . $title . '</option>';
								}
				
								echo '</select>';
							}
						
						
						?>
					</p>
					
					<p>
					<label for="assignment-duedate">Due Date:</label>
					<input type="text" name="assignment-duedate" value="<?php echo $date; ?>" />
					</p>

					<input type="hidden" name="assignment-id" value="<?php echo $assignmentID; ?>" />
					<input type="submit" value="Edit Assignment" />
									
				</form>
	<?php 	}
		}
		else { echo 'Error - No Assignment with this ID!'; } ?>


<?php require('includes/footer.php'); ?>