<?php 
/**
*	Rubric Creator - Class Assignments List
*	 1. Lists assignments from class user submited
*	 2. Lets user select assignment to view the grades of
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

<body id="admin">
	
	<h1>Assignments for Class: <?php echo $classTitle; ?></h1>
	
	<ol>	
		<li><a href="assignment-new.php">Create a new assignment.</a></li>
	</ol>
		
	 	<?php
		$sqlAssignment = "SELECT * FROM rubric_assignment WHERE assignment_class_id='$classID'";
		$resultAssignment = mysql_query($sqlAssignment);
		$count = mysql_num_rows($resultAssignment);
			
		if ($count != 0) { ?>
			
			<form id="form-assignment" name="form-assignment" method="post">
			 <fieldset>
				 <legend>Select an assignment to edit or view grades:</legend>

				
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
			 <input type="submit" id="edit-assignment" value="Edit this Assignment" />
			 <input type="submit" id="view-grades" value="View Grades for this Assignment" />
			  
			</form>		
	<?php } else { ?>
	
			<p>You have no assignments yet. <a href="assignment-new.php">Create one!</a></p>
	
		<?php } ?>
	 
	<p><a href="user-admin.php">Click here to go back to User Admin.</a></p>
	<p><a href="user-logout.php">Click here to log out.</a></p>

<?php require('includes/footer.php'); ?>