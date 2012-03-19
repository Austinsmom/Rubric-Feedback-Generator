<?php 
/**
*	Rubric Creator - Class Admin
*	 1. Lists classes to edit
*	 2. Lets user select class to view assignments of
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
	
	<h1>Class Admin</h1>
	
	
	<ol>
		<li><a href="class-new.php">create a new class.</a></li>
	</ol>
	
	
	<h2>Your classes</h2>
			
	<?php
		$sqlClass = "SELECT * FROM rubric_class WHERE class_author='$username'";
		$resultClass = mysql_query($sqlClass);
		$count = mysql_num_rows($resultClass);
			
		if ($count != 0) { ?>
			
			<form id="form-classes" name="form-classes" method="post">
			 <fieldset>
				
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
			 <input type="submit" id="edit-class" value="Edit this Class" onclick="choseEdit()" />
			 <input type="submit" id="view-assignments" value="View Assignments for this Class" onclick ="choseViewAssignments()" />
			</form>		
	<?php } else { ?>
	
			<p>You have no classes yet. <a href="class-new.php">Create one!</a></p>
	
			<?php } ?>	 
	 
	<p><a href="user-admin.php">Click here to go back to User Admin.</a></p>
	<p><a href="user-logout.php">Click here to log out.</a></p>

<?php require('includes/footer.php'); ?>