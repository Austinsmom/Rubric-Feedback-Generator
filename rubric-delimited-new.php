<?php 
/**
*	Rubric-Feedback Generator - Create New Rubric
*	1. allows the user to paste their tab-delimited text and submit for form generation
*	TO DO: help docs link
*	TO DO: allow user to upload a csv file
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
		<h2>Import Rubric</h2>
	</div>

	<p>In the following form, paste the tab-delimited content needed to generate your rubric content.</p>
	
	<form id="form-delimited" name="form-delimited" method="post">
		
		<label for="delimited-text">Enter your tab-delimited content here:</label>
		<em>Clicking the [tab] key will enter a tab in this textarea. To leave this textarea via keyboard shortcut, click [ctrl] key.</em>
		<textarea id="delimited-text" name="delimited-text"></textarea>
		
		<input id="submit-form-delimited" type="submit" value="Submit" />
	</form>

<?php require('includes/footer.php'); ?>