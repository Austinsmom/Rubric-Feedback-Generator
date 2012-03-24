<?php 
/**
*	Rubric Creator - Functions: Grade
*		1. Saves Grade to the database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

/**
* Saves Grade to the database
* @param $student
* @param $rubricID
* @param $assignment
* @param $content
* @param $points
*/
function saveGradeToDatabase( $student, $rubricID, $assignment ) {
	mysql_query("INSERT INTO rubric_grade (grade_student, grade_rubric_id, grade_assignment_id) VALUES ('$student', '$rubricID', '$assignment')") or die('There was an error saving: ' . mysql_error());
}

/**
* Returns content of grade email
* @param $gradeID
* @param $userNicename
* @param $assignmentTitle
*/
function gradeEmailContent( $gradeID, $userNicename, $assignmentTitle ) {

	$gradeQuery = mysql_query("SELECT * FROM rubric_grade WHERE grade_id = '$gradeID'");
	$gradeCount = mysql_num_rows($gradeQuery);					
	if ($gradeCount == 1 ) {
		while ( $gradeRow = mysql_fetch_array($gradeQuery) ) {
			$assignmentID = $gradeRow['grade_assignment_id'];
			$rubricID = $gradeRow['grade_rubric_id'];
		}

		$gradePoints = calculateGradeTotal($gradeID);
		$possiblePoints = calculateTotalPossiblePoints($rubricID);
		$gradeContent = printGradeAnswers($gradeID);

		// echo content of the email
		return '<p>The following is the feedback and grade on your <strong>"' . $assignmentTitle . '"</strong> submission:
		
			<p>###########################################################</p>
			
			<div style="margin:10px 0;">' . $gradeContent . '</div>
			
			<p>###########################################################</p>  
			
			<p><span style="font-weight:bold;">Your Grade:</span> ' . $gradePoints . ' (out of ' . $possiblePoints . ' possible points)</p>
			
			<p>###########################################################</p>  
			<p>Respond to this email if you have any questions.</p> <p>--</p>
			<p>' . $userNicename . '<br /><em>Sent via Rubric Creator 9000XL Premium</em></p>';
		
	}
	else {
		echo "Error - multiple grades with this ID exists. Contact admin for help.";
	}
}


/**
* Calculates and returns the total points of a grade
* @param $gradeID
*/
function calculateGradeTotal( $gradeID ) {
	$gradeTotal = 0;
	
	$answers = mysql_query("SELECT * FROM rubric_grade_answers WHERE answer_grade_id = '$gradeID' AND is_comment = '0' AND is_textbox = '0';");
	$answersCount = mysql_num_rows($answers);
	
	if ( $answersCount > 0 ) {
	
		while ( $answersRow = mysql_fetch_array($answers) ) {
			$answerID = $answersRow['answer_value'];
			
			$answerValues = mysql_query("SELECT * FROM rubric_criteria_values WHERE value_id = '$answerID';");
			$answerValuesCount = mysql_num_rows($answerValues);
			
			if ( $answerValuesCount == 1 ) {
				
				while ( $valuesRow = mysql_fetch_array($answerValues) ) {
					$value = $valuesRow['value_points'];
					$gradeTotal += $value;
				}
			}
			else return "Error: Multiple values exist with this ID. Contact admin for help.";
		}
	
	}
	else $gradeTotal = 0;
	
	return $gradeTotal;
}

/** 
* Returns grade's answer content
* @param $gradeID
*/

function printGradeAnswers( $gradeID ) {
	$gradeAnswers = "";
	$gradeSet = mysql_query("SELECT * FROM rubric_grade WHERE grade_id = '$gradeID';");
	$gradeCount = mysql_num_rows($gradeSet);
	
	if ( $gradeCount == 1 ) {
		
		while ( $gradeRow = mysql_fetch_array($gradeSet)) {
			$rubricID = $gradeRow['grade_rubric_id'];
			$rubricSet = mysql_query("SELECT * FROM rubric_form WHERE rubric_id = '$rubricID';");
			$rubricCount = mysql_num_rows($rubricSet);
			
			if ( $rubricCount == 1 ) {
						
				$criteriaSet = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_rubric_id = '$rubricID' AND criteria_live = '1' ORDER BY criteria_order;")  or die('Error: Cannot get criteria from this rubric. Contact admin for help: ' . mysql_error());
				$criteriaCount = mysql_num_rows($criteriaSet);
				$criteriaOrder = 1;
				$radioTextOrder = 1;
				
				if ( $criteriaCount != 0 ) {
					
					while ( $row = mysql_fetch_array($criteriaSet)) {
					
						$criteriaID = $row['criteria_id'];
						$criteriaType = $row['criteria_type'];
						
						if ( $criteriaType == 'title' ) {
							$titleText = getTextEmail($criteriaID);
							$gradeAnswers .= '<h1 style="font-size:20px;font-weight:bold;">' . $titleText . '</h1>';
							$criteriaOrder++;
						}
						else if ( $criteriaType == 'plaintext' ) {
								$plaintextText = getTextEmail($criteriaID);	
								$gradeAnswers .= '<p style="font-size:14px;font-style:italic;margin:20px 0;">' . $plaintextText . '<p>';
								$criteriaOrder++;	
							}
							else if ( $criteriaType == 'radio') {
									$radioText = getGradedRadioEmail($criteriaID, $gradeID);
									$gradeAnswers .= '<div style="margin:20px auto;">' . $radioText . '</div>';
									$radioTextOrder++;
									$criteriaOrder++;
								}
								else if ( $criteriaType == 'textbox') {
										$textboxText = getGradedTextboxEmail($criteriaID, $gradeID);
										$gradeAnswers .= '<div style="margin:20px auto;">' . $textboxText . '</div>';
										$radioTextOrder++;
										$criteriaOrder++;					
									}
									else echo "Error: One of this rubric's criteria is invalid. Contact admin for help.";
					}

					return $gradeAnswers;
				}
				else echo "Error: There is no criteria in this grade's rubric. Contact admin for help.";				
			}
			else "Error: There is either no rubric, or multiple rubrics, with this ID for this grade. Contact admin for help.";
		}
	}
	else "Error: There is either no grade, or multiple grades, with this ID. Contact admin for help.";
	
}

/**
* Returns title or plaintext for emailing feedback
* @param $id
*/
function getTextEmail($id) {
	$criteriaID = $id;
	$criteriaRecord = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_ID = '$criteriaID'") or die('Error: Cannot get Title criteria wanted. Contact admin for help: ' . mysql_error());
	$count = mysql_num_rows($criteriaRecord);
	if ( $count == 1 ) {
		while ( $row = mysql_fetch_array($criteriaRecord)) {
			$criteriaContent = $row['criteria_content'];
			$textEmail = $criteriaContent;
		}
		return $textEmail;
	}
	else return "Error: Multiple, or no, criteria with this ID exist. Contact admin for help.";
}


/**
* Ruturns rubric criteria answers of type "radio" for emailing feedback
*/
function getGradedRadioEmail($id, $grade) {
	$criteriaID = $id;
	$gradeID = $grade;
	$textboxEmail = "";
	
	$criteriaRecord = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_ID = '$criteriaID'") or die('Error: Cannot get Radio criteria wanted. Contact admin for help: ' . mysql_error());
	$criteriaCount = mysql_num_rows($criteriaRecord);
	
	if ( $criteriaCount == 1 ) {
		
		while ( $row = mysql_fetch_array($criteriaRecord)) {
		
			$radioEmail .= '<span style="font-weight:bold;">' . $row['criteria_content'] . '</span>: ';
			
			$gradeValue = mysql_query("SELECT * FROM rubric_grade_answers WHERE answer_criteria_id = '$criteriaID' AND answer_grade_id = '$gradeID' AND is_textbox = '0' AND is_comment='0'");	
			$gradeValueCount = mysql_num_rows($gradeValue);
			
			$gradeValueComment = mysql_query("SELECT * FROM rubric_grade_answers WHERE answer_criteria_id = '$criteriaID' AND answer_grade_id='$gradeID' AND is_textbox = '0' AND is_comment = '1'");
			$gradeValueCommentCount = mysql_num_rows($gradeValueComment);
					
			if ( $gradeValueCount == 0 ) {
				// do nothing
			}
			else {
				while ( $gradeValueRow = mysql_fetch_array($gradeValue) ) {
					$radioAnswerID = $gradeValueRow['answer_value'];
					
					$answerValue = mysql_query("SELECT * FROM rubric_criteria_values WHERE value_id = '$radioAnswerID';");	
					$answerValueCount = mysql_num_rows($answerValue);
					
					if ( $answerValueCount == 0 ) {
						// do nothing
					}
					else {
						while ( $answerValueRow = mysql_fetch_array($answerValue) ) {
							$answerLabel = $answerValueRow['value_content'];
							$answerPoints = $answerValueRow['value_points'];
							
							$radioEmail .= ' ' . $answerLabel . ', [' . $answerPoints . ' points]';
						}
					}					
				}
			}
			
			if ( $gradeValueCommentCount == 0 ) {
				// do nothing
			}
			else {
				while ( $gradeValueCommentRow = mysql_fetch_array($gradeValueComment) ) {
					$answerCommentContent = $gradeValueCommentRow['answer_value'];
					$radioEmail .= '<br /><span style="font-weight:bold;">Grader\'s Comments:</span> ' . $answerCommentContent;
				}
			}
		}
		return $radioEmail;
	}
	else return "Error: Multiple, or no, criteria with this ID exist. Contact admin for help.";
}


/** 
* Returns rubric criteria answers of type "textbox" for emailing feedback
* @param $id
* @param $order
*/

function getGradedTextboxEmail($id, $grade) {
	$criteriaID = $id;
	$gradeID = $grade;
	$textboxEmail = "";
	
	$criteriaRecord = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_ID = '$criteriaID'") or die('Error: Cannot get Textbox criteria wanted. Contact admin for help: ' . mysql_error());
	$criteriaCount = mysql_num_rows($criteriaRecord);
	
	if ( $criteriaCount == 1 ) {
		
		while ( $row = mysql_fetch_array($criteriaRecord)) {
		
			$textboxEmail .= '<span style="font-weight:bold;">' . $row['criteria_content'] . '</span>: ';
			
			$gradeValue = mysql_query("SELECT * FROM rubric_grade_answers WHERE answer_criteria_id = '$criteriaID' AND answer_grade_id = '$gradeID' AND is_textbox = '1'");	
			$gradeValueCount = mysql_num_rows($gradeValue);
			
			if ( $gradeValueCount == 0 ) {
				// do nothing
			}
			else {
				while ( $gradeValueRow = mysql_fetch_array($gradeValue) ) {
					$textboxEmail .= $gradeValueRow['answer_value'];
				}
			}
		}
		
		return $textboxEmail;
	}
	else return "Error: Multiple, or no, criteria with this ID exist. Contact admin for help.";
}

?>