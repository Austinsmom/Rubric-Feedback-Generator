<?php 
/**
*	Rubric Creator - User Admin
*	 Admin page
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); ?>

<body id="admin">
	
	<p>Welcome to the admin page, <?php echo $_COOKIE["user"]; ?>!</p>
	
	<?php
		$sql = "SELECT * FROM rubric_form WHERE rubric_author='$username'";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
			
		if ($count != 0) { ?>
			
			<form id="form-rubric-list" name="form-rubric-list" action="rubric-view.php">
			 <fieldset>
				<legend>Select a rubric to complete, or <a href="rubric-create.php">create a new one.</a></legend>
				
				<?php 
					$sql = "SELECT * FROM rubric_form WHERE rubric_author='$username'";
					$result = mysql_query($sql);
					
					while ( $row = mysql_fetch_array($result)) {
					/* go through each rubric record and print a list to choose from */
					$id = $row['rubric_id'];
					$title = $row['rubric_title'];
					$description = $row['rubric_description'];
				
					echo '<input type="radio" name="rubric-choice" id="rubric-'. 
							$id . '" value="' .$id. '"> ' . $title .'<p class="rubric-description">'. $description .'</p>';
					}
				?>
			 </fieldset>	
			
			 <input type="hidden" name="form-origin" value="rubric-list" />
			 <input type="submit" value="submit" />
			</form>		
	<?php } else { ?>
	
			<p>You have no rubrics yet. <a href="rubric-create.php">Create one!</a></p>
	
			<?php } ?>
	
	<p><a href="user-logout.php">Click here to log out.</a></p>

<?php require('includes/footer.php'); ?>