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
	* User Admin Scripts
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
	
	// Determine whether user wants to edit rubric or complete rubric based on submit
	$("#complete-rubric").click( function(){
		$("#form-rubric").attr("action", "/rubric-complete.php").submit();
	});
	$("#edit-rubric").click( function(){
		$("#form-rubric").attr("action", "/rubric-edit.php").submit();
	});
	
	// Determine whether user wants to edit grade or email grade based on submit
	$("#edit-grade").click( function(){
		$("#form-grade").attr("action", "/grade-edit.php").submit();
	});
	$("#email-grade").click( function(){
		$("#form-grade").attr("action", "/grade-email.php").submit();
	});

	
	/**
	* Edit Rubric Scripts
	*/
	var editInputCount = 1;
	
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
	
	// Change radio criteria value is_live on click of "delete" button, and undo delete
	$("div.button.delete-value").click(function(){ 
		
		var $thisButton = $(this);
			
		//if button value = Delete this Option, then change is_live to 0 and value to "undo delete"
		if ( $thisButton.text() == "Delete this Option") {
			$thisButton.text("Undo delete");
			$thisButton.parent("li").children("input.is-live").val("0");
			$thisButton.parent("li").addClass("deleted");
		}
		//else change is_live to 1 and value to "Delete this Option"
		else {
			$thisButton.text("Delete this Option");
			$thisButton.parent("li").children('input.is-live').val("1");
			$thisButton.parent("li").removeClass("deleted");
		}
	});
	
	// Add title object to rubric when editing rubric form
	$("#add-title").click(function(){ 
		$('#form-edit fieldset').last()
			.after('<fieldset class="edit title ' + editInputCount + '">Order: <input type="text" name="order-' + editInputCount + '" class="order" /><br />Title Content: <input type="text" name="new-' + editInputCount + '" class="content title" /><div class="button new-delete">Delete</div><input type="hidden" name="live-new-' + editInputCount + '" class="is-live" value="1" /></fieldset>');
			editInputCount++;
	});	
	
	
	// Add plaintext object to rubric when editing rubric form
	$("#add-plaintext").click(function(){ 
		$('#form-edit fieldset').last()
			.after('<fieldset class="edit text ' + editInputCount + '">Order: <input type="text" name="order-' + editInputCount + '" class="order" /><br />Plaintext Content: <input type="text" name="new-' + editInputCount + '" class="content text" /><div class="button new-delete">Delete</div><input type="hidden" name="live-new-' + editInputCount + '" class="is-live" value="1" /></fieldset>');
			editInputCount++;
	});	
	
	// Add textbox object to rubric when editing rubric form
	$("#add-textbox").click(function(){ 
		$('#form-edit fieldset').last()
			.after('<fieldset class="edit textbox ' + editInputCount + '">Order: <input type="text" name="order-' + editInputCount + '" class="order" /><br />Textbox Label: <input type="text" name="new-' + editInputCount + '" class="content textbox" /><div class="button new-delete">Delete</div><input type="hidden" name="live-new-' + editInputCount + '" class="is-live" value="1" /></fieldset>');
			editInputCount++;
	});	
	
	// Add radio object to rubric when editing rubric form
	$("#add-radio").click(function(){ 
		$('#form-edit fieldset').last()
			.after('<fieldset class="edit radio ' + editInputCount + '">Order: <input type="text" name="order-' + editInputCount + '" class="order" /><br />Radio Label: <input type="text" name="new-' + editInputCount + '" class="content textbox" /><p>Options:</p><ul class="radio-options"><li>Option Order: <input type="text" name="new-valueChron-' + editInputCount + '" class="value-order" /><br />Option Label: <input type="text" name="new-valueLabel-' + editInputCount + '" class="value-label" /><br />Option Points: <input type="text" name="new-valuePoints-' + editInputCount + '" class="value-points" /><br /><div class="button delete-value">Delete this Option</div><input type="hidden" name="new-valOn-' + editInputCount + '" class="is-live" value="1" /></li></ul><div class="button add-value">Add Option</div><div class="button new-delete">Delete</div><input type="hidden" name="live-new-' + editInputCount + '" class="is-live" value="1" /></fieldset>');
			editInputCount++;
	});
	
	// Add live click event to delete buttons of newly created rubric objects
	$(".button.new-delete").live("click", function(){
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

	// Add live click event to add value buttons of newly created rubric objects
	$(".button.add-value").live("click", function(){
		$(this).siblings("ul").append('<li>Option Order: <input type="text" name="new-valueChron-' + editInputCount + '" class="value-order" /><br />Option Label: <input type="text" name="new-valueLabel-' + editInputCount + '" class="value-label" /><br />Option Points: <input type="text" name="new-valuePoints-' + editInputCount + '" class="value-points" /><br /><div class="button delete-value">Delete this Option</div><input type="hidden" name="new-valOn-' + editInputCount + '" class="is-live" value="1" /></li>');
  		
  	});
  	
  	// Add live click event to delete buttons of newly created radio values
  	$(".button .delete-value").live("click", function(){
  	
		var $thisButton = $(this);
			
		//if button value = Delete this Option, then change is_live to 0 and value to "undo delete"
		if ( $thisButton.text() == "Delete this Option") {
			$thisButton.text("Undo delete");
			$thisButton.parent("li").children("input.is-live").val("0");
			$thisButton.parent("li").addClass("deleted");
		}
		//else change is_live to 1 and value to "Delete this Option"
		else {
			$thisButton.text("Delete this Option");
			$thisButton.parent("li").children('input.is-live').val("1");
			$thisButton.parent("li").removeClass("deleted");
		}
		
  	
  	});

});