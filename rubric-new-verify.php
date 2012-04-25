<?php 
/**
*	Rubric Creator - Verify Form Import
*	 1. outputs the form generated from the submitted tab-delimited text
*	 2. allows the user to edit the submitted tab-delimited text and resubmit
*	 3. allows the user to verify the rubric generated before moving onto the next step
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

require('includes/header.php'); 

$delimitedText = stripslashes($_POST['delimited-text']);
$delimitedTextItems = explode( '
', $delimitedText );

?>

<body id="process">

	<div id="title-box">
		<h1>Rubric-Feedback Generator</h1>
		<h2>Rubric Creator - Verify Form Import</h2>
	</div>

	<form id="form-delimited" name="form-delimited" action="rubric-new-verify.php" method="post">
		<label for="delimited-text">Here is what you entered. You can edit the text to resubmit.</label>
		<textarea name="delimited-text"><?php echo $delimitedText; ?></textarea>
		<input type="submit" value="submit edits" />
	</form>
	
	<p>Here is the form generated by your work:</p>
	
	<form id="form-output-save" name="form-output-save" action="rubric-new-save.php" method="post">
		
		<div id="form-output">
		<?php processCriteria($delimitedTextItems); ?>
		</div>
		
		<p>Once you've finished generating your form, save it!</p>
		
		<input type="hidden" value="<?php echo $delimitedText; ?>" name="finalDelimitedText" />
		
		<label for="form-title">Rubric Title: <input type="text" name="form-title" /></label>
		
		<label for="form-description">Rubric Description:
		<textarea name="form-description"></textarea></label>
		
		<div id="form-save">
			<input class="save" type="submit" value="save to database" />
		</div>
	
	</form>

<?php require('includes/footer.php'); ?>