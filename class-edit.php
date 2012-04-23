<?php 
/**
*	Rubric-Feedback Generator - Class Edit
*	 1. Lets user edit Class and submit those edits
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

?>

<body id="class-edit">

	<div id="title-box">
		<h1>Rubric-Feedback Generator</h1>
		<h2>Edit Class</h2>
	</div>
	
	<?php  
  		$classID = $_POST['class-choice'];
		$result = mysql_query("SELECT * FROM rubric_class WHERE class_id='$classID'");
		$count = mysql_num_rows($result);

		if ($count != 0) { 
		
			while ( $row = mysql_fetch_array($result)) {
				
				$title = $row['class_title'];
				$meetingTime = $row['class_meetingtime'];
				$notes = $row['class_notes'];
				
		?>
				<form id="form-class-edit" name="form-class-edit" method="post">
					
					<p>
						<label for="class-title">Class Title:</label>
						<input type="text" name="class-title" id="class-title" class="text" value="<?php echo $title; ?>" />
					</p>
					
					<p>
						<label for="class-time">Meeting Time:</label>
						<input type="text" name="class-time" id="class-time" class="text" value="<?php echo $meetingTime; ?>" />
					</p>
					
					<p>
						<label for="class-notes">Notes:</label>
						<textarea name="class-notes" id="class-notes" class="textarea"><?php echo $notes; ?></textarea>
					</p>
					
					<input type="hidden" name="class-id" value="<?php echo $classID; ?>" />
					<input type="submit" id="submit-class-edit" value="Submit Class Edits" />
									
				</form>
	<?php 	}
		}
		else { echo 'Error - No Class with this ID. Contact admin for help.'; } ?>


<?php require('includes/footer.php'); ?>