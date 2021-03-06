<?php 
/**
*	Rubric-Feedback Generator - Create Class
*	1. allows user to create a class
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); ?>

<body id="assignment">

	<div id="title-box">
		<h1>Rubric-Feedback Generator</h1>
		<h2>Create New Class</h2>
	</div>

	<p>In the following form, enter the information about the class you're assigning assignments to:</p>
	
	<form id="form-class" name="form-class" method="post">
		
		<p>
		<label for="">* Class Title (ex. CMPT109-02):</label>
		<input type="text" name="class-title" class="text" id="class-title" />
		</p>
		
		<p>
		<label for="">* Semester and Year (ex. Spring 2012):</label>
		<input type="text" name="class-time" class="text" id="class-time" />
		</p>
		
		<p>
		<label for="">Notes:</label>
		<textarea name="class-notes" class="textarea" id="class-notes"></textarea>
		</p>
		
		<input type="submit" value="Save New Class" id="new-class" />
	</form>

<?php require('includes/footer.php'); ?>