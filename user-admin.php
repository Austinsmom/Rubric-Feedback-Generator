<?php 
/**
*	Rubric Creator - User Admin
*	 Admin page
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); ?>

<body id="admin">
	
	<h1>User Admin: <em>Welcome, <?php echo $_COOKIE["user"]; ?>!</em></h1>
	
	<ol>
		<li><a href="class-new.php">create a new class.</a></li>
	
		<li><a href="assignment-new.php">create a new assignment.</a></li>
	
		<li><a href="rubric-new.php">create a new rubric.</a></li>	
	</ol>
	

	<h2>Your classes</h2>
			
	<?php
		$sqlClass = "SELECT * FROM rubric_class WHERE class_author='$username'";
		$resultClass = mysql_query($sqlClass);
		$count = mysql_num_rows($resultClass);
			
		if ($count != 0) { ?>
			
			<form id="form-class-list" name="form-class-list" action="class-edit.php" method="post">
			 <fieldset>
				
				<?php 
					while ( $row = mysql_fetch_array($resultClass)) {
					/* go through each rubric record and print a list to choose from */
					$id = $row['class_id'];
					$title = $row['class_title'];
					$meeting = $row['class_meetingtime'];
					$notes = $row['class_notes'];
				
					echo '<input type="radio" name="class-choice" id="class-'. 
							$id . '" value="' .$id. '"> ' . $title .' <em>' . $meeting . '</em> <div class="description">'. $notes .'</div>';
					}
				?>
			 </fieldset>	
			
			 <input type="hidden" name="form-origin" value="class-list" />
			 <!-- <input type="submit" value="edit class" /> -->
			</form>		
	<?php } else { ?>
	
			<p>You have no classes yet. <a href="class-new.php">Create one!</a></p>
	
			<?php } ?>	 
	 
	 
	 <h2>Your assignments</h2>
	 
	 	<?php
		$sqlAssignment = "SELECT * FROM rubric_assignment WHERE assignment_author='$username'";
		$resultAssignment = mysql_query($sqlAssignment);
		$count = mysql_num_rows($resultAssignment);
			
		if ($count != 0) { ?>
			
			<form id="form-assignment-list" name="form-assignment-list" action="assignment-edit.php" method="post">
			 <fieldset>
				
				<?php 
				
					while ( $row = mysql_fetch_array($resultAssignment)) {
					/* go through each assignment record and print a list to choose from */
					$id = $row['assignment_id'];
					$title = $row['assignment_title'];
					$description = $row['assignment_description'];
					$class = $row['assignment_class_id'];
					$dueDate = $row['assignment_duedate'];
					$points = $row['assignment_points'];
				
					echo '<input type="radio" name="assignment-choice" id="assignment-'. 
							$id . '" value="' .$id. '"> ' . $title .' <em>Due ' . $dueDate . ' for Class: ' . $class . '</em><div class="description">'. $description .'<p class="totalPoints">Total Points: ' . $points . '</p></div>';
					}
				?>
			 </fieldset>	
			
			 <input type="hidden" name="form-origin" value="assignment-list" />
			 <!-- <input type="submit" value="edit assignment" /> -->
			</form>		
	<?php } else { ?>
	
			<p>You have no assignments yet. <a href="assignment-new.php">Create one!</a></p>
	
		<?php } ?>
	 
	 
	 
	 <h2>Your rubrics (<a href="rubric-edit.php">Click here to edit rubrics</a>)</h2>
	 
	 	<?php
		$sqlRubric = "SELECT * FROM rubric_form WHERE rubric_author='$username'";
		$resultRubric = mysql_query($sqlRubric);
		$count = mysql_num_rows($resultRubric);
			
		if ($count != 0) { ?>
			
			<form id="form-rubric-list" name="form-rubric-list" action="rubric-complete.php" method="post">
			 <fieldset>
				<legend>Select a rubric to complete:</legend>
				
				<?php 
				
					while ( $row = mysql_fetch_array($resultRubric)) {
					/* go through each rubric record and print a list to choose from */
					$id = $row['rubric_id'];
					$title = $row['rubric_title'];
					$description = $row['rubric_description'];
				
					echo '<input type="radio" name="rubric-choice" id="rubric-'. 
							$id . '" value="' .$id. '"> ' . $title .'<div class="description">'. $description .'</div>';
					}
				?>
			 </fieldset>	
			
			 <input type="hidden" name="form-origin" value="rubric-list" />
			 <input type="submit" value="complete rubric" />
			</form>		
	<?php } else { ?>
	
			<p>You have no rubrics yet. <a href="rubric-new.php">Create one!</a></p>
	
		<?php } ?>
		
	
	<h2>All grades</h2>
	 
	 	<?php
		$sqlGrade = "SELECT * FROM rubric_grade";
		$resultGrade = mysql_query($sqlGrade);
		$count = mysql_num_rows($resultGrade);
			
		if ($count != 0) { ?>
			
			<form id="form-grade-list" name="form-grade-list" action="grade-edit.php" method="post">
			 <fieldset>
				
				<?php 
				
					while ( $row = mysql_fetch_array($resultGrade)) {
					/* go through each grade record and print a list to choose from */
					$id = $row['grade_id'];
					$student = $row['grade_student'];
					$rubric = $row['grade_rubric_id'];
					$assignment = $row['grade_assignment_id'];
					$content = $row['grade_content'];
					$points = $row['grade_points'];
					
					$assignmentQuery = mysql_query("SELECT assignment_title FROM rubric_assignment WHERE assignment_id = '$assignment'");
					$assignmentCount = mysql_num_rows($assignmentQuery);
					
					if ($assignmentCount != 0 ) {
						
						while ($assignmentRow = mysql_fetch_array($assignmentQuery)) {
							$assignment = $assignmentRow['assignment_title'];
							$possiblePoints = $assignmentRow['assignment_points'];
						}
						
					}
					
				
					echo '<input type="radio" name="grade-choice" id="grade-'. 
							$id . '" value="' .$id. '">
							
							<table cellpadding="5px" cellspacing="5px" border="1px" class="table-grade">
							
								<tr>
									<td class="thead">Grade ID:</td><td>' . $id . '</td>
								</tr>
								
								<tr>
									<td class="thead">Assignment:</td><td>' . $assignment . '</td>
								</tr>
								
								<tr>
									<td class="thead">Student:</td><td>' . $student . '</td>
								</tr>
								
								<tr>
									<td class="thead">Total Possible Points:</td><td>' . $possiblePoints . '</td>
								</tr>
							
							</table>
							
							<p>Feedback:</p>
							
							<table cellpadding="5px" cellspacing="5px" border="1px" class="table-feedback">';
							
							$criteriaQuery = mysql_query("SELECT * FROM rubric_grade_answers WHERE answer_grade_id = '$id'");
							$criteriaCount = mysql_num_rows($criteriaQuery);
					
							if ($criteriaCount != 0 ) {
								
								$countCriteria = 1;
								
								while ($criteriaRow = mysql_fetch_array($criteriaQuery)) {
									$criteriaID = $criteriaRow['answer_criteria_id'];
									$criteriaValue = $criteriaRow['answer_value'];
									$isComment = $criteriaRow['is_comment'];
									
									if ($isComment == 1) {
										// criteria comment
										$label = "Comment:";
										$value = stripslashes($criteriaValue);	
																			
										echo '<tr>
												<td class="thead">' . $label . '</td><td>' . $value . '</td>
											  </tr>';								
									}
									else { 
										// actual criteria
										
										$labelQuery = mysql_query("SELECT * FROM rubric_criteria WHERE criteria_id = '$criteriaID'");
										$labelCount = mysql_num_rows($labelQuery);
										if ($labelCount != 0 ) {
											while ($labelRow = mysql_fetch_array($labelQuery)) {
												$labelText = $labelRow['criteria_content'];
											}
											$label = $countCriteria . '. ' . $labelText;
										}
										
										$valueQuery = mysql_query("SELECT * FROM rubric_criteria_values WHERE value_id = '$criteriaValue'");
										$valueCount = mysql_num_rows($valueQuery);
										if ($valueCount != 0 ) {
											while ($valueRow = mysql_fetch_array($valueQuery)) {
												$valueText = $valueRow['value_content'];
												$valuePoints = $valueRow['value_points'];
											}
											$value = $valueText;
										}
																			
										echo '<tr>
												<td class="thead">' . $label . '</td><td>' . $value . '</td><td>' . $valuePoints . ' points</td>
											  </tr>';	
											  
										$countCriteria++;						
									}
								}
							}
						
							echo '</table>';
					}
				?>
			 </fieldset>	
			
			 <input type="hidden" name="form-origin" value="grade-list" />
			 <input type="submit" value="edit grade" />
			</form>		
	<?php } else { ?>
	
			<p>You have no grades yet.</p>
	
		<?php } ?>

	
	<p><a href="user-logout.php">Click here to log out.</a></p>

<?php require('includes/footer.php'); ?>