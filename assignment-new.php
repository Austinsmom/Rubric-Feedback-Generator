<?php 
/**
*	Rubric-Feedback Generator - Create Assignment
*	1. allows user to create an assignment
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$classID = $_POST['class-id'];
$classTitle = stripslashes($_POST['class-title']);

?>

<body id="assignment">

	<div id="title-box">
		<h1>Rubric-Feedback Generator</h1>
		<h2>Create New Assignment for class <em><?php echo $classTitle; ?></em></h2>
	</div>

	<p>In the following form, enter the information about the assignment you'll be completing rubrics for.</p>
	
	<form id="form-assignment" name="form-assignment" method="post">
		
		<p>
		<label for="assignment-title">* Title (<em>ex. "Project 1"</em>):</label>
		<input type="text" name="assignment-title" class="text" id="assignment-title" />
		</p>
		
		<p>
		<label for="assignment-description">Description:</label>
		<input type="text" name="assignment-description" class="text" id="assignment-description" />
		</p>
	
		<p>
		<label for="assignment-rubric">* Rubric</label>
			<?php 
				// 
				$rubricRecords = mysql_query("SELECT * FROM rubric_form WHERE rubric_author='$username'");
				$count = mysql_num_rows($rubricRecords);
			
				if ( $count == 0 ) {
					echo '<div id="no-rubrics">[You have not created any rubrics. <a href="rubric-new.php">Click here to create one</a>.]</div>';
				}
				else {
					echo '<select name="assignment-rubric">';
					while ( $rubricRow = mysql_fetch_array($rubricRecords)) {
						/* go through each class record and print a list to choose from */
						$rubricID = $rubricRow['rubric_id'];
						$rubricTitle = stripslashes($rubricRow['rubric_title']);
					
						echo '<option value="' . $rubricID . '">' . $rubricTitle . '</option>';
					}
					echo '</select>';
				}
			
			
			?>
		</p>
		
		<p>
		<label for="assignment-duedate">* Due Date: (YYYY-MM-DD)</label>
		<input type="text" name="assignment-duedate" class="text" id="assignment-duedate" />
		</p>
		
		<input type="hidden" name="assignment-class" value="<?php echo $classID; ?>" />
		<input type="submit" value="Create New Assignment" id="new-assignment" />
	</form>

<?php require('includes/footer.php'); ?>