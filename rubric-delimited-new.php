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

<form id="form-delimited" name="form-delimited" action="rubric-delimited-verify.php" method="post">
	<label for="deliminited-text">Enter your tab-delimited content here:</label>
	<textarea name="delimited-text"></textarea>
	<input type="submit" value="submit" />
</form>

<?php require('includes/footer.php'); ?>