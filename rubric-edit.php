<?php 
/**
*	Rubric-Feedback Generator - Edit Rubric
*	 1. outputs rubric to allow editing by user
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

// get info of rubric to be edited
$rubricChoice = $_POST['rubric-choice'];
$rubricRecords = mysql_query("SELECT * FROM rubric_form WHERE rubric_id='$rubricChoice'");
$rubricCount = mysql_num_rows($rubricRecords);

// get assignments attributed to this rubric
$assignmentRecords = mysql_query("SELECT * FROM rubric_assignment WHERE assignment_rubric_id='$rubricChoice'");
$assignmentCount = mysql_num_rows($assignmentRecords);

?>

<body id="edit">

	<div id="title-box">
		<h1>Rubric-Feedback Generator</h1>
		<h2>Edit Rubric</h2>
	</div>

<?php if ($rubricCount != 1) {
	echo 'Error - more than one rubric with this ID? That isn\'t right!';
}
else {

  if ( $assignmentCount > 0 ) {
  	// if assignments are attributed to this rubric, warn user that grades will change
  	$warning = '<div class="warning"><h3>WARNING</h3><p>You have assignments using this rubric, which may have grades on record already. If you edit this rubric, you will be changing those grades.</p><ul>';
	  	while ( $assignmentRow = mysql_fetch_array($assignmentRecords) ){
	  		$assignmentID = $assignmentRow['assignment_id'];
	  		$assignmentTitle = stripslashes($assignmentRow['assignment_title']);
	  		$assignmentText = '<li>' . $assignmentTitle;
	  		
	  		$gradeRecords = mysql_query("SELECT * FROM rubric_grade WHERE grade_assignment_id = '$assignmentID'");
	  		$gradeCount = mysql_num_rows($gradeRecords);
	  		
	  		$assignmentText .= ' &bull; ' . $gradeCount . ' grade(s) on record</li>';
	  		$warning .= $assignmentText;
		}
	$warning .= '</ul></div>';
	echo $warning;
  }
  
  while ( $rubricRow = mysql_fetch_array($rubricRecords)) {
	
	$id = $rubricRow['rubric_id'];
	$title = stripslashes($rubricRow['rubric_title']);
	$description = stripslashes($rubricRow['rubric_description']);
	
	} ?>
	
	<form id="form-edit" name="form-edit" action="rubric-edit-save.php" method="post">
	
		<fieldset>
			<p>
				<label for="form-title">Rubric Title:</label>
				<input id="rubric-title" type="text" name="form-title" value="<?php echo htmlspecialchars($title); ?>" />
			</p>
			
			<p>
				<label for="form-description">Rubric Description:</label>
				<textarea id="rubric-description" name="form-description"><?php echo $description; ?></textarea>
			</p>
			
		</fieldset>
		
		<?php 
		
		$arrayQuery = mysql_query("SELECT criteria_id, criteria_type, criteria_order, criteria_content, criteria_is_live FROM rubric_criteria WHERE criteria_rubric_id = '$id' AND criteria_is_live = '1' ORDER BY criteria_order;");
		
		$newCriteriaArray;
		$arrayCount = 0;
		
		while ( $criteriaArray = mysql_fetch_array($arrayQuery)) {
			
				$criteriaID = $criteriaArray[0];
				$criteriaType = $criteriaArray[1];
				$criteriaOrder = $criteriaArray[2];
				$criteriaContent = stripslashes($criteriaArray[3]);
				$criteriaLive = $criteriaArray[4];
			
			if ( $criteriaType == "title" ) {
				echo '<fieldset class="edit title" id="existing-'. $criteriaID .'">';
				printEditTitle($criteriaID, $criteriaOrder );
				echo '<input type="submit" class="button delete" value="Delete" />';
				echo '<input type="hidden" name="live-' . $criteriaID . '" class="is-live" value="1" />';
				echo '</fieldset>';
				
			}
			else if ( $criteriaType == "plaintext" ) {
					echo '<fieldset class="edit text" id="existing-'. $criteriaID .'">';
					printEditPlaintext($criteriaID, $criteriaOrder );
					echo '<input type="submit" class="button delete" value="Delete" />';
					echo '<input type="hidden" name="live-' . $criteriaID . '" class="is-live" value="1" />';
					echo '</fieldset>';
				}
				else if ($criteriaType == "radio" ) {
						echo '<fieldset class="edit radio" id="existing-'. $criteriaID .'">';
						printEditRadio($criteriaID, $criteriaOrder );
						echo '<input type="submit" class="button delete" value="Delete" />';
						echo '<input type="hidden" name="live-' . $criteriaID . '" class="is-live" value="1" />';
						echo '</fieldset>';
					}
					else if ($criteriaType == "textbox" ) {
							echo '<fieldset class="edit textbox" id="existing-'. $criteriaID .'">';
							printEditTextbox($criteriaID, $criteriaOrder );
							echo '<input type="submit" class="button delete" value="Delete" />';
							echo '<input type="hidden" name="live-' . $criteriaID . '" class="is-live" value="1" />';
							echo '</fieldset>';
						}
		}
		
		?>
		
		<div id="add-items-panel">
			<input type="submit" id="add-title" class="button add" value="Add Title" />
			<input type="submit" id="add-plaintext" class="button add" value="Add Plaintext" /><br />
			<input type="submit" id="add-textbox" class="button add" value="Add Textbox Criteria" />
			<input type="submit" id="add-radio" class="button add" value="Add Radio Criteria" />
		</div>

		
		<input type="hidden" name="rubric-id" value="<?php echo $id; ?>" />
		<input id="submit-form-edit" type="submit" value="Submit Rubric Edits" />
	
	</form>

<?php } ?>

<?php require('includes/footer.php'); ?>