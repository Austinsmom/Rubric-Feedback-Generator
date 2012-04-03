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
		

	<h2>Your classes</h2>
			
	<ul>
		<li><a href="class-new.php">create a new class</a></li>
	</ul>
	
	<?php
		$sqlClass = "SELECT * FROM rubric_class WHERE class_author='$username'";
		$resultClass = mysql_query($sqlClass);
		$count = mysql_num_rows($resultClass);
			
		if ($count != 0) { ?>
			
			<form id="form-classes" name="form-classes" method="post">
			 <fieldset>
			 	<legend>Select a class to complete or view assignments:</legend>
				
				<?php 
					while ( $row = mysql_fetch_array($resultClass)) {
					/* go through each rubric record and print a list to choose from */
					$id = $row['class_id'];
					$title = $row['class_title'];
					$meeting = $row['class_meetingtime'];
					$notes = $row['class_notes'];
				
					echo '<input type="radio" name="class-choice" id="class-'. 
							$id . '" value="' .$id. '"> ' . $title .' <em>' . $meeting . '</em> <div class="description">'. $notes .'</div>';
					}
				?>
			 </fieldset>	
			
			 <input type="hidden" name="class-title" value="<?php echo $title; ?>" />
			 <input type="submit" id="view-assignments" value="View Assignments for this Class" onclick ="choseViewAssignments()" />
			 <input type="submit" id="edit-class" value="Edit this Class" onclick="choseEdit()" />
			</form>		
	<?php } else { /* no classes, do nothing */} ?>		 
	 
	 
	 <h2>Your rubrics</h2>
	 
	 <ul>
		<li><a href="rubric-new.php">create a new rubric</a></li>
	</ul>
	 
	 <?php
		$sqlRubric = "SELECT * FROM rubric_form WHERE rubric_author='$username'";
		$resultRubric = mysql_query($sqlRubric);
		$count = mysql_num_rows($resultRubric);
			
		if ($count != 0) { ?>
			
			<form id="form-rubric" name="form-rubric" method="post">
			 <fieldset>
				<legend>Select a rubric to complete or edit:</legend>
				
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
			
			 <input type="submit" value="Edit this Rubric" id="edit-rubric" />
			</form>		
	<?php } else { /* no rubrics, do nothing */ } ?>
		
<?php require('includes/footer.php'); ?>