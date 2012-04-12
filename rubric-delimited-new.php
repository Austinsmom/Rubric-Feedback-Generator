<?php 
/**
*	Rubric Creator - Create New Rubric
*	1. allows the user to paste their tab-delimited text and submit for form generation
*	TO DO: help docs link
*	TO DO: allow user to upload a csv file
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); ?>

<body id="delimited">

<h1>Rubric Creator - Create New Rubric</h1>

<p>In the following form, paste the tab-delimited content needed to generate your rubric content.</p>

<form id="form-delimited" name="form-delimited" method="post">
	
	<label for="delimited-text">Enter your tab-delimited content here:</label>
	<textarea id="delimited-text" name="delimited-text"></textarea>
	
	<input id="submit-form-delimited" type="submit" value="submit" />
</form>

<?php require('includes/footer.php'); ?>