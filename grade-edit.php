<?php 
/**
*	Rubric Creator - Grade Edit
*	 1. Repopulates Rubric from Grade content field content
*	 2. Allows user to submit to save grade
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

	<h1>Grade Edit</h1>
	
	<?php  
  		$gradeID = $_POST['grade-choice'];
		$sql = "SELECT * FROM rubric_grade WHERE grade_id='$gradeID'";
		$result = mysql_query($sql);
		$count = mysql_num_rows($result);

		if ($count != 0) { ?>
			
			<form id="form-grade-list" name="form-grade-list" action="grade-edit.php" method="post">
			 <fieldset>
				
				<?php 
				
					while ( $row = mysql_fetch_array($result)) { 
						gradeToPost($row['grade_content']);
					}
			
				?>
				
			 </fieldset>
		
	<?php }
		else { echo 'Error - No Grade with this ID!'; } ?>


<?php require('includes/footer.php'); ?>