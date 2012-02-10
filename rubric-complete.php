<?php 
/**
*	Rubric Creator - Rubric View
*	 1. Shows the rubric in it's form format with email field (and default assignment = 1)
*	 2. Lets user save form data to a grade database
*	 3. Provides links to edit or delete the rubric
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

<body id="rubric">

  <?php  
  		$rubricID = $_POST['rubric-choice'];
		$sql = "SELECT * FROM rubric_form WHERE rubric_id='$rubricID'";
		$result = mysql_query($sql);
	
while ( $row = mysql_fetch_array($result)) {
		$title = $row['rubric_title'];
		$content = $row['rubric_content'];
		$delimitedTextItems = explode( '
', $content );

?>
		
		<h1>Rubric Completion: <em><?php echo $title; ?></em></h1>

		<form id="form-output-fill" name="form-output-fill" action="grade-submit.php" method="post">
			
			<fieldset>
				<label for="user-email">
					Student's email address: 
					<input type="text" name="student" />
				</label>
				<input type="hidden" name="rubric-id" value="<?php echo $rubricID; ?>" />
			</fieldset>
			
			<div id="form-output">
			<?php processCriteria($delimitedTextItems); ?>
			</div>
			
			<div id="form-save">
				<input class="save button" type="submit" value="view results before saving to database" />
			</div>
		
		</form>

	<?php } ?>
	

	

<?php require('includes/footer.php'); ?>