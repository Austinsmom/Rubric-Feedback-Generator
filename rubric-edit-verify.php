<?php 
/**
*	Rubric Creator - Verify Form Edit
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

<h1>Rubric Creator - Verify Rubric Edit</h1>

<p>Here is what your rubric will look like post-edit:</p>

<form id="form-output-save" name="form-output-save" action="rubric-edit-save.php" method="post">

	<p>Rubric Title: <?php echo $_POST['form-title']; ?></p>
	<p>Rubric Description: <?php echo $_POST['form-description']; ?></p>
	
	<div id="form-output">
	<?php processCriteria($delimitedTextItems); ?>
	</div>
		
	<input type="hidden" value="<?php echo $delimitedText; ?>" name="finalDelimitedText" />
	<input type="hidden" value="<?php echo $_POST['form-title']; ?>" name="form-title" />
	<input type="hidden" value="<?php echo $_POST['form-description']; ?>" name="form-description" />
		
	<div id="form-save">
		<input type="hidden" name="rubric-id" value="<?php echo $_POST['rubric-id']; ?>" />
		<input class="save button" type="submit" value="save edited rubric" />
	</div>

</form>


<?php require('includes/footer.php'); ?>