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

$delimitedText = stripslashes($_POST['delimited-text']);
$delimitedTextItems = explode( '
', $delimitedText );

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
	$delimitedText = $row['rubric_content'];
	
	} ?>
	
	<form id="form-delimited" name="form-delimited" action="rubric-edit-verify.php" method="post">
	<label for="delimited-text">Here is what you entered. You can edit the text to resubmit.</label>
	<textarea name="delimited-text"><?php echo $delimitedText; ?></textarea>
	
		<label for="form-title">Rubric Title: <input type="text" name="form-title" value="<?php echo $title; ?>" /></label>
	
	<label for="form-description">Rubric Description:
	<textarea name="form-description"><?php echo $description; ?></textarea></label>

	
	<input type="hidden" name="rubric-id" value="<?php echo $id; ?>" />
	<input type="submit" value="submit edits" />
	
</form>

<?php } ?>

<?php require('includes/footer.php'); ?>