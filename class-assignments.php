<?php 
/**
*	Rubric Creator - Class Assignments List
*	 1. Lists assignments from class user submited
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
$classTitle = $_POST['class-title'];
	
?>

<body id="class-assignments">
	
	<h1>Assignments for Class: <?php echo $classTitle; ?></h1>
	
	<form id="create-new-assignment" action="assignment-new.php" method="post">
		<input type="hidden" name="class-id" value="<?php echo $classID; ?>" />
		<input type="hidden" name="class-title" value="<?php echo $classTitle; ?>" />
		<input type="submit" name="create-new-assignment" value="Create New Assignment" />
	</form>
		
	 <?php
		$resultAssignment = mysql_query("SELECT * FROM rubric_assignment WHERE assignment_class_id='$classID'");
		$count = mysql_num_rows($resultAssignment);
			
		if ($count != 0) { ?>
			
			<form id="form-assignment" name="form-assignment" method="post">
			 <fieldset>
				 <legend>Select an assignment to edit, grade, or view its grades:</legend>

				<?php 
					while ( $row = mysql_fetch_array($resultAssignment)) {
					
					/* go through each assignment record and print a list to choose from */
					$id = $row['assignment_id'];
					$title = $row['assignment_title'];
					$description = $row['assignment_description'];
					$dueDate = $row['assignment_duedate'];
				
					echo '<input type="radio" name="assignment-choice" id="assignment-'. 
							$id . '" value="' . $id . '"> ' . $title .' <em>Due ' . $dueDate . '</em>
							<div class="description">'. $description .'</div>';
					}
				?>
			 </fieldset>	
			
			 <input type="hidden" name="assignment-title" value="<?php echo $title; ?>" />
			 <input type="hidden" name="class-title" value="<?php echo $classTitle; ?>" />
			 
			 <input type="submit" id="grade-assignment" value="Grade this Assignment" />
			 <input type="submit" id="view-grades" value="View Grades for this Assignment" />
			 <input type="submit" id="edit-assignment" value="Edit this Assignment" />
			  
			</form>		
	<?php } else { /* no assignments, do nothing */ } ?>

<?php require('includes/footer.php'); ?>