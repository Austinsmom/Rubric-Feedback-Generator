<?php 
/**
*	Rubric Creator - Create Class
*	1. allows user to create a class
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

if(!isset($_COOKIE["user"])){
	header("Location: index.php");
} else { $username = $_COOKIE["user"]; }

require('includes/header.php'); ?>

<body id="assignment">

<h1>Rubric Creator - Create New Class</h1>

<p>In the following form, enter the information about the class you're assigning assignments to:</p>

<form id="form-class" name="form-class" action="class-save.php" method="post">
	
	<p>
	<label for="">Class Section (ex. CMPT109-02):</label>
	<input type="text" name="class-title" />
	</p>
	
	<p>
	<label for="">Semester and Year (ex. Spring 2012):</label>
	<input type="text" name="class-time" />
	</p>
	
	<p>
	<label for="">Notes:</label>
	<textarea name="class-notes"></textarea>
	</p>
	
	<input type="submit" value="submit" />
</form>

<?php require('includes/footer.php'); ?>