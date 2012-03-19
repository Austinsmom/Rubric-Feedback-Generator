<?php 
/**
*	Rubric Creator - Edit Form
*	 1. allows the user to edit existing rubric
*	 2. allows the user to delete existing rubric
*	 3. allows the user to copy content to new rubric
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/
if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$rubricAuthor = $username;
?>

<body>

<h2>Edit Rubrics</h2>
	 
	 	<?php
		$sqlRubric = "SELECT * FROM rubric_form WHERE rubric_author='$username'";
		$resultRubric = mysql_query($sqlRubric);
		$count = mysql_num_rows($resultRubric);
			
		if ($count != 0) { ?>
			
			<form id="form-rubric-edit" name="form-rubric-edit" action="rubric-edit-form.php" method="post">
			 <fieldset>
				<legend>Select a rubric to edit:</legend>
				
				<?php 
				
					while ( $row = mysql_fetch_array($resultRubric)) {
					/* go through each rubric record and print a list to choose from */
					$id = $row['rubric_id'];
					$title = $row['rubric_title'];
					$description = stripslashes($row['rubric_description']);
				
					echo '<input type="radio" name="rubric-choice" id="rubric-'. 
							$id . '" value="' .$id. '"> ' . $title .'<div class="description">'. $description .'</div>';
					}
				?>
			 </fieldset>	
			
			 <input type="hidden" name="form-origin" value="rubric-edit" />
			 <input type="submit" value="edit rubric" />
			</form>		
	<?php } else { ?>
	
			<p>You have no rubrics yet. <a href="rubric-new.php">Create one!</a></p>
	
		<?php } ?>


<?php require('includes/footer.php'); ?>