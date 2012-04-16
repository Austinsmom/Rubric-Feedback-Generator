<?php 
/**
*	Rubric Creator - Save New Rubric
*	 1. saves the new rubric to database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

$createArray = $_POST;
$postArray = $_POST;
$checkArray = $_POST;
$count = 0;

while( list( $field, $value ) = each ($createArray)) {
	
	// save new rubric first
	if ( $field == 'form-title' ) {
		// get rubric title
		$rubricTitle = $value;	 	
	}
	else if ( $field == 'form-description' ) {
			// get rubric description
			$rubricDescription = $value;
		 }
}

// save rubric to database and get new id	
saveRubricToDatabase($username, $rubricTitle, $rubricDescription, "");
$rubricID = $latestRubric = mysql_insert_id();

// go through again and get new content
while( list( $field, $value ) = each( $postArray )) {
	
	if ( strpos($field, 'new') !== false ) {
	
		// new criteria items to be saved
		if ( strpos($field, 'title') !== false ) {
			// saves new rubric title
			$type = "title";
			$content = $value;
			$tempID = substr($field,10);
			
			//go through array again and search for fields new-order-tempID & new-live-tempID
			$checkArrayTitle = $checkArray;
			while ( list( $checkField, $checkValue ) = each ($checkArrayTitle)) {
				
				$orderField = "new-order-" . $tempID;
				$liveField = "new-live-" . $tempID;
				
				if ( $checkField == $orderField ){
					$order = $checkValue;
				}
				else if ( $checkField == $liveField ){
						$isLive = $checkValue;
				}
			}
			
			// add this new title to the database if isLive = 1
			if ($isLive == 1) {
				mysql_query("INSERT INTO rubric_criteria (criteria_rubric_id, criteria_type, criteria_order, criteria_content, criteria_live) VALUES ('$rubricID', '$type', '$order', '$content', '$isLive')") or die('There was an error saving: ' . mysql_error());
			}
		}
		else if ( strpos($field, 'plaintext') !== false ) {
				// saves new rubric plaintext
				$type = "plaintext";
				$content = $value;
				$tempID = substr($field,14);
				
				//go through array again and search for fields new-order-tempID & new-live-tempID
				$checkArrayPlaintext = $checkArray;
				while ( list( $checkField, $checkValue ) = each ($checkArrayPlaintext)) {
					
					$orderField = "new-order-" . $tempID;
					$liveField = "new-live-" . $tempID;
					
					if ( $checkField == $orderField ){
						$order = $checkValue;
					}
					else if ( $checkField == $liveField ){
							$isLive = $checkValue;
					}
				}
				
				// add this new plaintext to the database if isLive = 1
				if ($isLive == 1) {
					mysql_query("INSERT INTO rubric_criteria (criteria_rubric_id, criteria_type, criteria_order, criteria_content, criteria_live) VALUES ('$rubricID', '$type', '$order', '$content', '$isLive')") or die('There was an error saving: ' . mysql_error());
				}
			}
			else if ( strpos($field, 'textbox') !== false ) {
					// saves new rubric textbox
					$type = "textbox";
					$content = $value;
					$tempID = substr($field,12);
					
					//go through array again and search for fields new-order-tempID & new-live-tempID
					$checkArrayTextbox = $checkArray;
					while ( list( $checkField, $checkValue ) = each ($checkArrayTextbox)) {
						
						$orderField = "new-order-" . $tempID;
						$liveField = "new-live-" . $tempID;
						
						if ( $checkField == $orderField ){
							$order = $checkValue;
						}
						else if ( $checkField == $liveField ){
								$isLive = $checkValue;
						}
					}
					
					// add this new textbox to the database if isLive = 1
					if ($isLive == 1) {
						mysql_query("INSERT INTO rubric_criteria (criteria_rubric_id, criteria_type, criteria_order, criteria_content, criteria_live) VALUES ('$rubricID', '$type', '$order', '$content', '$isLive')") or die('There was an error saving: ' . mysql_error());
					}
				}
				else if ( strpos($field, 'radio') !== false ) {
						// saves new rubric radio
						$type = "radio";
						$radioContent = $value;
						$tempID = substr($field,10);
						
						//go through array again and search for fields new-order-tempID & new-live-tempID
						$checkArrayRadio = $checkArray;
						while ( list( $checkField, $checkValue ) = each ($checkArrayRadio)) {
							
							$orderField = "new-order-" . $tempID;
							$liveField = "new-live-" . $tempID;
							
							if ( $checkField == $orderField ){
								$order = $checkValue;
							}
							else if ( $checkField == $liveField ){
									$isLive = $checkValue;
							}
						}
						
						// add this new radio to the database if isLive = 1
						if ($isLive == 1) {
							mysql_query("INSERT INTO rubric_criteria (criteria_rubric_id, criteria_type, criteria_order, criteria_content, criteria_live) VALUES ('$rubricID', '$type', '$order', '$radioContent', '$isLive')") or die('There was an error saving: ' . mysql_error()); 
										
							// get latest radio id
							$radioID = mysql_insert_id();
							
							//go through array again and search for field new-$tempID-valueLabel-#
							$checkArrayValues = $checkArray;
							while ( list( $checkOptionField, $checkOptionValue ) = each ($checkArrayValues)) {
								
								$contentField = "new-" . $tempID . "-valueLabel-";
									
								// first get label content of value
								if ( strpos($checkOptionField, $contentField) !== false ){
									$content = $checkOptionValue;
									
									// get $tempValueID
									$tempValueIDPos = strpos($checkOptionField, "valueLabel-") + 11;
									$tempValueID = substr($checkOptionField,$tempValueIDPos);
	
									$orderField = "new-" . $tempID . "-valueChron-" . $tempValueID;	
									$liveField = "new-" . $tempID . "-valueOn-" . $tempValueID;
									$pointsField = "new-" . $tempID . "-valuePoints-" . $tempValueID;
									
									// go through array again to grab isLive and order info
									$checkMoreArrayValues = $checkArray;
									while ( list( $checkMoreField, $checkMoreValue ) = each ($checkMoreArrayValues)) {
																
										if ( $orderField == $checkMoreField ) {
								 			$order = $checkMoreValue;
										} 
										else if ( $liveField == $checkMoreField ){
												$isLive = $checkMoreValue;
											}
											else if ( $pointsField == $checkMoreField ){
													$points = $checkMoreValue;
												}
									}
									
									// add this radio value to the database
									mysql_query("INSERT INTO rubric_criteria_values (value_criteria_id, value_order, value_content, value_points, value_is_live) VALUES ('$radioID', '$order', '$content', '$points', '$isLive')") or die('There was an error saving: ' . mysql_error());
								}
							}
						}
					}
	}
	else if ( strpos($field, 'order') !== false ) {
					// saves criteria order
		 			$rubricCriteriaID = substr($field,6);
		 			mysql_query("UPDATE rubric_criteria SET criteria_order = '$value' WHERE criteria_id = '$rubricCriteriaID'");
		} 
		else if ( strpos($field, 'content') !== false ) {
				// saves criteria content
	 			$rubricCriteriaID = substr($field,8);
	 			mysql_query("UPDATE rubric_criteria SET criteria_content = '$value' WHERE criteria_id = '$rubricCriteriaID'");
			} 
			else if ( strpos($field, 'live') !== false ) {
					// sets is_live
		 			$rubricCriteriaID = substr($field,5);
		 			mysql_query("UPDATE rubric_criteria SET criteria_live = '$value' WHERE criteria_id = '$rubricCriteriaID'");
				}
				else if ( strpos($field, 'valueChron') !== false ) {
						// saves radio value order
			 			$valueID = substr($field,11);
			 			mysql_query("UPDATE rubric_criteria_values SET value_order = '$value' WHERE value_id = '$valueID'");
					} 
					else if ( strpos($field, 'valueLabel') !== false ) {
							// saves radio value content
				 			$valueID = substr($field,11);
				 			mysql_query("UPDATE rubric_criteria_values SET value_content = '$value' WHERE value_id = '$valueID'");
						} 
						else if ( strpos($field, 'valuePoints') !== false ) {
								// saves radio value points
					 			$valueID = substr($field,12);
					 			mysql_query("UPDATE rubric_criteria_values SET value_points = '$value' WHERE value_id = '$valueID'");
							}
							else if ( strpos($field, 'valOn') !== false ) {
									// sets is_live for value
									$valueID = substr($field, 6);
									mysql_query("UPDATE rubric_criteria_values SET value_is_live = '$value' WHERE value_id = '$valueID'");
							}
}


?>

<body id="save">

<p>Your new rubric was saved. <a href="user-admin.php">Click here to go back to User Admin.</a></p>

<?php require('includes/footer.php'); ?>