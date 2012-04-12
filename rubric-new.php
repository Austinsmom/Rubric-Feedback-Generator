<?php 
/**
*	Rubric Creator - Create New Rubric
*	1. Gives options for user to create a new rubric
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

<p>Here is where you will <em>soon</em> be able to create rubrics from scratch.</p>

<p><a href="rubric-delimited-new.php">Click here to import new rubric.</a></p>

<?php require('includes/footer.php'); ?>