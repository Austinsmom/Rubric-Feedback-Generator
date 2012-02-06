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
						
				<?php /* echo '<pre>';
					  print_r($_POST);
					  echo '</pre>'; */
				?>
			
			<div id="grade-post">
			<?php 
				$gradeTotal = 0; 
				$gradeContent = "";
				
				while( list( $field, $value ) = each( $_POST )) {
					
					 $field = str_replace("__", ". ", $field);
					 $field = str_replace("_", " ", $field);
					 $fieldIsComment = strpos($field,'comment-');
				
					 if ($field == "title") {
					 	$gradeContent .= '<h1>' . $value . '</h1>';
					 }
					 else if ($field == "plaintext") {
					 		 $gradeContent .= '<p>' . $value . '</p>';
					 	  }
					 	  else if ( $fieldIsComment === 0 ){
					 	  		  $gradeContent .= "<p>" . "Comments: " . $value . "</p> <hr />";
					 	  		}
					 	  		else {
					 	  			$gradeContent .= "<p>" . $field . ": " . $value . "</p>";
					 	  			
					 	  			if ( is_numeric($value) ) {
					 	  				$gradeTotal = $gradeTotal + $value;
					 	  			}
					 	  			
					 	  			if ( $field == "student" ) {
					 	  				$gradeStudent = $value;
					 	  			}
					 	 		}
				}
				
				$gradeContent .= '<p>Grade Total: ' . $gradeTotal . '</p>';
				echo $gradeContent;
			?>
			</div>
			
			<input type="hidden" value="<?php echo $gradeStudent; ?>" name="grade-student" />
			<input type="hidden" value="Untitled Assignment" name="grade-assignment" />
			<input type="hidden" value="<?php echo $gradeContent; ?>" name="grade-content" />
			<input type="hidden" value="<?php echo $gradeTotal; ?>" name="grade-points" />
			
			<div id="form-save">
				<input class="save button" type="submit" value="save to database" />
			</div>
		
		</form>	

<?php require('includes/footer.php'); ?>