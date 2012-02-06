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
* @param arrayToProcess Array with each item being a row of the user-submitted tab-delimited text
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
		
		if ($criteriaType == 'title' ) {						// SHOULD PROBABLY CREATE ANOTHER TYPE FOR SUBTITLES
			generateTitle($criteriaItem, $count);
		}
		else if ($criteriaType == 'plaintext' ) {				// SHOULD IT BE PLAINTEXT IF IT IS HTML FRIENDLY? PROBABLY NOT. 1/19
				generatePlaintext($criteriaItem, $count);
			 }
			 else if ($criteriaType == 'criteria' ) {
	
			 		# view 2nd item to figure out the type of criteria, and process accordingly
					$criteriaInputType = strtolower($criteriaItem[1]);
					
					if ($criteriaInputType == 'radio' ) {
						generateCriteriaRadio($criteriaItem, $count);
						$count++;
					}
					else if ($criteriaInputType == 'checklist') {
							generateCriteriaChecklist($criteriaItem, $count);
							$count++;
						 }
						 else if ($criteriaInputType == 'textarea') {
						 		 generateCriteriaTextarea($criteriaItem, $count);
						 		 $count++;
						 	  }
						 	  else { /* do nothing because there is an error - say this in error log */
						 	  			echo '*** error: "' . $criteriaInputType . '" is not a valid criteria input type. Use <em>radio</em>, <em>checklist</em>, or <em>textareas</em>.<br />'; }
			 	  }
			 	  else { echo '*** error: "' . $criteriaType . '" is not a valid criteria type. Use <em>title</em>, <em>plaintext</em>, or <em>criteria</em>.<br />'; }	
	
	}	
	
}

/**
* Outputs an <h1>, meant to be used for form titles
* @param $itemArray
* @param $itemCount
*/
function generateTitle($itemArray, $itemCount) {
	echo '<h1 class="title item-', $itemCount,'">', $itemArray[1], '</h1>
		  <input type="hidden" name="title" value="', $itemArray[1],'" />';
}

/**
* Outputs a <div>, meant for text outside of criteria
* @param $itemArray
* @param $itemCount
*/
function generatePlaintext( $itemArray, $itemCount ) {
	echo '<div class="plaintext item-', $itemCount, '">', $itemArray[1], '</div>
		  <input type="hidden" name="plaintext" value="', $itemArray[1], '" />';
}

/**
* Outputs a <fieldset> container for a radio button input
* @param $itemArray
* @param $itemCount
*/
function generateCriteriaRadio( $itemArray, $itemCount ) {
	echo '<fieldset class="radio fieldset-', $itemCount, '">';
	echo '<label for="', $itemArray[2],'">', $itemArray[2], '</label>';
	
	$responseCount = 1;
	$responseStart = 3;
	$responseLength = count($itemArray) - $responseStart - 1;
	
	for ($i = $responseStart; $i <= $responseLength; $i++) {
		if ( $itemArray[$i] != '' ) {
			
			# odd number count => response. even # count => point value.
			if ( $responseCount % 2 ) {
				echo '<input type="radio" name="',$itemArray[2],'" value="',$itemArray[$i + 1],'" />', $itemArray[$i], ' (',$itemArray[$i + 1],' points)<br />';
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
* Outputs a <fieldset> container for a checklist input
* @param $itemArray
* @param $itemCount
*/
function generateCriteriaChecklist( $itemArray, $itemCount ) {
	echo '<fieldset class="checkbox fieldset-', $itemCount, '">';
	echo '<label for="item-', $itemCount, '">', $itemArray[2], '</label>';
	
	$responseCount = 1;
	$responseStart = 3;
	$responseLength = count($itemArray) - $responseStart - 1;
	
	for ($i = $responseStart; $i <= $responseLength; $i++) {
		if ( $itemArray[$i] != '' ) {
			
			# odd number count => response. even # count => point value.
			if ( $responseCount % 2 ) {
				echo '<input type="checkbox" name="item-', $itemCount,'" value="',$itemArray[$i + 1],'" />', $itemArray[$i], ' (',$itemArray[$i + 1],' points)<br />';
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
* Outputs a <fieldset> container for an open (textarea) input
* @param $itemArray
* @param $itemCount
*/
function generateCriteriaTextarea( $itemArray, $itemCount ) {
	echo '<fieldset class="textarea fieldset-', $itemCount, '">';
	echo '<label for="item-', $itemCount, '">', $itemArray[2], '</label> <textarea name="item-', $itemCount,'"></textarea></fieldset>';
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
}

?>