<?php 
/**
*	Rubric-Feedback Generator - Create New Rubric
*	1. Gives options for user to create a new rubric
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric-Feedback Generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); ?>

<body id="delimited">

<h1>Create New Rubric</h1>


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
		<input id="add-title" class="button" value="Add Title" />
		<input id="add-plaintext" class="button" value="Add Plaintext" /><br />
		<input id="add-textbox" class="button" value="Add Textbox Criteria" />
		<input id="add-radio" class="button" value="Add Radio Criteria" />
	</div>
	
	<input id="submit-form-new" type="submit" value="Create New Rubric" />

</form>

<?php require('includes/footer.php'); ?>