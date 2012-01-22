<?php 
/**
*	Rubric Creator - Functions
*	All the form-generating functions, primarily used in submit-form.php
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

$delimitedText = stripslashes($_POST['delimitedtext']);
$delimitedTextItems = explode( '
', $delimitedText );

/**
* Processes each item in the delimitedTextItems array
* @param arrayToProcess Array with each item being a row of the user-submitted tab-delimited text
*/
function processQuestions( $arrayToProcess ) {
	
	$question = array();
	$count = 1;
	
	/*	go through each $delimitedTextItems[] item and 
		explode them into a new $question[] array 		*/
	foreach ($arrayToProcess as $lineItem) {
		$question[$count] = explode( '	', $lineItem );
		$count++;
	}
	
	$count = 1;
	
	/*	go through each item in the $questions array
		and generate code for form items 				*/
	foreach ($question as $questionItem) {
		$questionType = strtolower($questionItem[0]);
		
		if ($questionType == 'title' ) {						// SHOULD PROBABLY CREATE ANOTHER TYPE FOR SUBTITLES
			generateTitle($questionItem, $count);
		}
		else if ($questionType == 'plaintext' ) {				// SHOULD IT BE PLAINTEXT IF IT IS HTML FRIENDLY? PROBABLY NOT. 1/19
				generatePlaintext($questionItem, $count);
			 }
			 else if ($questionType == 'question' ) {
	
			 		# view 2nd item to figure out the type of question, and process accordingly
					$questionInputType = strtolower($questionItem[1]);
					
					if ($questionInputType == 'radio' ) {
						generateQuestionRadio($questionItem, $count);
					}
					else if ($questionInputType == 'checklist') {
							generateQuestionChecklist($questionItem, $count);
						 }
						 else if ($questionInputType == 'textarea') {
						 		 generateQuestionTextarea($questionItem, $count);
						 	  }
						 	  else { /* do nothing because there is an error - say this in error log */
						 	  			echo '*** error: "' . $questionInputType . '" is not a valid question input type. Use <em>radio</em>, <em>checklist</em>, or <em>textareas</em>.<br />'; }
			 	  }
			 	  else { echo '*** error: "' . $questionType . '" is not a valid question type. Use <em>title</em>, <em>plaintext</em>, or <em>question</em>.<br />'; }
		
		$count++;
	}	
	
}

/**
* Outputs an <h1>, meant to be used for form titles
* @param $itemArray
* @param $itemCount
*/
function generateTitle($itemArray, $itemCount) {
	echo '<h1 class="title item-', $itemCount,'">', $itemArray[1], '</h1>';
}

/**
* Outputs a <div>, meant for text outside of questions
* @param $itemArray
* @param $itemCount
*/
function generatePlaintext( $itemArray, $itemCount ) {
	echo '<div class="plaintext item-', $itemCount, '">', $itemArray[1], '</div>';
}

/**
* Outputs a <fieldset> container for a radio button input
* @param $itemArray
* @param $itemCount
*/
function generateQuestionRadio( $itemArray, $itemCount ) {
	echo '<fieldset class="radio fieldset-', $itemCount, '">';
	echo '<label for="item-', $itemCount, '">', $itemArray[2], '</label>';
	
	$responseCount = 1;
	$responseStart = 3;
	$responseLength = count($itemArray) - $responseStart - 1;
	
	for ($i = $responseStart; $i <= $responseLength; $i++) {
		if ( $itemArray[$i] != '' ) {
			
			# odd number count => response. even # count => point value.
			if ( $responseCount % 2 ) {
				echo '<input type="radio" name="item-', $itemCount,'" value="',$itemArray[$i + 1],'" />', $itemArray[$i], ' (',$itemArray[$i + 1],' points)<br />';
			}
			$responseCount++;
		}
		else { /* do nothing, because these are blank fields, most likely caused by a spreadsheet copy/paste job */ }
	}
	echo '</fieldset>';
}

/**
* Outputs a <fieldset> container for a checklist input
* @param $itemArray
* @param $itemCount
*/
function generateQuestionChecklist( $itemArray, $itemCount ) {
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
	echo '</fieldset>';
}

/**
* Outputs a <fieldset> container for an open (textarea) input
* @param $itemArray
* @param $itemCount
*/
function generateQuestionTextarea( $itemArray, $itemCount ) {
	echo '<fieldset class="textarea fieldset-', $itemCount, '">';
	echo '<label for="item-', $itemCount, '">', $itemArray[2], '</label> <textarea name="item-', $itemCount,'"></textarea></fieldset>';
}

?>