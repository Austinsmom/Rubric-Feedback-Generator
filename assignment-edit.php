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
					Assignment Title: <input type="text" name="title" value="<?php echo $title; ?>" /><br />
					Due Date: <input type="text" name="date" value="<?php echo $date; ?>" />
					</p>
					
					<p>Description:<br /><textarea name="description"><?php echo $description; ?></textarea></p>
					
					<input type="hidden" name="id" value="<?php echo $assignmentID; ?>" />
					<input type="submit" value="Submit Changes" />
									
				</form>
	<?php 	}
		}
		else { echo 'Error - No Assignment with this ID!'; } ?>


<?php require('includes/footer.php'); ?>