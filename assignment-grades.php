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

$classID = $_POST['class-choice'];

?>

<body id="admin">
	
	<h1>Grades for Assignment: [title of assignment here] </h1>
			
	 	<?php
		$sqlAssignment = "SELECT * FROM rubric_assignment WHERE assignment_class_id='$classID'";
		$resultAssignment = mysql_query($sqlAssignment);
		$count = mysql_num_rows($resultAssignment);
			
		if ($count != 0) { ?>
			
			<form id="form-assignment-list" name="form-assignment-list" action="assignment-edit.php" method="post">
			 <fieldset>
				
				<?php 
				
					while ( $row = mysql_fetch_array($resultAssignment)) {
					/* go through each assignment record and print a list to choose from */
					$id = $row['assignment_id'];
					$title = $row['assignment_title'];
					$description = $row['assignment_description'];
					$dueDate = $row['assignment_duedate'];
					$points = $row['assignment_points'];
				
					echo '<input type="radio" name="assignment-choice" id="assignment-'. 
							$id . '" value="' .$id. '"> ' . $title .' <em>Due ' . $dueDate . '</em>
							<div class="description">'. $description .'</div>
							<p class="totalPoints">Total Points: ' . $points . '</p>';
					}
				?>
			 </fieldset>	
			
			 <input type="submit" name="edit-assignment" onclick="editAssignment();" value="Edit this Assignment" />
			 <input type="submit" name="view-grades" onclick="viewAssignmentGrades();" value="View Grades for this Assignment" />
			 
			</form>		
	<?php } else { ?>
	
			<p>You have no assignments yet. <a href="assignment-new.php">Create one!</a></p>
	
		<?php } ?>
	 
	 
	<p><a href="user-admin.php">Click here to go back to User Admin.</a></p>
	<p><a href="user-logout.php">Click here to log out.</a></p>

<?php require('includes/footer.php'); ?>