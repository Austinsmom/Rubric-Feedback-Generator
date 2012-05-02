<?php 
/**
*	Rubric-Feedback Generator - Class Assignments List
*	 1. Lists assignments from class user submited
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php');

$classID = $_POST['class-choice'];
$classTitle = stripslashes($_POST['class-title']);
	
?>

<body id="class-assignments">
	
	<div id="title-box">
		<h1>Rubric-Feedback Generator</h1>
		<h2>Assignments for Class: <?php echo $classTitle; ?></h2>
	</div>

	 <?php
		$resultAssignment = mysql_query("SELECT * FROM rubric_assignment WHERE assignment_class_id='$classID'");
		$count = mysql_num_rows($resultAssignment);
			
		if ($count != 0) { ?>
			
			<form id="form-assignment" name="form-assignment" method="post" class="clearfix">
			 <fieldset class="check">
				 <legend>Select an assignment to edit, grade, or view its grades:</legend>

				<?php 
					while ( $row = mysql_fetch_array($resultAssignment)) {
					
					/* go through each assignment record and print a list to choose from */
					$id = $row['assignment_id'];
					$title = stripslashes($row['assignment_title']);
					$description = stripslashes($row['assignment_description']);
					$dueDate = $row['assignment_duedate'];
				
					echo '<input type="radio" name="assignment-choice" id="assignment-'. 
							$id . '" value="' . $id . '"> ' . $title .' <em>Due: ' . date('l F d, Y', strtotime($dueDate)) . '</em>
							<div class="description">'. $description .'</div>';
					}
				?>
			 </fieldset>	
			
			 <input type="hidden" name="assignment-title" value="<?php echo addslashes($title); ?>" />
			 <input type="hidden" name="class-title" value="<?php echo addslashes($classTitle); ?>" />
			 
			 <div class="buttons-left">
			 	<input type="submit" id="grade-assignment" value="Grade Assignment" /><br />
			 	<input type="submit" id="view-grades" value="View Grades" />
			 </div>
			 
			 <div class="buttons-right">
				<input type="submit" id="edit-assignment" value="Edit Assignment" /><br />
			 	<input type="submit" id="delete-assignment" value="Delete Assignment" />
			 </div>
			  
			</form>		
	<?php } else { /* no assignments, do nothing */ } ?>
	
<div id="delete-prompt">
	<p>Are you sure you want to delete this grade? </p>
	<input type="submit" class="button delete cancel" id="cancel-assignment-delete" value="Cancel" />
	<input type="submit" class="button delete" id="confirm-assignment-delete" value="Yes, Delete Assignment" />
</div>

	
<form id="create-new-assignment" action="assignment-new.php" method="post">
	<input type="hidden" name="class-id" value="<?php echo $classID; ?>" />
	<input type="hidden" name="class-title" value="<?php echo addslashes($classTitle); ?>" />
	<input type="submit" name="create-new-assignment" value="Create New Assignment" />
</form>
		

<?php require('includes/footer.php'); ?>