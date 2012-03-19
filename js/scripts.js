/**
*	Rubric Creator - Scripts
*	All the form-generating functions, primarily used in rubric-new-verify.php
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package Rubric Creator
*/

jQuery(document).ready(function () {

	/**
	* Global Scripts
	*/
	
	// Allows tabs to be entered in textarea elements
	$("textarea").tabby();
	
	/**
	* Class Admin Scripts
	*/
	
	// Determine whether user wants to edit class or view assignments based on submit
	$("#edit-class").click( function(){
		$("#form-classes").attr("action", "/class-edit.php").submit();
	});
	$("#view-assignments").click( function(){
		$("#form-classes").attr("action", "/class-assignments.php").submit();
	});
	
	// Determine whether user wants to edit assignment or view grades based on submit
	$("#edit-assignment").click( function(){
		$("#form-assignment").attr("action", "/assignment-edit.php").submit();
	});
	$("#view-grades").click( function(){
		$("#form-assignment").attr("action", "/assignment-grades.php").submit();
	});

	
	/**
	* Edit Rubric Scripts
	*/
	
	// Change criteria is_live on click of "delete" button, and undo delete
	$("div.button.delete").click(function(){ 
		
		var $thisButton = $(this);
			
		//if button value = delete, then change is_live to 0 and value to "undo delete"
		if ( $thisButton.text() == "Delete") {
			$thisButton.text("Undo delete");
			$thisButton.parent("fieldset").children("input.is-live").val("0");
			$thisButton.parent("fieldset").addClass("deleted");
		}
		//else change is_live to 1 and value to "delete"
		else {
			$thisButton.text("Delete");
			$thisButton.parent("fieldset").children('input.is-live').val("1");
			$thisButton.parent("fieldset").removeClass("deleted");
		}
	});
	
	// Change criteria content and order on click of "save" button
	$(".button.save").click(function(){ 
	
	
	
	});
	
});