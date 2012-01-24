<?php 
/**
*	Rubric Creator - Save Form
*	 1. saves the form to database
*	 2. allows the user to select form to start sending
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

require('includes/header.php'); 

$rubricAuthor = "jennschiffer";
$rubricTitle = "My Rubric";
$rubricContent = stripslashes($_POST['finalDelimitedText']);

saveRubricToDatabase($rubricAuthor,$rubricTitle,$rubricContent);

?>

Saved, y'all! Soon there will be a link to continue!


<?php require('includes/footer.php'); ?>