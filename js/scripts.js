/**
*	Rubric Creator - Scripts
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
	
	// Always have a form's first radio button selected by default
	$("fieldset").each(function() {
		$(this).children("input:first").attr('checked', true);
	});
	
	/**
	* Login & Registration
	*/
	
	// validate login
	$("#user-login").click( function(){
		
		// first remove any already existing warning and validation markers
		$("input").removeClass('empty-input');
		$("#submit-warning").remove();
		
		var validInput = true;
		
		// if username is blank, warn user
		if ( $("#username").val().length == 0) {
     		 $("#username").addClass('empty-input');
     		 validInput = false;
		}
		
		// if password is blank, warn user
		if ($("#password").val().length == 0) {
			$("#password").addClass('empty-input');
			validInput = false;
		}
		
		// show warning if validInput == false, else submit
		if ( validInput == false ) {
			$(this).parent("form").append('<span id="submit-warning">Do not leave any fields blank!</span>');
			return validInput
		}
		else {
			$("#form-login").attr("action", "user-validate.php").submit();
		}
	});
	
	// register submit
	$("#user-register").click( function(){
				
		// first remove any already existing warning and validation markers
		$("input").removeClass('empty-input');
		$("#submit-warning").remove();
		
		var validInput = true;
		
		// if username is blank, warn user
		if ( $("#username").val().length == 0) {
     		 $("#username").addClass('empty-input');
     		 validInput = false;
		}
		
		// if password is blank, warn user
		if ($("#password").val().length == 0) {
			$("#password").addClass('empty-input');
			validInput = false;
		}
		
		// if display name is blank, warn user
		if ( $("#nicename").val().length == 0) {
     		 $("#nicename").addClass('empty-input');
     		 validInput = false;
		}
		
		// if email is blank, warn user
		if ($("#email").val().length == 0) {
			$("#email").addClass('empty-input');
			validInput = false;
		}
		
		// show warning if validInput == false, else submit
		if ( validInput == false ) {
			$(this).parent("form").append('<span id="submit-warning">Do not leave any fields blank!</span>');
			return validInput
		}
		else {
			$("#form-register").attr("action", "user-validate.php").submit();
		}

	});
	
	/**
	* User Admin Scripts
	*/
	
	// Determine whether user wants to edit class or view assignments based on submit
	$("#edit-class").click( function(){
		$("#form-classes").attr("action", "class-edit.php").submit();
	});
	$("#view-assignments").click( function(){
		$("#form-classes").attr("action", "class-assignments.php").submit();
	});
	
	// Determine whether user wants to edit assignment, grade assignment or view grades based on submit
	$("#edit-assignment").click( function(){
		$("#form-assignment").attr("action", "assignment-edit.php").submit();
	});
	$("#grade-assignment").click( function(){
		$("#form-assignment").attr("action", "grade-assignment.php").submit();
	});	
	$("#view-grades").click( function(){
		$("#form-assignment").attr("action", "assignment-grades.php").submit();
	});
	
	// Determine if user wants to edit rubric based on submit
	$("#edit-rubric").click( function(){
		$("#form-rubric").attr("action", "rubric-edit.php").submit();
	});
	
	// Determine whether user wants to edit grade or email grade based on submit
	$("#edit-grade").click( function(){
		$("#form-grade").attr("action", "grade-edit.php").submit();
	});
	$("#email-grade").click( function(){
		$("#form-grade").attr("action", "grade-email.php").submit();
	});

	
	/**
	* Edit Rubric Scripts
	*/
	
	var editInputCount = 1;
	var radioValueCount = 1;

	// returns the max value of all inputs with class="order"
	function findMaxOrder() {
		var tempMax = 0;
		$("input.order").each( function(){
				var thisInputValue = parseInt($(this).val());
				if ( thisInputValue > tempMax ) {
					tempMax = thisInputValue;
				}
		});
		return tempMax + 1;
	}
	
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
		var order = findMaxOrder();
		$('#form-edit fieldset').last()
			.after('<fieldset class="edit title ' + editInputCount + '">Order: <input type="text" name="new-order-' + editInputCount + '" class="order" value="' + order + '" /><br />Title Content: <input type="text" name="new-title-' + editInputCount + '" class="content title" /><div class="button new-delete">Delete</div><input type="hidden" name="new-live-' + editInputCount + '" class="is-live" value="1" /></fieldset>');
			editInputCount++;
	});	
	
	
	// Add plaintext object to rubric when editing rubric form
	$("#add-plaintext").click(function(){ 
		var order = findMaxOrder();
		$('#form-edit fieldset').last()
			.after('<fieldset class="edit text ' + editInputCount + '">Order: <input type="text" name="new-order-' + editInputCount + '" class="order" value="' + order + '" /><br />Text Content: <input type="text" name="new-plaintext-' + editInputCount + '" class="content text" /><div class="button new-delete">Delete</div><input type="hidden" name="new-live-' + editInputCount + '" class="is-live" value="1" /></fieldset>');
			editInputCount++;
	});	
	
	// Add textbox object to rubric when editing rubric form
	$("#add-textbox").click(function(){ 
		var order = findMaxOrder();
		$('#form-edit fieldset').last()
			.after('<fieldset class="edit textbox ' + editInputCount + '">Order: <input type="text" name="new-order-' + editInputCount + '" class="order" value="' + order + '" /><br />Textbox Label: <input type="text" name="new-textbox-' + editInputCount + '" class="content textbox" /><div class="button new-delete">Delete</div><input type="hidden" name="new-live-' + editInputCount + '" class="is-live" value="1" /></fieldset>');
			editInputCount++;
	});	
	
	// Add radio object to rubric when editing rubric form
	$("#add-radio").click(function(){ 
		var order = findMaxOrder();
		$('#form-edit fieldset').last()
			.after('<fieldset class="edit radio ' + editInputCount + '" id="' + editInputCount + '">Order: <input type="text" name="new-order-' + editInputCount + '" class="order" value="' + order + '" /><br />Radio Label: <input type="text" name="new-radio-' + editInputCount + '" class="content textbox" /><p>Options:</p><ul class="radio-options"><li>Option Order: <input type="text" name="new-' + editInputCount + '-valueChron-' + radioValueCount + '" class="value-order" value="1" /><br />Option Label: <input type="text" name="new-' + editInputCount + '-valueLabel-' + radioValueCount + '" class="value-label" /><br />Option Points: <input type="text" name="new-' + editInputCount + '-valuePoints-' + radioValueCount + '" class="value-points" /><br /><div class="button delete-new-value">Delete this Option</div><input type="hidden" name="new-' + editInputCount + '-valueOn-' + radioValueCount + '" class="is-live" value="1" /></li></ul><div class="button add-value new-radio">Add Option</div><div class="button new-delete">Delete</div><input type="hidden" name="new-live-' + editInputCount + '" class="is-live" value="1" /></fieldset>');
			editInputCount++;
			radioValueCount++;
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
	
	// Add live click event to add value buttons of already existing radio criteria
	$(".button.add-value.existing-radio").live("click", function(){
		
		var tempMax = 0;
		$(this).siblings("ul").children("li").children("input.value-order").each( function(){
				var thisInputValue = parseInt($(this).val());
				if ( thisInputValue > tempMax ) {
					tempMax = thisInputValue;
				}
		});
		var order = tempMax + 1;
		
		var radioID = $(this).parent("fieldset").attr("ID");
		
		$(this).siblings("ul").append('<li>Option Order: <input type="text" name="new-' + radioID + '-valueChron-' + radioValueCount + '" class="value-order" value="' + order +'" /><br />Option Label: <input type="text" name="new-' + radioID + '-valueLabel-' + radioValueCount + '" class="value-label" /><br />Option Points: <input type="text" name="new-' + radioID + '-valuePoints-' + radioValueCount + '" class="value-points" /><br /><div class="button delete-new-value">Delete this Option</div><input type="hidden" name="new-' + radioID + '-valueOn-' + radioValueCount + '" class="is-live" value="1" /></li>');
  		
  		radioValueCount++;
  	});

	// Add live click event to add value buttons of newly created radio criteria
	$(".button.add-value.new-radio").live("click", function(){
		
		var tempMax = 0;
		$(this).siblings("ul").children("li").children("input.value-order").each( function(){
				var thisInputValue = parseInt($(this).val());
				if ( thisInputValue > tempMax ) {
					tempMax = thisInputValue;
				}
		});
		var order = tempMax + 1;
		
		var radioID = $(this).parent("fieldset").attr("ID");
		
		$(this).siblings("ul").append('<li>Option Order: <input type="text" name="new-' + radioID + '-valueChron-' + radioValueCount + '" class="value-order" value="' + order +'" /><br />Option Label: <input type="text" name="new-' + radioID + '-valueLabel-' + radioValueCount + '" class="value-label" /><br />Option Points: <input type="text" name="new-' + radioID + '-valuePoints-' + radioValueCount + '" class="value-points" /><br /><div class="button delete-new-value">Delete this Option</div><input type="hidden" name="new-' + radioID + '-valueOn-' + radioValueCount + '" class="is-live" value="1" /></li>');
  		
  		radioValueCount++;
  	});
  	
  	// Add live click event to delete buttons of newly created radio values
  	$(".button.delete-new-value").live("click", function(){
  	
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