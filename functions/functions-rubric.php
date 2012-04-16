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


//*******************************************************
//	Creating Rubric
//*******************************************************

/**
* Processes each item in the delimitedTextItems array
* @param $arrayToProcess - array of tab-delimited rubric content
*/
function processCriteria($arrayToProcess) {
	
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
					else if ($criteriaInputType == 'textbox' ) {
							generateCriteriaTextbox($criteriaItem, $count);
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
* @param $itemArray - tokens for title array
* @param $itemCount - order of this item
*/
function generateTitle($itemArray, $itemCount) {
	echo '<h1 class="title item-'. $itemCount . '">'. $itemArray[1] . '</h1>
		  <input type="hidden" name="title" value="'. $itemArray[1] . '" />';
}

/**
* Outputs a <div>, meant for text outside of criteria when initially creating rubric
* @param $itemArray - tokens for text array
* @param $itemCount - order of this item
*/
function generatePlaintext($itemArray, $itemCount) {
	echo '<div class="plaintext item-'. $itemCount .  '">'. $itemArray[1] . '</div>
		  <input type="hidden" name="plaintext" value="'. $itemArray[1] .  '" />';
}

/**
* Outputs a <fieldset> container for a radio button input when initially creating rubric
* @param $itemArray - tokens for radio array
* @param $itemCount - order of this item
*/
function generateCriteriaRadio($itemArray, $itemCount) {
	echo '<fieldset class="radio check fieldset-' . $itemCount . '">';
	echo '<label for="item-'. $itemCount . '">' . $itemArray[2] . '</label>';
	
	$responseCount = 1;
	$responseStart = 3;
	$responseLength = count($itemArray) - $responseStart + 1;
	
	for ($i = $responseStart; $i <= $responseLength; $i++) {
		if ( $itemArray[$i] != '' ) {
			
			# odd number count => response. even # count => point value.
			if ( $responseCount % 2 ) {
				echo '<input type="radio" name="item-' . $itemCount . '" value="' . $itemArray[$i + 1] . '" />' . $itemArray[$i] . ' (' . $itemArray[$i + 1] . ' points)<br />';
			}
			$responseCount++;
		}
		else { /* do nothing, because these are blank fields, most likely caused by a spreadsheet copy/paste job */ }
	}
	echo '<label for="comment-' . $itemCount . '">Comments:</label>';
	echo '<textarea name="comment-' . $itemCount . '"></textarea>';
	echo '</fieldset>';
}

/**
* Outputs a <fieldset> container for a label and textbox when initially creating rubric
* @param $itemArray - tokens for textbox array
* @param $itemCount - order of this item
*/
function generateCriteriaTextbox($itemArray, $itemCount) {
	echo '<fieldset class="textbox fieldset-' . $itemCount . '">';
	echo '<label for="item-'. $itemCount . '">' . $itemArray[2] . '</label>';
	echo '<input type="text" name="item-' . $itemCount . '" />';
	echo '</fieldset>';
}


//*******************************************************
//	Saving New Rubric
//*******************************************************

/**
* Saves Rubric to the database
* @param $author - id of user that created this rubric
* @param $title - title of rubric
* @param $description - description of rubric
* @param $content - delimited content of rubric
*/
function saveRubricToDatabase($author, $title, $description, $content) {
	$content = mysql_real_escape_string($content);
	mysql_query("INSERT INTO rubric_form (rubric_author, rubric_title, rubric_description, rubric_content) VALUES ('$author', '$title', '$description', '$content')") or die('There was an error saving: ' . mysql_error());
	$latestRubric = mysql_insert_id();
	
	// only moves on if created with delimited content
	if ( $content != "") {
		saveCriteriaToDatabase($latestRubric);
	}
}

/**
* Saves Rubric's individual Criteria to the database
* @param $id - id of rubric having criteria saved
*/
function saveCriteriaToDatabase($id) {

	// get rubric info
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
			
					 		// view 2nd item to figure out the type of criteria, and process accordingly
							$criteriaType = strtolower($criteriaItem[1]);
							
							if ($criteriaType == 'radio' ) {
							
								// 1. save label of radio fieldset
								$content = $criteriaItem[2];
								mysql_query("INSERT INTO rubric_criteria (criteria_rubric_id, criteria_type, criteria_order, criteria_content) VALUES ('$id', '$criteriaType', '$count', '$content')") or die('There was an error saving: ' . mysql_error());
								$criteriaID = mysql_insert_id();
								
								// 2. save each value of radio fieldset
								$responseCount = 1;
								$responseStart = 3;
								$responseLength = count($criteriaItem) - $responseStart - 1;
								$valueOrder = 1;
								
								for ($i = $responseStart; $i <= $responseLength; $i++) {
									if ( $criteriaItem[$i] != '' ) {
										$valueContent = $criteriaItem[$i];
										$valuePoints = $criteriaItem[$i + 1];
										
										// odd number count => response. even # count => point value.
										if ( $responseCount % 2 ) {
											mysql_query("INSERT INTO rubric_criteria_values (value_criteria_id, value_order, value_content, value_points) VALUES ('$criteriaID', '$valueOrder', '$valueContent', '$valuePoints')") or die('There was an error saving: ' . mysql_error());	
											$valueOrder++;
										}
									}
									$responseCount++;
								}
								
								$count++;
							}
							else if ($criteriaType == 'textbox' ) {
							
									// save label of textbox fieldset
									$content = $criteriaItem[2];					
									mysql_query("INSERT INTO rubric_criteria (criteria_rubric_id, criteria_type, criteria_order, criteria_content) VALUES ('$id', '$criteriaType', '$count', '$content')") or die('There was an error saving: ' . mysql_error());
									$count++;										
								}
							 	else { 
							 		echo '*** error: "' . $criteriaInputType . '" is not a valid criteria input type. Use <em>radio</em>.<br />'; 
							 	}
					 	}
						else { 
							echo '*** error: "' . $criteriaType . '" is not a valid criteria type. Use <em>title</em>, <em>plaintext</em>, or <em>criteria</em>.<br />';
					 	}	
			}	
		}
	}
}


//*******************************************************
//	Printing Rubric
//*******************************************************

/** 
* Prints rubric for completion and editing
* @param $id -  id of rubric to print
* @param $editGrade - id of grade if editing a grade and "false" means otherwise
*/

function printRubric($id, $editGrade) {
	
	// get criteria info to print
	$rubricID = $id;
	$criteriaSet = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_rubric_id = '$rubricID' AND criteria_live = '1' ORDER BY criteria_order;")  or die('Error: Cannot get criteria from this rubric. Contact admin for help: ' . mysql_error());
	$count = mysql_num_rows($criteriaSet);
	$criteriaOrder = 1;
	$radioTextOrder = 1;
	
	if ( $count != 0 ) {
		
		while ( $row = mysql_fetch_array($criteriaSet)) {
		
			$criteriaID = $row['criteria_id'];
			$criteriaType = $row['criteria_type'];
			
			if ( $criteriaType == 'title' ) {
				printTitle($criteriaID);
				$criteriaOrder++;
			}
			else if ( $criteriaType == 'plaintext' ) {
					printPlaintext($criteriaID, $criteriaOrder);	
					$criteriaOrder++;	
				}
				else if ( $criteriaType == 'radio') {
						if ( $editGrade != 0 ) {
							printGradedRadio($criteriaID, $radioTextOrder, $editGrade);
						}
						else {
							printRadio($criteriaID, $radioTextOrder);
						}
						$radioTextOrder++;
						$criteriaOrder++;
					}
					else if ( $criteriaType == 'textbox') {
							if ( $editGrade != 0 ) {
							printGradedTextbox($criteriaID, $radioTextOrder, $editGrade);
							}
							else {
								printTextbox($criteriaID, $radioTextOrder);
							}
							$radioTextOrder++;
							$criteriaOrder++;					
						}
						else echo "Error: One of this rubric's criteria is invalid. Contact admin for help.";
		}
	}
	else echo "Error: There is no criteria in this rubric. Contact admin for help.";
}


/** 
* Prints rubric criteria of type "title"
* @param $id - id of title criteria
*/
function printTitle($id) {
	$criteriaID = $id;
	$criteriaRecord = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_ID = '$criteriaID'") or die('Error: Cannot get Title criteria wanted. Contact admin for help: ' . mysql_error());
	$count = mysql_num_rows($criteriaRecord);
	
	if ( $count == 1 ) {
	
		while ( $row = mysql_fetch_array($criteriaRecord)) {
		
			$criteriaContent = $row['criteria_content'];
			echo '<h1 class="rubric-title criteria-' . $criteriaID . '">' . $criteriaContent . '</h1>';

		}
	}
	else echo "Error: Multiple, or no, criteria with this ID exist. Contact admin for help.";
}

/** 
* Prints rubric criteria of type "plaintext"
* @param $id - id of text criteria
*/
function printPlaintext($id) {
	$criteriaID = $id;
	$criteriaRecord = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_ID = '$criteriaID'") or die('Error: Cannot get Plaintext criteria wanted. Contact admin for help: ' . mysql_error());
	$count = mysql_num_rows($criteriaRecord);
	
	if ( $count == 1 ) {
	
		while ( $row = mysql_fetch_array($criteriaRecord)) {
		
			$criteriaContent = $row['criteria_content'];
			echo '<div class="rubric-plaintext criteria-'. $criteriaID . '">' . $criteriaContent . '</div>';

		}
	}
	else echo "Error: Multiple, or no, criteria with this ID exist. Contact admin for help.";
}

/** 
* Prints rubric criteria of type "radio"
* @param $id - id of radio criteria
* @param $order - order of this out of all criteria
*/
function printRadio($id, $order) {

	// get this radio criteria to print
	$criteriaID = $id;
	$radioTextOrder = $order;
	$criteriaRecord = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_ID = '$criteriaID'") or die('Error: Cannot get Radio criteria wanted. Contact admin for help: ' . mysql_error());
	$count = mysql_num_rows($criteriaRecord);
	
	if ( $count == 1 ) {
		
		while ( $row = mysql_fetch_array($criteriaRecord)) {
		
			$radioLabel = $row['criteria_content'];
			
			echo '<fieldset class="rubric-radio check criteria-' . $criteriaID . '">';
			echo '<label for="criteria-' . $criteriaID . '">' . $radioTextOrder . ". " . $radioLabel . '</label>';

			// get all the values of this radio criteria
			$criteriaValues = mysql_query("SELECT * FROM rubric_criteria_values WHERE value_criteria_id = '$criteriaID' AND value_is_live = '1' ORDER BY value_order") or die('Error: Cannot get radio Values wanted. Contact admin for help: ' . mysql_error());
			$valueCount = mysql_num_rows($criteriaValues);
			
			if ( $valueCount != 0 ) {
			
				while ( $valueRow = mysql_fetch_array($criteriaValues)) {
				
					$valueID = $valueRow['value_id'];
					$valueContent = $valueRow['value_content'];
					$valuePoints = $valueRow['value_points'];
				
					echo '<input type="radio" name="criteria-' . $criteriaID . '" value="' . $valueID . '" />' . $valueContent . ' (' . $valuePoints . ' points)<br />';
				
				}
			}
			else echo "Error: No values for this radio-type criteria exist. Contact admin for help.";
			
			echo '<label for="comment-' . $criteriaID . '">Comments:</label>';
			echo '<textarea name="comment-' . $criteriaID . '"></textarea>';
			echo '</fieldset>';
		}
	}
	else echo "Error: Multiple, or no, criteria with this ID exist. Contact admin for help.";
}

/** 
* Prints rubric criteria of type "textbox"
* @param $id - id of textbox criteria
* @param $order - order of this out of all criteria
*/
function printTextbox($id, $order) {

	// get this textbox criteria
	$criteriaID = $id;
	$radioTextOrder = $order;
	$criteriaRecord = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_ID = '$criteriaID'") or die('Error: Cannot get Textbox criteria wanted. Contact admin for help: ' . mysql_error());
	$count = mysql_num_rows($criteriaRecord);
	
	if ( $count == 1 ) {
		
		while ( $row = mysql_fetch_array($criteriaRecord)) {
		
			$textboxLabel = $row['criteria_content'];
			echo '<fieldset class="rubric-textbox criteria-' . $criteriaID . '">';
			echo '<label for="criteria-' . $criteriaID . '">' . $radioTextOrder . ". " . $textboxLabel . '</label>';
			echo '<input type="text" name="textbox-' . $criteriaID . '" />';
			echo '</fieldset>';
		}
	}
	else echo "Error: Multiple, or no, criteria with this ID exist. Contact admin for help.";
}

//*******************************************************
//	Editing Rubric
//*******************************************************

/** 
* Prints rubric criteria of type "title" to be editable
* @param $id - id of criteria title 
*/
function printEditTitle($id) {
	// get this title criteria
	$criteriaID = $id;
	$criteriaRecord = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_ID = '$criteriaID'") or die('Error: Cannot get Title criteria wanted. Contact admin for help: ' . mysql_error());
	$count = mysql_num_rows($criteriaRecord);
	
	if ( $count == 1 ) {
	
		while ( $row = mysql_fetch_array($criteriaRecord)) {
			$criteriaOrder = $row['criteria_order'];
			$criteriaContent = $row['criteria_content'];
			$criteriaLove = $row['criteria_live'];
			
			echo 'Order: <input type="text" name="order-' . $criteriaID . '" class="order" value="' . $criteriaOrder . '" />';
			echo '<br />';
			echo 'Title Content: <input type="text" name="content-' . $criteriaID . '" class="content title" value="' . $criteriaContent . '" />';
		}
	}
	else echo "Error: Multiple, or no, criteria with this ID exist. Contact admin for help.";
}

/** 
* Prints rubric criteria of type "plaintext" to be editable
* @param $id - id of criteria text
*/
function printEditPlaintext($id) {
	// get this text criteria
	$criteriaID = $id;
	$criteriaRecord = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_ID = '$criteriaID'") or die('Error: Cannot get Plaintext criteria wanted. Contact admin for help: ' . mysql_error());
	$count = mysql_num_rows($criteriaRecord);
	
	if ( $count == 1 ) {
	
		while ( $row = mysql_fetch_array($criteriaRecord)) {	
			$criteriaOrder = $row['criteria_order'];
			$criteriaContent = $row['criteria_content'];
			$criteriaLove = $row['criteria_live'];
			
			echo 'Order: <input type="text" name="order-' . $criteriaID . '" class="order" value="' . $criteriaOrder . '" />';
			echo '<br />';
			echo 'Text Content: <input type="text" name="content-' . $criteriaID . '" class="content text" value="' . $criteriaContent . '" />';

		}
	}
	else echo "Error: Multiple, or no, criteria with this ID exist. Contact admin for help.";
}

/** 
* Prints rubric criteria of type "radio" to be edited
* @param $id - id of criteria radio
*/

function printEditRadio($id) {
	// get this radio criteria
	$criteriaID = $id;
	$criteriaRecord = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_ID = '$criteriaID'") or die('Error: Cannot get Radio criteria wanted. Contact admin for help: ' . mysql_error());
	$count = mysql_num_rows($criteriaRecord);
	
	if ( $count == 1 ) {
	
		while ( $row = mysql_fetch_array($criteriaRecord)) {	
			$criteriaOrder = $row['criteria_order'];
			$criteriaContent = $row['criteria_content'];
			$criteriaLove = $row['criteria_live'];
			
			echo 'Order: <input type="text" name="order-' . $criteriaID . '" class="order" value="' . $criteriaOrder . '" />';
			echo '<br />';
			echo 'Radio Label: <input type="text" name="content-' . $criteriaID . '" class="content radio" value="' . $criteriaContent . '" />';
			
			// get criteria values for this radio item
			$valueRecord = mysql_query("SELECT * FROM rubric_criteria_values WHERE value_criteria_id = '$criteriaID' AND value_is_live = '1' ORDER BY value_order") or die('Error: Cannot get Radio Criteria Values wanted. Contact admin for help: ' . mysql_error());
			$valueCount = mysql_num_rows($valueRecord);
								
			if ( $valueCount > 0 ){
			
				echo '<p>Options:</p>';
				echo '<ul class="radio-options">';
			
				while ( $rowValue = mysql_fetch_array($valueRecord)) {
					$valueID = $rowValue['value_id'];
					$valueOrder = $rowValue['value_order'];
					$valueContent = $rowValue['value_content'];
					$valuePoints = $rowValue['value_points'];
					
					echo '<li>';
					echo 'Option Order: <input type="text" name="valueChron-' . $valueID . '" class="value-order" value="' . $valueOrder . '" />';
					echo '<br />';
					echo 'Option Label: <input type="text" name="valueLabel-' . $valueID . '" class="value-label" value="' . $valueContent . '" />';
					echo '<br />';
					echo 'Option Points: <input type="text" name="valuePoints-' . $valueID . '" class="value-points" value="' . $valuePoints . '" />';
					echo '<br /><div class="button delete-value">Delete this Option</div>';
					echo '<input type="hidden" name="valOn-' . $valueID . '" class="is-live" value="1" />';
					echo '</li>';
					
				}
				
				echo '</ul><div class="button add-value existing-radio">Add Option</div>';
							
			}
			else echo "(There are no options/values for this Radio criteria.)";

		}
	}
	else echo "Error: Multiple, or no, criteria with this ID exist. Contact admin for help.";
}

/** 
* Prints rubric criteria of type "textbox" to be edited
* @param $id - id of textbox criteria
*/
function printEditTextbox($id) {
	// get this textbox criteria
	$criteriaID = $id;
	$criteriaRecord = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_ID = '$criteriaID'") or die('Error: Cannot get Textbox criteria wanted. Contact admin for help: ' . mysql_error());
	$count = mysql_num_rows($criteriaRecord);
	
	if ( $count == 1 ) {
	
		while ( $row = mysql_fetch_array($criteriaRecord)) {	
			$criteriaOrder = $row['criteria_order'];
			$criteriaContent = $row['criteria_content'];
			$criteriaLove = $row['criteria_live'];
			
			echo 'Order: <input type="text" name="order-' . $criteriaID . '" class="order" value="' . $criteriaOrder . '" />';
			echo '<br />';
			echo 'Textbox Label: <input type="text" name="content-' . $criteriaID . '" class="content textbox" value="' . $criteriaContent . '" />';
			
		}
	}
	else echo "Error: Multiple, or no, criteria with this ID exist. Contact admin for help.";
}


//*******************************************************
//	Grade Rubric
//*******************************************************

/** 
* Prints rubric criteria of type "radio" to edit the grade
* @param $id - id of this radio criteria
* @param $order - order of this radio criteria out of all criteria
* @param $grade - id of grade to get selected values
*/
function printGradedRadio($id, $order, $grade) {
	$criteriaID = $id;
	$gradeID = $grade;
	$radioTextOrder = $order;
	
	// get radio criteria
	$criteriaRecord = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_ID = '$criteriaID'") or die('Error: Cannot get Radio criteria wanted. Contact admin for help: ' . mysql_error());
	$count = mysql_num_rows($criteriaRecord);
	
	if ( $count == 1 ) {
		
		while ( $row = mysql_fetch_array($criteriaRecord)) {
		
			$radioLabel = $row['criteria_content'];
			
			echo '<fieldset class="rubric-radio criteria-' . $criteriaID . '">';
			echo '<label for="criteria-' . $criteriaID . '">' . $radioTextOrder . ". " . $radioLabel . '</label>';
			
			// get radio criteria's values
			$criteriaValues = mysql_query("SELECT * FROM rubric_criteria_values WHERE value_criteria_id = '$criteriaID' ORDER BY value_order") or die('Error: Cannot get radio Values wanted. Contact admin for help: ' . mysql_error());
			$valueCount = mysql_num_rows($criteriaValues);
			
			if ( $valueCount != 0 ) {
			
				while ( $valueRow = mysql_fetch_array($criteriaValues)) {
				
					$valueID = $valueRow['value_id'];
					$valueContent = $valueRow['value_content'];
					$valuePoints = $valueRow['value_points'];
					
					// get graded value of this radio criteria value
					$gradeValue = mysql_query("SELECT * FROM rubric_grade_answers WHERE answer_criteria_id = '$criteriaID' AND answer_grade_id = '$gradeID' AND is_comment = '0'");	
					$gradeValueCount = mysql_num_rows($gradeValue);
					
					if ( $gradeValueCount == 0 ) {
						echo '<input type="radio" name="criteria-' . $criteriaID . '" value="' . $valueID . '" />' . $valueContent . ' (' . $valuePoints . ' points)<br />';
					}
					else {
						while ( $gradeValueRow = mysql_fetch_array($gradeValue) ) {
						
							$gradeChosen = $gradeValueRow['answer_value'];
							if ( $gradeChosen == $valueID ) {
									echo '<input type="radio" name="criteria-' . $criteriaID . '" value="' . $valueID . '" checked />' . $valueContent . ' (' . $valuePoints . ' points)<br />';
							}
							else {
									echo '<input type="radio" name="criteria-' . $criteriaID . '" value="' . $valueID . '" />' . $valueContent . ' (' . $valuePoints . ' points)<br />';
								
							}
						}
					}
				}
			}
			else echo "Error: No values for this radio-type criteria exist. Contact admin for help.";
			
			// get comment info for this criteria
			$gradeValue = mysql_query("SELECT * FROM rubric_grade_answers WHERE answer_criteria_id = '$criteriaID' AND answer_grade_id = '$gradeID' AND is_comment = '1'");	
			$gradeValueCount = mysql_num_rows($gradeValue);
			
			if ( $gradeValueCount == 0 ) {
				$commentContent = "No comment.";
			}
			else {
				while ( $gradeValueRow = mysql_fetch_array($gradeValue) ) {
					$commentContent = $gradeValueRow['answer_value'];
				}
			}
			echo '<label for="comment-' . $criteriaID . '">Comments:</label>';
			echo '<textarea name="comment-' . $criteriaID . '">'. $commentContent .'</textarea>';
			echo '</fieldset>';
		}
	}
	else echo "Error: Multiple, or no, criteria with this ID exist. Contact admin for help.";
}

/** 
* Prints rubric criteria of type "textbox" to edit grade
* @param $id - id of this textobx criteria
* @param $order - order of this textbox criteria out of all criteria
* @param $grade - id of grade to get submitted values
*/
function printGradedTextbox($id, $order, $grade) {
	$criteriaID = $id;
	$gradeID = $grade;
	$radioTextOrder = $order;
	
	// get textbox criteria
	$criteriaRecord = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_ID = '$criteriaID'") or die('Error: Cannot get Textbox criteria wanted. Contact admin for help: ' . mysql_error());
	$count = mysql_num_rows($criteriaRecord);
	
	if ( $count == 1 ) {
		
		while ( $row = mysql_fetch_array($criteriaRecord)) {
		
			$textboxLabel = $row['criteria_content'];
			
			echo '<fieldset class="rubric-textbox criteria-' . $criteriaID . '">';
			echo '<label for="criteria-' . $criteriaID . '">' . $radioTextOrder . ". " . $textboxLabel . '</label>';
			
			// get graded value of this textbox 					
			$gradeValue = mysql_query("SELECT * FROM rubric_grade_answers WHERE answer_criteria_id = '$criteriaID' AND answer_grade_id = '$gradeID' AND is_textbox = '1'");	
			$gradeValueCount = mysql_num_rows($gradeValue);
			
			if ( $gradeValueCount == 0 ) {
				// do nothing
			}
			else {
				while ( $gradeValueRow = mysql_fetch_array($gradeValue) ) {
					$textboxContent = $gradeValueRow['answer_value'];
				}
			}
			echo '<input type="text" name="textbox-' . $criteriaID . '" value="' . $textboxContent . '" />';
			echo '</fieldset>';
		}
	}
	else echo "Error: Multiple, or no, criteria with this ID exist. Contact admin for help.";
}

//*******************************************************
//	Miscellaneous Rubric Functions
//*******************************************************

/**
* Calculates and returns the total possible points for grades of a specific rubric
* @param $rubricID - id of rubric to get the maximum number of points possible
*/
function calculateTotalPossiblePoints( $rubricID ) {
	$possiblePoints = 0;
	$criteria = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_rubric_id = '$rubricID' AND criteria_type = 'radio'");
	$criteriaCount = mysql_num_rows($criteria);
	
	if ( $criteriaCount > 0 ) {
		while ( $criteriaRow = mysql_fetch_array($criteria) ) {
			$criteriaID = $criteriaRow['criteria_id'];
			
			$criteriaValues = mysql_query("SELECT * FROM rubric_criteria_values WHERE value_criteria_id = '$criteriaID' AND value_is_live = '1';");
			$criteriaValuesCount = mysql_num_rows($criteriaValues);
			
			if ($criteriaValuesCount > 0) {
				while ( $criteriaValuesRow = mysql_fetch_array($criteriaValues) ) {
					$valuePoints = $criteriaValuesRow['value_points'];
					if ( $valuePoints > $possiblePoints ) {
						$possiblePoints = $valuePoints;
					}
				}
			}
			else $possiblePoints = 0;
		}
	}
	else $possiblePoints = 0;
	
	return $possiblePoints;
}

/** 
* Deletes given rubric from the database
* @param $id - id of rubric to be deleted
*/
function deleteRubric($id) {
	// remove rubric from database
	mysql_query("DELETE FROM rubric_form WHERE rubric_id = '$id'") or die();
	
	// get rubric_criteria where criteria_rubric_id = $id
	$criteriaRecords = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_rubric_id = '$id'") or die();
	$criteriaCount = mysql_num_rows($criteriaRecords);
	
	if ( $criteriaCount > 0 ) {
		while ( $criteriaRow = mysql_fetch_array($criteriaRecords) ) {
			// delete all records in rubric_criteria_values where value_criteria_id = criteria-id
			$criteriaID = $criteriaRow['criteria_id'];
			mysql_query("DELETE FROM rubric_criteria_values WHERE value_criteria_id = '$criteriaID'") or die();
		}
	}
	else { /* there's no criteria, so there's nothing to do */ }
	
	// delete all criteria for this rubric
	mysql_query("DELETE FROM rubric_criteria WHERE criteria_rubric_id = '$id'");
}


?>