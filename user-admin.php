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
	
	<h1>User Admin: <em>Welcome, <?php echo $_COOKIE["user"]; ?>!</em></h1>
	
	<?php
		$sql = "SELECT * FROM rubric_form WHERE rubric_author='$username'";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
			
		if ($count != 0) { ?>
			
			<form id="form-rubric-list" name="form-rubric-list" action="rubric-complete.php" method="post">
			 <fieldset>
				<legend>Select a rubric to complete, or <a href="rubric-new.php">create a new one.</a></legend>
				
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
	
			<p>You have no rubrics yet. <a href="rubric-new.php">Create one!</a></p>
	
			<?php } ?>
			
			
	<?php
		$sql = "SELECT * FROM rubric_grade";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);
			
		if ($count != 0) { 
		
		echo '<h3>Here are your saved grade records:</h3>';
		
			while ( $row = mysql_fetch_array($result)) {
			
			echo '<div class="grade">';
			
			/* go through each grade record and print them */
			$student = $row['grade_student'];
			$assignment = $row['grade_assignment'];
			$content = htmlspecialchars($row['grade_content']);
			$points = $row['grade_points'];
			
			echo '<h5>',$student,'</h5><em>',$assignment,'</em><div class="grade-content">',$content,'</div><p><strong>Points:</strong> ',$points,'</p>';
			
			echo '</div>';
			}
	 } ?>

	
	<p><a href="user-logout.php">Click here to log out.</a></p>

<?php require('includes/footer.php'); ?>