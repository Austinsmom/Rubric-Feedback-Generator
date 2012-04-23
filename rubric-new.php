<?php 
/**
*	Rubric-Feedback Generator - Create New Rubric
*	1. Gives options for user to create a new rubric
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); ?>

<body id="delimited">

	<div id="title-box">
		<h1>Rubric-Feedback Generator</h1>
		<h2>Create New Rubric</h2>
	</div>

	<ul>
		<li><a href="rubric-delimited-new.php">Click here to import new rubric.</a></li>
	</ul>
	
	<?php // blank slate form to create new rubric ?>
	
	<form id="form-edit" name="form-edit" method="post">
	
		<fieldset>
			<p>
				<label for="form-title">Rubric Title:</label>
				<input id="rubric-title" type="text" name="form-title" />
			</p>
			
			<p>
				<label for="form-description">Rubric Description:</label>
				<textarea id="rubric-description" name="form-description"></textarea>
			</p>
			
		</fieldset>
		
		<div id="add-items-panel">
			<input type="submit" id="add-title" class="button add" value="Add Title" />
			<input type="submit" id="add-plaintext" class="button add" value="Add Plaintext" /><br />
			<input type="submit" id="add-textbox" class="button add" value="Add Textbox Criteria" />
			<input type="submit" id="add-radio" class="button add" value="Add Radio Criteria" />
		</div>
		
		<input id="submit-form-new" type="submit" value="Create New Rubric" />
	
	</form>

<?php require('includes/footer.php'); ?>