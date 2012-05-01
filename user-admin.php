<?php 
/**
*	Rubric-Feedback Generator - User Admin
*	 Admin page
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); ?>

<body id="admin">
	
	<div id="title-box">
		<h1>Rubric-Feedback Generator</h1>
		<h2>User Admin: <em>Welcome, <?php echo $_COOKIE["user"]; ?>!</em></h2>
	</div>

	<h3>Your classes</h3>
			
	<ul>
		<li><a href="class-new.php">create a new class</a></li>
	</ul>
	
	<?php
		$resultClass = mysql_query("SELECT * FROM rubric_class WHERE class_author='$username'");
		$count = mysql_num_rows($resultClass);
			
		if ($count != 0) { ?>
			
			<form id="form-class" name="form-class" method="post" class="clearfix">
			 <fieldset class="check">
			 	<legend>Select a class to edit or view assignments:</legend>
				
				<?php 
					while ( $row = mysql_fetch_array($resultClass)) {
					$id = $row['class_id'];
					$title = $row['class_title'];
					$meeting = $row['class_meetingtime'];
					$notes = $row['class_notes'];
				
					echo '<p><input type="radio" name="class-choice" id="class-'. 
							$id . '" value="' .$id. '"> ' . $title .' <em>' . $meeting . '</em> <div class="description">'. $notes .'</div></p>';
					}
				?>
			 </fieldset>	
			 
			 <input type="hidden" name="class-title" value="<?php echo $title; ?>" />
			
			 <div class="buttons-left">
			 	<input type="submit" id="view-assignments" value="View Assignments" onclick ="choseViewAssignments()" />
			 </div>
			 
			 <div class="buttons-right">
				<input type="submit" id="edit-class" value="Edit Class" /><br />
				<input type="submit" id="delete-class" value="Delete Class" />
			 </div>
			 
			</form>		
	<?php } else { /* no classes, do nothing */} ?>		
	
	<div id="delete-prompt" class="class">
		<p>Are you sure you want to delete this class? </p>
		<input type="submit" class="button delete cancel" id="cancel-class-delete" value="Cancel" />
		<input type="submit" class="button delete" id="confirm-class-delete" value="Yes, Delete Class" />
	</div> 
	 
	 
	 <h3>Your rubrics</h3>
	 
	 <ul>
		<li><a href="rubric-new.php">create a new rubric</a></li>
	</ul>
	 
	 <?php
		$resultRubric = mysql_query("SELECT * FROM rubric_form WHERE rubric_author='$username'");
		$count = mysql_num_rows($resultRubric);
			
		if ($count != 0) { ?>
			
			<form id="form-rubric" name="form-rubric" method="post" class="clearfix">
			 <fieldset class="check">
				<legend>Select a rubric to complete or edit:</legend>
				
				<?php 
				
					while ( $row = mysql_fetch_array($resultRubric)) {
					/* go through each rubric record and print a list to choose from */
					$id = $row['rubric_id'];
					$title = $row['rubric_title'];
					$description = stripslashes($row['rubric_description']);
				
					echo '<p><input type="radio" name="rubric-choice" id="rubric-'. 
							$id . '" value="' .$id. '"> ' . $title .'<div class="description">'. $description .'</div></p>';
					}
				?>
			 </fieldset>	
			
			 <div class="buttons-left">
			 </div>
			 
			 <div class="buttons-right">
				<input type="submit" value="Edit Rubric" id="edit-rubric" /><br />
				<input type="submit" value="Delete Rubric" id="delete-rubric" />
			 </div>
			 
			</form>		
			
	<?php } else { /* no rubrics, do nothing */ } ?>
	
	<div id="delete-prompt" class="rubric">
		<p>Are you sure you want to delete this rubric? </p>
		<input type="submit" class="button delete cancel" id="cancel-rubric-delete" value="Cancel" />
		<input type="submit" class="button delete" id="confirm-rubric-delete" value="Yes, Delete Rubric" />
	</div> 
	
	<h3>Your User Information</h3>
			
	<ul>
		<li><a href="user-edit.php">update your user information</a></li>
	</ul>
		
<?php require('includes/footer.php'); ?>