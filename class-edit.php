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

?>

<body id="class-edit">

	<h1>Edit Class</h1>
	
	<?php  
  		$classID = $_POST['class-choice'];
		$sql = "SELECT * FROM rubric_class WHERE class_id='$classID'";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);

		if ($count != 0) { 
		
			while ( $row = mysql_fetch_array($result)) {
				
				$title = $row['class_title'];
				$meetingTime = $row['class_meetingtime'];
				$notes = $row['class_notes'];
				
		?>
				<form id="form-class-edit" name="form-class-edit" action="class-edit-submit.php" method="post">
					
					<p>
					Class Title: <input type="text" name="title" value="<?php echo $title; ?>" /><br />
					Meeting Time: <input type="text" name="time" value="<?php echo $meetingTime; ?>" />
					</p>
					
					<p>Notes:<br /><textarea name="notes"><?php echo $notes; ?></textarea></p>
					
					<input type="hidden" name="id" value="<?php echo $classID; ?>" />
					<input type="submit" value="Submit Changes" />
									
				</form>
	<?php 	}
		}
		else { echo 'Error - No Class with this ID!'; } ?>


<?php require('includes/footer.php'); ?>