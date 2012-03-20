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
		// saves rubric title
		$rubricTitle = $value;
		mysql_query("UPDATE rubric_form SET rubric_title = '$rubricTitle' WHERE rubric_id = '$rubricID'");	 	
	}
	else if ( $field == 'form-description' ) {
			// saves rubric description
			$rubricDescription = $value;
			mysql_query("UPDATE rubric_form SET rubric_description = '$rubricDescription' WHERE rubric_id = '$rubricID'");	 	
		}
		else if ( (strpos($field, 'order') !== false) ) {
				// saves criteria order
	 			$rubricCriteriaID = substr($field,6);
	 			mysql_query("UPDATE rubric_criteria SET criteria_order = '$value' WHERE criteria_id = '$rubricCriteriaID'");
			} 
			else if ( (strpos($field, 'content') !== false) ) {
					// saves criteria content
		 			$rubricCriteriaID = substr($field,8);
		 			mysql_query("UPDATE rubric_criteria SET criteria_content = '$value' WHERE criteria_id = '$rubricCriteriaID'");
				} 
				else if ( (strpos($field, 'live') !== false) ) {
						// sets is_live
			 			$rubricCriteriaID = substr($field,5);
			 			mysql_query("UPDATE rubric_criteria SET criteria_live = '$value' WHERE criteria_id = '$rubricCriteriaID'");
					}
					else if ( (strpos($field, 'valueChron') !== false) ) {
							// saves radio value order
				 			$valueID = substr($field,11);
				 			mysql_query("UPDATE rubric_criteria_values SET value_order = '$value' WHERE value_id = '$valueID'");
						} 
						else if ( (strpos($field, 'valueLabel') !== false) ) {
								// saves radio value content
					 			$valueID = substr($field,11);
					 			mysql_query("UPDATE rubric_criteria_values SET value_content = '$value' WHERE value_id = '$valueID'");
							} 
							else if ( (strpos($field, 'valuePoints') !== false) ) {
									// saves radio value points
						 			$valueID = substr($field,12);
						 			mysql_query("UPDATE rubric_criteria_values SET value_points = '$value' WHERE value_id = '$valueID'");
								}
								else if ( (strpos($field, 'valOn') !== false) ) {
										// sets is_live for value
										$valueID = substr($field, 6);
										mysql_query("UPDATE rubric_criteria_values SET value_is_live = '$value' WHERE value_id = '$valueID'");
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