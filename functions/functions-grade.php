<?php 
/**
*	Rubric-Feedback Generator - Functions: Grade
*		1. Saves Grade to the database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

/**
* Saves Grade to the database
* @param $student - email address of student this grade is for
* @param $rubricID - id of rubric used to create this grade
* @param $assignment - assignment this is a grade of
*/
function saveGradeToDatabase( $student, $rubricID, $assignment ) {
	mysql_query("INSERT INTO rubric_grade (grade_student, grade_rubric_id, grade_assignment_id) VALUES ('$student', '$rubricID', '$assignment')") or die('There was an error saving: ' . mysql_error());
}

/**
* Returns content of grade email
* @param $gradeID - id of grade being emailed
* @param $userNicename - nicename of user that created this grade
* @param $assignmentTitle - title of assignment this is a grade of
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
				<div style="margin:20px 0;padding: 10px;border:1px solid #ddd;">' 
				
				. $gradeContent . '
			
				<p><hr /></p>  
				
				<p><span style="font-weight:bold;">Your Grade:</span> ' . $gradePoints . ' (out of ' . $possiblePoints . ' possible points)</p>
				
				<p><hr /></p>
				
				</div> 
				 
				<p>Respond to this email if you have any questions.</p> <p>--</p>
				<p>' . $userNicename . '<br /><em>Sent via Rubric-Feedback Generator</em></p>';
	}
	else {
		echo "Error - multiple grades with this ID exists. Contact admin for help.";
	}
}


/**
* Calculates and returns the total points of a grade
* @param $gradeID - id of grade having total calculated
*/
function calculateGradeTotal( $gradeID ) {
	$gradeTotal = 0;
	
	// get answers from a grade to get points
	$answers = mysql_query("SELECT * FROM rubric_grade_answer WHERE answer_grade_id = '$gradeID' AND answer_is_comment = '0' AND answer_is_textbox = '0';");
	$answersCount = mysql_num_rows($answers);
	
	if ( $answersCount > 0 ) {
	
		while ( $answersRow = mysql_fetch_array($answers) ) {
			$answerID = $answersRow['answer_value'];
			$answerValues = mysql_query("SELECT * FROM rubric_criteria_option WHERE option_id = '$answerID' AND option_is_live = '1'");
			$answerValuesCount = mysql_num_rows($answerValues);
			
			if ( $answerValuesCount == 1 ) {
				
				while ( $valuesRow = mysql_fetch_array($answerValues) ) {
					
					$value = $valuesRow['option_points'];
					
					// only add value grades if criteria is live in rubric
					$answerCriteriaID = $valuesRow['option_criteria_id'];
					$answerCriteria = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_id = '$answerCriteriaID'");
					$answerCriteriaCount = mysql_num_rows($answerCriteria);
					if ( $answerCriteriaCount == 1 ) {
						while ( $answerCriteriaRow = mysql_fetch_array($answerCriteria) ) {
							$answerCriteriaLive = $answerCriteriaRow['criteria_is_live'];
			
							if ( $answerCriteriaLive == 1 ) {
								$gradeTotal += $value;
							}
						}
					}
					else return "Error: Multiple criteria with this ID. Contact admin for help.";	
				}
			}
			else return "Error: Multiple values exist with this ID. Contact admin for help.";
		}
	
	}
	else $gradeTotal = 0;
	return $gradeTotal;
}

/** 
* Returns grade's answer content to be emailed
* @param $gradeID - id of grade having content returned
*/
function printGradeAnswers($gradeID) {

	// get grade info
	$gradeAnswers = "";
	$gradeSet = mysql_query("SELECT * FROM rubric_grade WHERE grade_id = '$gradeID';");
	$gradeCount = mysql_num_rows($gradeSet);
	
	if ( $gradeCount == 1 ) {
		
		while ( $gradeRow = mysql_fetch_array($gradeSet)) {
			// get rubric info to output as grade
			$rubricID = $gradeRow['grade_rubric_id'];
			$rubricSet = mysql_query("SELECT * FROM rubric_form WHERE rubric_id = '$rubricID';");
			$rubricCount = mysql_num_rows($rubricSet);
			
			if ( $rubricCount == 1 ) {
						
				$criteriaSet = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_rubric_id = '$rubricID' AND criteria_is_live = '1' ORDER BY criteria_order;")  or die('Error: Cannot get criteria from this rubric. Contact admin for help: ' . mysql_error());
				$criteriaCount = mysql_num_rows($criteriaSet);
				$criteriaOrder = 1;
				$radioTextOrder = 1;
				
				if ( $criteriaCount != 0 ) {
					
					while ( $row = mysql_fetch_array($criteriaSet)) {
						
						// get criteria info for various criteria
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
									$gradeAnswers .= '<div style="margin:20px auto;padding:10px;border:1px solid #ddd;background:#efefef;">' . $radioText . '</div>';
									$radioTextOrder++;
									$criteriaOrder++;
								}
								else if ( $criteriaType == 'textbox') {
										$textboxText = getGradedTextboxEmail($criteriaID, $gradeID);
										$gradeAnswers .= '<div style="margin:20px auto;padding:10px;border:1px solid #ddd;background:#efefef;">' . $textboxText . '</div>';
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
* @param $id - id of rubric criteria to return
*/
function getTextEmail($id) {
	$criteriaID = $id;
	$criteriaRecord = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_ID = '$criteriaID'") or die('Error: Cannot get Title criteria wanted. Contact admin for help: ' . mysql_error());
	$count = mysql_num_rows($criteriaRecord);
	if ( $count == 1 ) {
		while ( $row = mysql_fetch_array($criteriaRecord)) {
			$criteriaContent = stripslashes($row['criteria_content']);
			$textEmail = $criteriaContent;
		}
		return $textEmail;
	}
	else return "Error: Multiple, or no, criteria with this ID exist. Contact admin for help.";
}


/**
* Returns rubric criteria answers of type "radio" for emailing feedback
* @param $id - id of rubric radio criteria
* @param $grade - id of grade for this rubric
*/
function getGradedRadioEmail($id, $grade) {
	$criteriaID = $id;
	$gradeID = $grade;
	$textboxEmail = "";
	
	// get criteria info
	$criteriaRecord = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_ID = '$criteriaID'") or die('Error: Cannot get Radio criteria wanted. Contact admin for help: ' . mysql_error());
	$criteriaCount = mysql_num_rows($criteriaRecord);
	
	if ( $criteriaCount == 1 ) {
		
		while ( $row = mysql_fetch_array($criteriaRecord)) {
		
			// output grade content
			$radioEmail .= '<span style="font-weight:bold;">' . stripslashes($row['criteria_content']) . '</span>: ';
			
			$gradeValue = mysql_query("SELECT * FROM rubric_grade_answer WHERE answer_criteria_id = '$criteriaID' AND answer_grade_id = '$gradeID' AND answer_is_textbox = '0' AND answer_is_comment='0'");	
			$gradeValueCount = mysql_num_rows($gradeValue);
			
			$gradeValueComment = mysql_query("SELECT * FROM rubric_grade_answer WHERE answer_criteria_id = '$criteriaID' AND answer_grade_id='$gradeID' AND answer_is_textbox = '0' AND answer_is_comment = '1'");
			$gradeValueCommentCount = mysql_num_rows($gradeValueComment);
					
			if ( $gradeValueCount == 0 ) {
				// do nothing
			}
			else {
				while ( $gradeValueRow = mysql_fetch_array($gradeValue) ) {
					$radioAnswerID = $gradeValueRow['answer_value'];
					
					$answerValue = mysql_query("SELECT * FROM rubric_criteria_option WHERE option_id = '$radioAnswerID';");	
					$answerValueCount = mysql_num_rows($answerValue);
					
					if ( $answerValueCount == 0 ) {
						// do nothing
					}
					else {
						while ( $answerValueRow = mysql_fetch_array($answerValue) ) {
							$answerLabel = stripslashes($answerValueRow['option_content']);
							$answerPoints = $answerValueRow['option_points'];
							
							$radioEmail .= ' ' . $answerLabel . ' [' . $answerPoints . ' points]';
						}
					}					
				}
			}
			
			if ( $gradeValueCommentCount == 0 ) {
				// do nothing
			}
			else {
				while ( $gradeValueCommentRow = mysql_fetch_array($gradeValueComment) ) {
					$answerCommentContent = stripslashes($gradeValueCommentRow['answer_value']);
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
* @param $id - id of rubric textbox criteria
* @param $grade - id of grade for this rubric
*/

function getGradedTextboxEmail($id, $grade) {
	$criteriaID = $id;
	$gradeID = $grade;
	$textboxEmail = "";
	
	$criteriaRecord = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_ID = '$criteriaID'") or die('Error: Cannot get Textbox criteria wanted. Contact admin for help: ' . mysql_error());
	$criteriaCount = mysql_num_rows($criteriaRecord);
	
	if ( $criteriaCount == 1 ) {
		
		while ( $row = mysql_fetch_array($criteriaRecord)) {
		
			$textboxEmail .= '<span style="font-weight:bold;">' . stripslashes($row['criteria_content']) . '</span>: ';
			
			$gradeValue = mysql_query("SELECT * FROM rubric_grade_answer WHERE answer_criteria_id = '$criteriaID' AND answer_grade_id = '$gradeID' AND answer_is_textbox = '1'");	
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

/** 
* Deletes given grade from the database
* @param $id - id of grade to be deleted
*/

function deleteGrade($id) {
	// remove grade from database
	mysql_query("DELETE FROM rubric_grade WHERE grade_id = '$id'") or die();	
	
	// remove graded answers from database
	mysql_query("DELETE FROM rubric_grade_answer WHERE answer_grade_id = '$id'") or die();	
}


?>