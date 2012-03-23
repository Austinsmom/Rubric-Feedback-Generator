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
		}

		$gradePoints = calculateGradeTotal($gradeID);
		
		$gradeContent = printGradeAnswers($gradeID);

		/*	echo '<p><span style="font-weight:bold;font-size:13px;"> ** Criteria Title **</span></p>
				
				<p><span style="font-weight:normal;font-size:12px;font-style:italic;"> ** Criteria Plaintext **</span></p>
				
				<p> Criteria: ** Criteria Radio - Label **<br />
					Feedback: ** Criteria Radio Value Graded - Label ** ( ** Value Graded Points ** points )<br />
					Comments: ** Criteria Radio Value Comments **</p>
					
				<p> ** Criteria Textbox - Label ** : ** Criteria Textbox Value Text ** </p>';*/


		// echo content of the email
		return '<p>The following is my feedback and your grade on the assignment<br />
			<strong>"' . $assignmentTitle . '"</strong>:
			
			<div style="margin:10px 0;">' . $gradeContent . '</div>
			
			<p><span style="font-weight:bold;">Total Points:</span> ' . $gradePoints . '</p>
			
			<p>Respond to this email if you have any questions.</p> <p>--</p>
			<p>' . $userNicename . '<br /><em>Sent via Rubric Creator 9000XL Premium</em></p>';
		
	}
	else {
		echo "Error - multiple grades with this ID exists. Contact admin for help.";
	}
}

/**
* Calculates the total points of a grade
* @param $gradeID
*/
function calculateGradeTotal( $gradeID ) {
	return "1,000,000";
}

/** 
* Returns grade's answer content
* @param $gradeID
*/

function printGradeAnswers( $gradeID ) {
	return "This is your answer: nope!";
	
/*	$rubricID = $id;
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
*/
}


?>