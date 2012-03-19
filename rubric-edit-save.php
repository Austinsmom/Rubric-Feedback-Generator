<?php 
/**
*	Rubric Creator - Save Rubric Edits
*	 1. saves the rubric edit to database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/
if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$rubricID = $_POST['rubric-id'];

$postArray = $_POST;

while( list( $field, $value ) = each( $postArray )) {
	if ( $field == 'form-title' ) {
		$rubricTitle = $value;
		mysql_query("UPDATE rubric_form SET rubric_title = '$rubricTitle' WHERE rubric_id = '$rubricID'");	 	
	}
	else if ( $field == 'form-description' ) {
			$rubricDescription = $value;
			mysql_query("UPDATE rubric_form SET rubric_description = '$rubricDescription' WHERE rubric_id = '$rubricID'");	 	
		}
		else if ( (strpos($field, 'order') !== false) ) {
	 			$rubricCriteriaID = substr($field,6);
	 			mysql_query("UPDATE rubric_criteria SET criteria_order = '$value' WHERE criteria_id = '$rubricCriteriaID'");
			} 
			else if ( (strpos($field, 'content') !== false) ) {
		 			$rubricCriteriaID = substr($field,8);
		 			mysql_query("UPDATE rubric_criteria SET criteria_content = '$value' WHERE criteria_id = '$rubricCriteriaID'");
				} 
				else if ( (strpos($field, 'live') !== false) ) {
			 			$rubricCriteriaID = substr($field,5);
			 			mysql_query("UPDATE rubric_criteria SET criteria_live = '$value' WHERE criteria_id = '$rubricCriteriaID'");
					} 		
}
		
/* if there is no rubric title, set default title */
if ($rubricTitle == null) {
	$rubricTitle = "Untitled Rubric";
}

?>

<body id="save">

Your rubric was saved. <a href="user-admin.php">Go to admin to view it.</a>


<?php require('includes/footer.php'); ?>