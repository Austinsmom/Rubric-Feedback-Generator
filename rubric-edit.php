<?php 
/**
*	Rubric Creator - Edit Rubric
*	 1. outputs form delimited content
*	 2. allows the user to edit the submitted tab-delimited text and resubmit
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

require('includes/header.php'); 

$rubricChoice = $_POST['rubric-choice'];
$rubricRecords = mysql_query("SELECT * FROM rubric_form WHERE rubric_id='$rubricChoice'");
$rubricCount = mysql_num_rows($rubricRecords);

$assignmentRecords = mysql_query("SELECT * FROM rubric_assignment WHERE assignment_rubric_id='$rubricChoice'");
$assignmentCount = mysql_num_rows($assignmentRecords);

?>

<body id="edit">

<h1>Rubric Creator - Edit Form</h1>

<?php if ($rubricCount != 1) {
	echo 'Error - more than one rubric with this ID? That isn\'t right!';
}
else {

  if ( $assignmentCount > 0 ) {
  	// check if assignments are attributed to this rubric
  	// if there are and they have grades, warn user
  	
  	$warning = '<div class="warning"><h3>WARNING</h3><p>You have assignments using this rubric, which may have grades on record already. If you edit this rubric, you will be changing those grades.</p><ul>';
  
	  	while ( $assignmentRow = mysql_fetch_array($assignmentRecords) ){
	  		$assignmentID = $assignmentRow['assignment_id'];
	  		$assignmentTitle = $assignmentRow['assignment_title'];
	  		
	  		$assignmentText = '<li>' . $assignmentTitle;
	  		
	  		$gradeRecords = mysql_query("SELECT * FROM rubric_grade WHERE grade_assignment_id = '$assignmentID'");
	  		$gradeCount = mysql_num_rows($gradeRecords);
	  		
	  		$assignmentText .= ' [' . $gradeCount . ' grade(s) on record]</li>';
	  		
	  		$warning .= $assignmentText;
		}
	
	$warning .= '</ul></div>';
	echo $warning;
  }
  
  while ( $rubricRow = mysql_fetch_array($rubricRecords)) {
	
	$id = $rubricRow['rubric_id'];
	$title = $rubricRow['rubric_title'];
	$description = $rubricRow['rubric_description'];
	
	} ?>
	
	<form id="form-edit" name="form-edit" action="rubric-edit-save.php" method="post">
	
		<fieldset>
			<p>
				<label for="form-title">Rubric Title:</label>
				<input type="text" name="form-title" value="<?php echo $title; ?>" />
			</p>
			
			<p>
				<label for="form-description">Rubric Description:</label>
				<textarea name="form-description"><?php echo stripSlashes($description); ?></textarea>
			</p>
		</fieldset>
		
		<?php 
		
		$arrayQuery = mysql_query("SELECT criteria_id, criteria_type, criteria_order, criteria_content, criteria_live FROM rubric_criteria WHERE criteria_rubric_id = '$id' AND criteria_live = '1' ORDER BY criteria_order;");
		
		$newCriteriaArray;
		$arrayCount = 0;
		
		while ( $criteriaArray = mysql_fetch_array($arrayQuery)) {
			
				$criteriaID = $criteriaArray[0];
				$criteriaType = $criteriaArray[1];
				$criteriaOrder = $criteriaArray[2];
				$criteriaContent = $criteriaArray[3];
				$criteriaLive = $criteriaArray[4];
			
			if ( $criteriaType == "title" ) {
				echo '<fieldset class="edit title">';
				printEditTitle($criteriaID, $criteriaOrder );
				echo '<div class="button delete">Delete</div>';
				echo '<input type="hidden" name="live-' . $criteriaID . '" class="is-live" value="1" />';
				echo '</fieldset>';
				
			}
			else if ( $criteriaType == "plaintext" ) {
					echo '<fieldset class="edit text">';
					printEditPlaintext($criteriaID, $criteriaOrder );
					echo '<div class="button delete">Delete</div>';
					echo '<input type="hidden" name="live-' . $criteriaID . '" class="is-live" value="1" />';
					echo '</fieldset>';
				}
				else if ($criteriaType == "radio" ) {
						echo '<fieldset class="edit radio">';
						printEditRadio($criteriaID, $criteriaOrder );
						echo '<div class="button delete">Delete</div>';
						echo '<input type="hidden" name="live-' . $criteriaID . '" class="is-live" value="1" />';
						echo '</fieldset>';
					}
					else if ($criteriaType == "textbox" ) {
							echo '<fieldset class="edit textbox">';
							printEditTextbox($criteriaID, $criteriaOrder );
							echo '<div class="button delete">Delete</div>';
							echo '<input type="hidden" name="live-' . $criteriaID . '" class="is-live" value="1" />';
							echo '</fieldset>';
						}
		}
		
		?>
		
		<div id="add-items-panel">
			<div id="add-title" class="button">Add Title</div>
			<div id="add-plaintext" class="button">Add Plaintext</div>
			<div id="add-textbox" class="button">Add Textbox Criteria</div>
			<div id="add-radio" class="button">Add Radio Criteria</div>
		</div>
		
		<input type="hidden" name="rubric-id" value="<?php echo $id; ?>" />
		<input type="submit" value="submit edits" />
	
	</form>

<?php } ?>

<?php require('includes/footer.php'); ?>