<?php 
/**
*	Rubric Creator - Functions: Rubric
*		1. Processes delimited content
*		2. Generates rubric forms
*		3. Saves Rubric to Database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

/**
* Processes each item in the delimitedTextItems array
* @param $arrayToProcess
*/
function processCriteria( $arrayToProcess ) {
	
	$criteria = array();
	$count = 1;
	
	/*	go through each $delimitedTextItems[] item and 
		explode them into a new $criteria[] array 		*/
	foreach ($arrayToProcess as $lineItem) {
		$criteria[$count] = explode( '	', $lineItem );
		$count++;
	}
	
	$count = 1;
	
	/*	go through each item in the $criteria array
		and generate code for form items 				*/
	foreach ($criteria as $criteriaItem) {
		$criteriaType = strtolower($criteriaItem[0]);
		
		if ($criteriaType == 'title' ) {						
			generateTitle($criteriaItem, $count);
			$count++;
		}
		else if ($criteriaType == 'plaintext' ) {				
				generatePlaintext($criteriaItem, $count);
				$count++;
			 }
			 else if ($criteriaType == 'criteria' ) {
	
			 		# view 2nd item to figure out the type of criteria, and process accordingly
					$criteriaInputType = strtolower($criteriaItem[1]);
					
					if ($criteriaInputType == 'radio' ) {
						generateCriteriaRadio($criteriaItem, $count);
						$count++;
					}
					else { /* do nothing because there is an error - say this in error log */
					 	  			echo '*** error: "' . $criteriaInputType . '" is not a valid criteria input type. Use <em>radio</em>.<br />'; }
			 	  }
			 	  else { echo '*** error: "' . $criteriaType . '" is not a valid criteria type. Use <em>title</em>, <em>plaintext</em>, or <em>criteria</em>.<br />'; }	
	
	}	
	
}


/**
* Outputs an <h1>, meant to be used for form titles when initially creating rubric
* @param $itemArray
* @param $itemCount
*/
function generateTitle($itemArray, $itemCount) {
	echo '<h1 class="title item-', $itemCount,'">', $itemArray[1], '</h1>
		  <input type="hidden" name="title" value="', $itemArray[1],'" />';
}


/**
* Outputs a <div>, meant for text outside of criteria when initially creating rubric
* @param $itemArray
* @param $itemCount
*/
function generatePlaintext( $itemArray, $itemCount ) {
	echo '<div class="plaintext item-', $itemCount, '">', $itemArray[1], '</div>
		  <input type="hidden" name="plaintext" value="', $itemArray[1], '" />';
}


/**
* Outputs a <fieldset> container for a radio button input when initially creating rubric
* @param $itemArray
* @param $itemCount
*/
function generateCriteriaRadio( $itemArray, $itemCount ) {
	echo '<fieldset class="radio fieldset-', $itemCount, '">';
	echo '<label for="item-', $itemCount,'">', $itemArray[2], '</label>';
	echo '<input type="radio" name="item-',$itemCount,'" value="0" checked style="display:none;" />';

	$responseCount = 1;
	$responseStart = 3;
	$responseLength = count($itemArray) - $responseStart - 1;
	
	for ($i = $responseStart; $i <= $responseLength; $i++) {
		if ( $itemArray[$i] != '' ) {
			
			# odd number count => response. even # count => point value.
			if ( $responseCount % 2 ) {
				echo '<input type="radio" name="item-',$itemCount,'" value="',$itemArray[$i + 1],'" />', $itemArray[$i], ' (',$itemArray[$i + 1],' points)<br />';
			}
			$responseCount++;
		}
		else { /* do nothing, because these are blank fields, most likely caused by a spreadsheet copy/paste job */ }
	}
	echo '<label for="comment-', $itemCount, '">Comments:</label>';
	echo '<textarea name="comment-',$itemCount,'"></textarea>';
	echo '</fieldset>';
}


/**
* Saves Rubric to the database
* @param $author
* @param $title
* @param $description
* @param $content
*/
function saveRubricToDatabase($author, $title, $description, $content) {
	$content = mysql_real_escape_string($content);
	mysql_query("INSERT INTO rubric_form (rubric_author, rubric_title, rubric_description, rubric_content) VALUES ('$author', '$title', '$description', '$content')") or die('There was an error saving: ' . mysql_error());
	$latestRubric = mysql_insert_id();
	saveCriteriaToDatabase($latestRubric);
}


/**
* Saves Rubric's individual Criteria to the database
* @param $id
*/
function saveCriteriaToDatabase($id) {
	$result = mysql_query("SELECT * FROM rubric_form WHERE rubric_id = '$id';")  or die('There was an error saving: ' . mysql_error());
	$count = mysql_num_rows($result);
			
	if ($count != 0) { 
		while ( $row = mysql_fetch_array($result)) {
			$rubricContent = $row['rubric_content'];
			$criteria = array();
			$count = 1;
			
			$delimitedText = stripslashes($rubricContent);
			$delimitedTextItems = explode( '
', $delimitedText );
			
			/*	go through each $delimitedTextItems[] item and 
				explode them into a new $criteria[] array 		*/
			foreach ($delimitedTextItems as $lineItem) {
				$criteria[$count] = explode( '	', $lineItem );
				$count++;
			}
			
			$count = 1;
			
			/*	go through each item in the $criteria array
				and generate code for form items 				*/
			foreach ($criteria as $criteriaItem) {
				$criteriaType = strtolower($criteriaItem[0]);
				
				if ($criteriaType == 'title' ) {	
					$content = $criteriaItem[1];					
					mysql_query("INSERT INTO rubric_criteria (criteria_rubric_id, criteria_type, criteria_order, criteria_content) VALUES ('$id', '$criteriaType', '$count', '$content')") or die('There was an error saving: ' . mysql_error());
					$count++;
				}
				else if ($criteriaType == 'plaintext' ) {				
						$content = $criteriaItem[1];					
						mysql_query("INSERT INTO rubric_criteria (criteria_rubric_id, criteria_type, criteria_order, criteria_content) VALUES ('$id', '$criteriaType', '$count', '$content')") or die('There was an error saving: ' . mysql_error());
						$count++;
					 }
					 else if ($criteriaType == 'criteria' ) {
			
					 		# view 2nd item to figure out the type of criteria, and process accordingly
							$criteriaType = strtolower($criteriaItem[1]);
							
							if ($criteriaType == 'radio' ) {
							
								/* 1. save label of radio fieldset */
								$content = $criteriaItem[2];
								mysql_query("INSERT INTO rubric_criteria (criteria_rubric_id, criteria_type, criteria_order, criteria_content) VALUES ('$id', '$criteriaType', '$count', '$content')") or die('There was an error saving: ' . mysql_error());
								$criteriaID = mysql_insert_id();
								
								/* 2. save each value of radio fieldset */
								$responseCount = 1;
								$responseStart = 3;
								$responseLength = count($criteriaItem) - $responseStart - 1;
								
								for ($i = $responseStart; $i <= $responseLength; $i++) {
									if ( $criteriaItem[$i] != '' ) {
										$valueOrder = $i;
										$valueContent = $criteriaItem[$i];
										$valuePoints = $criteriaItem[$i + 1];
										
										# odd number count => response. even # count => point value.
										if ( $responseCount % 2 ) {
											mysql_query("INSERT INTO rubric_criteria_values (value_criteria_id, value_order, value_content, value_points) VALUES ('$criteriaID', '$valueOrder', '$valueContent', '$valuePoints')") or die('There was an error saving: ' . mysql_error());	
										}
									}
									$responseCount++;
								}
								
								$count++;
							}
						 	else { /* do nothing because there is an error - say this in error log */
							 	  			echo '*** error: "' . $criteriaInputType . '" is not a valid criteria input type. Use <em>radio</em>.<br />'; }
					 	  }
					 	  else { echo '*** error: "' . $criteriaType . '" is not a valid criteria type. Use <em>title</em>, <em>plaintext</em>, or <em>criteria</em>.<br />'; }	
			
			}	
		}
	}
}


/**
* Updates rubric in database
* @param $id
* @param $author
* @param $title
* @param $description
* @param $content
*/
function editRubric($id, $author, $title, $description, $content) {
	$content = mysql_real_escape_string($content);
	mysql_query("UPDATE rubric_form SET rubric_title = '$title', rubric_description = '$description', rubric_content = '$content' WHERE rubric_id = '$id';") or die('There was an error saving: ' . mysql_error());
}


?>