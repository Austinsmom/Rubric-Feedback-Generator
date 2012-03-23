<?php 
/**
*	Rubric Creator - Create Assignment
*	1. allows user to create an assignment
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); ?>

<body id="assignment">

<h1>Rubric Creator - Create New Assignment</h1>

<p>In the following form, enter the information about the assignment you'll be completing rubrics for.</p>

<form id="form-assignment" name="form-assignment" action="assignment-save.php" method="post">
	
	<p>
	<label for="assignment-title">Title:</label>
	<input type="text" name="assignment-title" />
	</p>
	
	<p>
	<label for="assignment-description">Description:</label>
	<input type="textarea" name="assignment-description" />
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
	<input type="text" name="assignment-duedate" />
	</p>
		
	<input type="submit" value="create assignment" />
</form>

<?php require('includes/footer.php'); ?>