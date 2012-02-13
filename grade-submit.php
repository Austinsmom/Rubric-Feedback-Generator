<?php 
/**
*	Rubric Creator - Grade Submit
*	 1. Tells user to verify grade
*	 2. Saves grade to database
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); 

?>

<body id="grade">

		<form id="form-output-save" name="form-output-save" action="grade-save.php" method="post">
									
			<div id="grade-post">
			<?php 
				$gradeTotal = 0;
				$inputCount = 1; 
				$gradeContent = "";
				$gradeRubric = $_POST['rubric-id'];
				$gradeAssignment = $_POST['rubric-assignment'];
				
				while( list( $field, $value ) = each( $_POST )) {
					 $gradeContent .= $field . ' ::: ' . htmlspecialchars($value) . '///';
					 
					if ( ($field != 'student' || $field != '' || $field != '') && is_numeric($value) ) {
					 	$gradeTotal += $value;
					} else if ( $field == 'student' ) {
								$gradeStudent = $value;
							}
				}			

				$gradePrint .= '<p>Grade Total: ' . $gradeTotal . '</p>';
				echo $gradeContent;
			?>
			</div>
			
			<input type="hidden" value="<?php echo $gradeStudent; ?>" name="grade-student" />
			<input type="hidden" value="<?php echo $gradeRubric; ?>" name="grade-rubric-id" />
			<input type="hidden" value="<?php echo $gradeAssignment; ?>" name="grade-assignment" />
			<input type="hidden" value="<?php echo $gradeContent; ?>" name="grade-content" />
			<input type="hidden" value="<?php echo $gradeTotal; ?>" name="grade-points" />
			
			<div id="form-save">
				<input class="save button" type="submit" value="save to database" />
			</div>
		
		</form>	

<?php require('includes/footer.php'); ?>