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
$sql = "SELECT * FROM rubric_form WHERE rubric_id='$rubricChoice'";
$result = mysql_query($sql);
$count = mysql_num_rows($result);

?>

<body id="edit">

<h1>Rubric Creator - Edit Form</h1>

<?php if ($count != 1) {
	echo 'Error - more than one rubric with this ID? That isn\'t right!';
	echo $count;
}
else {
  
  while ( $row = mysql_fetch_array($result)) {
	
	$id = $row['rubric_id'];
	$title = $row['rubric_title'];
	$description = $row['rubric_description'];
	
	} ?>
	
	<form id="form-delimited" name="form-delimited" action="rubric-edit-save.php" method="post">
	
		<fieldset>
			<p>
				<label for="form-title">Rubric Title:</label>
				<input type="text" name="form-title" value="<?php echo $title; ?>" />
			</p>
			
			<p>
				<label for="form-description">Rubric Description:</label>
				<textarea name="form-description"><?php echo $description; ?></textarea>
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
	
		
		<input type="hidden" name="rubric-id" value="<?php echo $id; ?>" />
		<input type="submit" value="submit edits" />
	
	</form>

<?php } ?>

<?php require('includes/footer.php'); ?>