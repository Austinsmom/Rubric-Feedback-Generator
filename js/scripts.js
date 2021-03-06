/**
*	Rubric-Feedback Generator - Scripts
*
*	@author Jenn Schiffer
*	@version 0.1
*	@package rubric-feedback-generator
*/

jQuery(document).ready(function () {

	/**
	* Global Scripts
	*/
	
	// Things to initially hide from screen - better than using CSS
	$("#form-batch").css("display","none");
	$("#grade-view-edit").css("display","none");
	$("#delete-prompt").css("display","none");
	$("#delete-prompt.rubric").css("display","none");
	$("fieldset.deleted div.button.add-value.new-radio").css("display","none");
	
	// Always have a form's first radio button selected by default
	$("fieldset.check").each(function() {
		$(this).find("input:first").attr('checked', true);
	});
	
	// Validate email
	function isValidEmailAddress(emailAddress) {
    	var pattern = new RegExp(/^((([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+(\.([a-z]|\d|[!#\$%&'\*\+\-\/=\?\^_`{\|}~]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])+)*)|((\x22)((((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(([\x01-\x08\x0b\x0c\x0e-\x1f\x7f]|\x21|[\x23-\x5b]|[\x5d-\x7e]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(\\([\x01-\x09\x0b\x0c\x0d-\x7f]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF]))))*(((\x20|\x09)*(\x0d\x0a))?(\x20|\x09)+)?(\x22)))@((([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|\d|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.)+(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])|(([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])([a-z]|\d|-|\.|_|~|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])*([a-z]|[\u00A0-\uD7FF\uF900-\uFDCF\uFDF0-\uFFEF])))\.?$/i);
    	return pattern.test(emailAddress);
	};
	
	// Validate date
	function isValidDate(date) {
		var pattern = new RegExp(/(19|20)\d\d[-](0[1-9]|[12][0-9]|3[01])[-](0[1-9]|1[012])/i);
		return pattern.test(date);
	}


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
			return validInput;
		}
		else {
			$("#form-login").attr("action", "user-validate.php").submit();
		}
	});
	
	// register submit
	$("#user-register").click( function(){
				
		// first remove any already existing warning and validation markers
		$("input").removeClass('empty-input');
		$("input").removeClass('invalid-email');
		$("#submit-warning").remove();
		
		var validInput = true;
		var validEmail = true;
		
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
		
		// if email is invalid, warn user
		if ( !isValidEmailAddress($("#email").val()) ){
			$("#email").addClass('invalid-email');
			validEmail = false;
		}
		
		// show warning if validInput == false, else submit
		if ( validInput == false ) {
			$(this).parent("form").append('<span id="submit-warning">Do not leave any fields blank!</span>');
			return validInput;
		}
		else if ( validEmail == false) {
				$(this).parent("form").append('<span id="submit-warning" class="invalid-email">You must submit a valid email!</span>');
				return validEmail;
			}
			else {
				$("#form-register").attr("action", "user-validate.php").submit();
			}

	});
	
	
	/**
	* User Admin
	*/
	
	// Determine whether user wants to edit class or view assignments based on submit
	$("#edit-class").click( function(){
		$("#form-class").attr("action", "class-edit.php").submit();
	});
	$("#view-assignments").click( function(){
		$("#form-class").attr("action", "class-assignments.php").submit();
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
	
	// verify user edit
	$("#submit-user-edit").click( function() {

		// first remove any already existing warning and validation markers
		$("input").removeClass('empty-input');
		$("textarea").removeClass('empty-input');
		$("input").removeClass('invalid-email');
		$("#submit-warning").remove();
		
		var validInput = true;
		var validEmail = true;
		
		// if user nicename is blank, warn user
		if ( $("#nicename").val().length == 0) {
     		 $("#nicename").addClass('empty-input');
     		 validInput = false;
		}
		
		// if user email is blank, warn user
		if ( $("#email").val().length == 0) {
     		 $("#email").addClass('empty-input');
     		 validInput = false;
		}
		
		// if email is invalid, warn user
		if ( !isValidEmailAddress($("#email").val()) ){
			$("#email").addClass('invalid-email');
			validEmail = false;
		}
	
		// show warning if validInput == false, else submit
		if ( validInput == false ) {
			$("#submit-user-edit").after('<span id="submit-warning">Fields in red should not be blank!</span>');
			return validInput;
		}
		else if ( validEmail == false) {
				$("#submit-user-edit").after('<span id="submit-warning" class="invalid-email">You must submit a valid email!</span>');
				return validEmail;
			}
			else {
				$("#form-user-edit").attr("action", "user-validate.php").submit();
			}
		
	});

	
	/**
	* Classes
	*/
	
	// create new class
	$("#new-class").click( function() {
	
		// first remove any already existing warning and validation markers
		$("input").removeClass('empty-input');
		$("textarea").removeClass('empty-input');
		$("#submit-warning").remove();
		
		var validInput = true;
		
		// if title is blank, warn user
		if ( $("#class-title").val().length == 0) {
     		 $("#class-title").addClass('empty-input');
     		 validInput = false;
		}
		
		// if time is blank, warn user
		if ($("#class-time").val().length == 0) {
			$("#class-time").addClass('empty-input');
			validInput = false;
		}
		
		// show warning if validInput == false, else submit
		if ( validInput == false ) {
			$(this).parent("form").append('<span id="submit-warning">Fields in red should not be blank!</span>');
			return validInput;
		}
		else {
			$("#form-class").attr("action", "class-save.php").submit();
		}

	});
	
	// edit class
	$("#submit-class-edit").click( function() {
	
		// first remove any already existing warning and validation markers
		$("input").removeClass('empty-input');
		$("textarea").removeClass('empty-input');
		$("#submit-warning").remove();
		
		var validInput = true;
		
		// if title is blank, warn user
		if ( $("#class-title").val().length == 0) {
     		 $("#class-title").addClass('empty-input');
     		 validInput = false;
		}
		
		// if time is blank, warn user
		if ($("#class-time").val().length == 0) {
			$("#class-time").addClass('empty-input');
			validInput = false;
		}

		// show warning if validInput == false, else submit
		if ( validInput == false ) {
			$(this).parent("form").append('<span id="submit-warning">Fields in red should not be blank!</span>');
			return validInput;
		}
		else {
			$("#form-class-edit").attr("action", "class-edit-submit.php").submit();
		}

	});
	
	// delete class
	$("#delete-class").click( function() {
		$("#delete-prompt.class").css("display","block");
		return false;
	});
	
	$("#confirm-class-delete").click( function() {
		$("#form-class").attr("action", "class-delete.php").submit();
	});
	
	$("#cancel-class-delete").click( function() {
		$("#delete-prompt.class").css("display","none");
		return false;
	});


	/**
	* Assignments
	*/
	

	// new assignment
	$("#new-assignment").click( function() {

		// first remove any already existing warning and validation markers
		$("input").removeClass('empty-input');
		$("textarea").removeClass('empty-input');
		$("input").removeClass('invalid-date');
		$("#submit-warning").remove();
		
		var validInput = true;
		var rubricExists = true;
		var validDate = true;
		
		// if title is blank, warn user
		if ( $("#assignment-title").val().length == 0) {
     		$("#assignment-title").addClass('empty-input');
     		validInput = false;
		}
		
		// if no rubrics exist, warn user
		if ( $('select').length == 0 ) {
			$("#no-rubrics").addClass('empty-input');
			rubricExists = false;
		}
		
		// if due date is blank, warn user
		if ($("#assignment-duedate").val().length == 0) {
			$("#assignment-duedate").addClass('empty-input');
			validInput = false;
		}
		
		// if due date is not in valid yyyy-mm-dd format, warn user
		if ( isValidDate($("#assignment-duedate").val()) == false ) {
			$("#assignment-duedate").addClass('invalid-date');
			validDate = false;
		}

		// show warning if validInput == false, else submit
		if ( validInput == false ) {
			$(this).parent("form").append('<span id="submit-warning">Fields in red should not be blank!</span>');
			return validInput;
		}
		else if ( validDate == false ) {
				$(this).parent("form").append('<span id="submit-warning" class="invalid-date">Date must be in yyyy-mm-dd format!</span>');
				return validDate;
			} 
			else if ( rubricExists == false ) {
					alert('wowowo');
					return rubricExists;
				}
				else {
						$("#form-assignment").attr("action", "assignment-save.php").submit();
				}
		
	});
	
	// edit assignment
	$("#submit-assignment-edit").click( function() {

		// first remove any already existing warning and validation markers
		$("input").removeClass('empty-input');
		$("textarea").removeClass('empty-input');
		$("input").removeClass('invalid-date');
		$("#submit-warning").remove();
		
		var validInput = true;
		var validDate = true;
		
		// if title is blank, warn user
		if ( $("#assignment-title").val().length == 0) {
     		 $("#assignment-title").addClass('empty-input');
     		 validInput = false;
		}
		
		// if due date is blank, warn user
		if ($("#assignment-duedate").val().length == 0) {
			$("#assignment-duedate").addClass('empty-input');
			validInput = false;
		}
		
		// if due date is not in valid yyyy-mm-dd format, warn user
		if ( isValidDate($("#assignment-duedate").val()) == false ) {
			$("#assignment-duedate").addClass('invalid-date');
			validDate = false;
		}
		
		// show warning if validInput == false, else submit
		if ( validInput == false ) {
			$(this).parent("form").append('<span id="submit-warning">Fields in red should not be blank!</span>');
			return validInput;
		}
		else if ( validDate == false ) {
					$(this).parent("form").append('<span id="submit-warning" class="invalid-date">Date must be in yyyy-mm-dd format!</span>');
					return validDate;
			}
			else {
				$("#form-assignment-edit").attr("action", "assignment-edit-submit.php").submit();
			}
		
	});
	
	// delete assignment
	$("#delete-assignment").click( function() {
		$("#delete-prompt").css("display","block");
		return false;
	});
	
	$("#confirm-assignment-delete").click( function() {
		$("#form-assignment").attr("action", "assignment-delete.php").submit();
	});
	
	$("#cancel-assignment-delete").click( function() {
		$("#delete-prompt").css("display","none");
		return false;
	});



	/**
	* Grades
	*/
	
	// edit grade
	$("#submit-grade-edit").click( function() {

		// first remove any already existing warning and validation markers
		$("input").removeClass('empty-input');
		$("textarea").removeClass('empty-input');
		$("input").removeClass('invalid-email');
		$("#submit-warning").remove();
		
		var validInput = true;
		var validEmail = true;
				
		// go through each textarea item in the form to check for values
		$("#form-grade-edit").find("textarea").each(function(){
			if ( $(this).val().length == 0) {
	     		 $(this).addClass('empty-input');
	     		 validInput = false;
			}
		});
		
		// go through each input item in the form to check for values
		$("#form-grade-edit").find("input").each(function(){		
			if ( $(this).val().length == 0) {
	     		 $(this).addClass('empty-input');
	     		 validInput = false;
			}
		});
		
		//check student email to see if it's a valid email
		$("#form-grade-edit").find(".email").each(function(){
			if ( !isValidEmailAddress($(this).val()) ){
				validEmail = false;
				$(this).addClass('invalid-email');
			}
		});

		// show warning if validInput == false, else submit
		if ( validInput == false ) {
			$("#form-grade-edit").append('<span id="submit-warning">Fields in red should not be blank!</span>');
			return validInput;
		}
		else if ( validEmail == false ) {
				$("#form-grade-edit").append('<span id="submit-warning" class="invalid-email">You must enter a valid email address!</span>');
				return validEmail;
			}
			else {
				$("#form-grade-edit").attr("action", "grade-edit-submit.php").submit();
			}
		
	});

	// submit grade
	$("#submit-grade").click( function() {

		// first remove any already existing warning and validation markers
		$("input").removeClass('empty-input');
		$("textarea").removeClass('empty-input');
		$("input").removeClass('invalid-email');
		$("#submit-warning").remove();
		
		var validInput = true;
		var validEmail = true;
		
		// go through each textarea item in the form to check for values
		$("#form-grade-assignment").find("textarea").each(function(){
			if ( $(this).val().length == 0) {
	     		 $(this).addClass('empty-input');
	     		 validInput = false;
			}
		});
		
		// go through each input item in the form to check for values
		$("#form-grade-assignment").find("input").each(function(){		
			if ( $(this).val().length == 0) {
	     		 $(this).addClass('empty-input');
	     		 validInput = false;
			}
		});
		
		//check student email to see if it's a valid email
		$("#form-grade-assignment").find(".email").each(function(){
			if ( !isValidEmailAddress($(this).val()) ){
				validEmail = false;
				$(this).addClass('invalid-email');
			}
		});

		// show warning if validInput == false, else submit
		if ( validInput == false ) {
			$("#form-grade-assignment").append('<span id="submit-warning">Fields in red should not be blank!</span>');
			return validInput;
		}
		else if ( validEmail == false ) {
				$("#form-grade-assignment").append('<span id="submit-warning" class="invalid-email">You must enter a valid email address!</span>');
				return validEmail;
			}
			else {
				$("#form-grade-assignment").attr("action", "grade-submit.php").submit();
			}
	});
	
	// delete grade
	$("#delete-grade").click( function() {
		$("#delete-prompt").css("display","block");
		return false;
	});
	
	$("#confirm-grade-delete").click( function() {
		$("#form-grade").attr("action", "grade-delete.php").submit();
	});
	
	$("#cancel-grade-delete").click( function() {
		$("#delete-prompt").css("display","none");
		return false;
	});
	
	// select batch email screen
	$("#email-batch").click( function() {
		$("#submit-warning").remove();
		$("#grade-view-edit").css("display","block");
		$("#email-batch").css("display","none");
		$("#form-grade").css("display","none");
		$("#form-batch").css("display","block");
		return false;
	});
	
	// select edit/email individual grade (default) menu
	$("#grade-view-edit").click( function() {
		$("#submit-warning").remove();
		$("#grade-view-edit").css("display","none");
		$("#email-batch").css("display","block");
		$("#form-batch").css("display","none");
		$("#form-grade").css("display","block");
		return false;
	});
	
	// select all checkboxes for batch email
	$("#select-all").click( function() {
		$("input.checkbox").attr('checked', true);
		return false;
	});
	
	// unselect all checkboxes for batch email
	$("#select-none").click( function() {
		$("input.checkbox").attr('checked', false);
		return false;
	});
	
	// batch email grades
	$("#batch-email-grades").click( function() {
		$("#submit-warning").remove();

		// check and make sure at least one checkbox is selected
		if ($('#grade-choice :checkbox:checked').length > 0) {
			validSelection = true;
			$("#form-batch").attr("action", "grade-email-batch.php").submit();
		}
		else {
			validSelection = false;
			$("#form-batch").after('<span id="submit-warning">You must select at least one grade to email.</span>');
			
		}
		return validSelection;
	});
	
	
	/**
	* Rubrics
	*/
	
	// allow tabs in delimited form textarea
	$("textarea#delimited-text").focus(function() {
 		$(this).keydown(function(event){
			// if hit tab, enter tab instead of moving to next input
			if(event.keyCode == 9) {
				event.preventDefault();
				$(this).val($(this).val() + "\t");
				return false;
			}
			
			// if hit ctrl, move to next input by default
			if(event.keyCode == 17) {
				$("#submit-form-delimited").focus();
				return false;
			}
		});
	});
	
	// new rubric import via delimited form
	$("#submit-form-delimited").click( function() {

		// first remove any already existing warning and validation markers
		$("input").removeClass('empty-input');
		$("textarea").removeClass('empty-input');
		$("#submit-warning").remove();
		
		var validInput = true;
		
		// if delimited textarea is blank, warn user
		if ( $("#delimited-text").val().length == 0) {
     		 $("#delimited-text").addClass('empty-input');
     		 validInput = false;
		}
		
		// show warning if validInput == false, else submit
		if ( validInput == false ) {
			$("#form-delimited").append('<span id="submit-warning">Fields in red should not be blank!</span>');
			return validInput;
		}
		else {
			$("#form-delimited").attr("action", "rubric-delimited-verify.php").submit();
		}
		
	});
	
	// verify new rubric import via delimited form
	$("#submit-form-output").click( function() {

		// first remove any already existing warning and validation markers
		$("input").removeClass('empty-input');
		$("textarea").removeClass('empty-input');
		$("#submit-warning").remove();
		
		var validInput = true;
		
		// if rubric title is blank, warn user
		if ( $("#form-rubric-title").val().length == 0) {
     		 $("#form-rubric-title").addClass('empty-input');
     		 validInput = false;
		}
		
		// if rubric description is blank, warn user
		if ( $("#form-rubric-description").val().length == 0) {
     		 $("#form-rubric-description").addClass('empty-input');
     		 validInput = false;
		}
		
		// show warning if validInput == false, else submit
		if ( validInput == false ) {
			$("#submit-form-output").after('<span id="submit-warning">Fields in red should not be blank!</span>');
			return validInput;
		}
		else {
			$("#form-output-save").attr("action", "rubric-delimited-save.php").submit();
		}
		
	});

	
	// New/Edit Rubric
	
	var editInputCount = 1;
	var radioValueCount = 1;
	
	// verify edit rubric form
	$("#submit-form-edit").click( function() {

		// first remove any already existing warning and validation markers
		$("input").removeClass('empty-input');
		$("textarea").removeClass('empty-input');		
		$("input").removeClass('invalid-points');
		$("input").removeClass('invalid-order');
		$("#submit-warning").remove();
		
		var validInput = true;
		var pointsValid = true;
		var orderValid = true;
		
		// go through each textarea item in the form to check for values
		$("#form-edit").find("textarea").each(function(){
			if ( $(this).val().length == 0 && $(this).parent('fieldset').hasClass('deleted') == false) {
	     		 $(this).addClass('empty-input');
	     		 validInput = false;
			}
		});
		
		// go through each input item in the form to check for values
		$("#form-edit").find("input").each(function(){		
			if ( ($(this).val().length == 0 && $(this).parents('fieldset').hasClass('deleted') == false) && $(this).parents('li').hasClass('deleted') == false ){
	     		 $(this).addClass('empty-input');
	     		 validInput = false;
			}
		});
		
		// go through each value-points input and verify they are integers
		$("#form-edit").find(".value-points").each(function(){
			var points = $(this).val();
			if ( isNaN(points) || points.indexOf('.') != -1 ) {
	     		$(this).addClass('invalid-points');
				pointsValid = false;
			}
		});
		
		// go through each order input and verify they are integers
		$("#form-edit").find(".order").each(function(){
			var order = $(this).val();
			if ( isNaN(order) || order.indexOf('.') != -1 ) {
	     		$(this).addClass('invalid-order');
	     		orderValid = false;
			}
		});
				
		// show warning if validInput == false, else submit
		if ( validInput == false ) {
			$("#submit-form-edit").after('<span id="submit-warning">Fields in red should not be blank!</span>');
			return false;
		}
		else if ( pointsValid == false ) {
				$("#submit-form-edit").after('<span id="submit-warning" class="invalid-points">Radio Criteria Points must be an Integer (-n...-1, 0, 1...n)</span>');	
				return false;
			}
			else if ( orderValid == false ) {
					$("#submit-form-edit").after('<span id="submit-warning" class="invalid-order">Order of any Rubric object must be an Integer (-n...-1, 0, 1...n)</span>');
					return false;
				}
				else {
					$("#form-edit").attr("action", "rubric-edit-save.php").submit();
				}
		
	});
	
	// verify new rubric form (not delimited)
	$("#submit-form-new").click( function() {

		// first remove any already existing warning and validation markers
		$("input").removeClass('empty-input');
		$("textarea").removeClass('empty-input');
		$("input").removeClass('invalid-points');
		$("input").removeClass('invalid-order');
		$("#submit-warning").remove();
		
		var validInput = true;
		var pointsValid = true;
		var orderValid = true;
		
		// go through each textarea item in the form to check for values
		$("#form-edit").find("textarea").each(function(){
			if ( $(this).val().length == 0 && $(this).parent('fieldset').hasClass('deleted') == false && $(this).parent('li').hasClass('deleted') == false ) {
	     		 $(this).addClass('empty-input');
	     		 validInput = false;
			}
		});
		
		// go through each input item in the form to check for values
		$("#form-edit").find("input").each(function(){		
			if ( $(this).val().length == 0 && $(this).parent('fieldset').hasClass('deleted') == false && $(this).parent('li').hasClass('deleted') == false ) {
	     		 $(this).addClass('empty-input');
	     		 validInput = false;
			}
		});
		
		// go through each value-points input and verify they are numbers
		$("#form-edit").find(".value-points").each(function(){
			var points = $(this).val();
			if ( isNaN(points)  || points.indexOf('.') != -1 ) {
				pointsValid = false;
	     		$(this).addClass('invalid-points');
			}
		});
		
		// go through each order input and verify they are integers
		$("#form-edit").find(".order").each(function(){
			var order = $(this).val();
			if ( isNaN(order) || order.indexOf('.') != -1 ) {
	     		$(this).addClass('invalid-order');
	     		orderValid = false;
			}
		});
		
		// go through each value-order input and verify they are integers
		$("#form-edit").find(".value-order").each(function(){
			var order = $(this).val();
			if ( isNaN(order) || order.indexOf('.') != -1 ) {
	     		$(this).addClass('invalid-order');
	     		orderValid = false;
			}
		});
		
		// show warning if validInput == false, else submit
		if ( validInput == false ) {
			$("#submit-form-new").after('<span id="submit-warning">Fields in red should not be blank!</span>');
			return validInput;
		}
		else if ( pointsValid == false ) {
				$("#submit-form-new").after('<span id="submit-warning" class="invalid-points">Radio Criteria Points must be an Integer (-n...-1, 0, 1...n)</span>');	
				return false;
			}
			else if ( orderValid == false ) {
					$("#submit-form-new").after('<span id="submit-warning" class="invalid-order">Order of any Rubric object must be an Integer (-n...-1, 0, 1...n)</span>');
					return false;
				}
				else {
					$("#form-edit").attr("action", "rubric-new-save.php").submit();
				}
		
	});

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
	
	// Change criteria is-live on click of "delete" button, and undo delete
	$("fieldset.edit input.button.delete").click(function(){ 
		
		var $thisButton = $(this);
			
		//if button value = delete, then change is-live to 0 and value to "undo delete"
		if ( $thisButton.val() == "Delete") {
			$thisButton.val("Undelete");
			$thisButton.parent("fieldset").children("input.is-live").val("0");
			$thisButton.parent("fieldset").addClass("deleted");
		}
		//else change is-live to 1 and value to "delete"
		else {
			$thisButton.val("Delete");
			$thisButton.parent("fieldset").children('input.is-live').val("1");
			$thisButton.parent("fieldset").removeClass("deleted");
		}
		return false;
	});
	
	// Change radio criteria value is-live on click of "delete" button, and undo delete
	$("fieldset.edit input.button.delete-value").click(function(){ 
		
		var $thisButton = $(this);
			
		//if button value = Delete Option, then change is-live to 0 and value to "undo delete"
		if ( $thisButton.val() == "Delete Option") {
			$thisButton.val("Undelete Option");
			$thisButton.parent("li").children("input.is-live").val("0");
			$thisButton.parent("li").addClass("deleted");
		}
		//else change is-live to 1 and value to "Delete Option"
		else {
			$thisButton.val("Delete Option");
			$thisButton.parent("li").children('input.is-live').val("1");
			$thisButton.parent("li").removeClass("deleted");
		}
		return false;
	});
	
	// Add title object to rubric when editing rubric form
	$("#add-title").click(function(){ 
		var order = findMaxOrder();
		$('#form-edit fieldset').last()
			.after('<fieldset class="edit title ' + editInputCount + '">Order: <input type="text" name="new-order-' + editInputCount + '" class="order" value="' + order + '" /><br />Title Content: <input type="text" name="new-title-' + editInputCount + '" class="content title" /><input type="submit" class="button new-delete" value="Delete" /><input type="hidden" name="new-live-' + editInputCount + '" class="is-live" value="1" /></fieldset>');
			editInputCount++;
			return false;
	});	
	
	
	// Add plaintext object to rubric when editing rubric form
	$("#add-plaintext").click(function(){ 
		var order = findMaxOrder();
		$('#form-edit fieldset').last()
			.after('<fieldset class="edit text ' + editInputCount + '">Order: <input type="text" name="new-order-' + editInputCount + '" class="order" value="' + order + '" /><br />Plaintext Content: <input type="text" name="new-plaintext-' + editInputCount + '" class="content text" /><input type="submit" class="button new-delete" value="Delete" /><input type="hidden" name="new-live-' + editInputCount + '" class="is-live" value="1" /></fieldset>');
			editInputCount++;
			return false;
	});	
	
	// Add textbox object to rubric when editing rubric form
	$("#add-textbox").click(function(){ 
		var order = findMaxOrder();
		$('#form-edit fieldset').last()
			.after('<fieldset class="edit textbox ' + editInputCount + '">Order: <input type="text" name="new-order-' + editInputCount + '" class="order" value="' + order + '" /><br />Textbox Label: <input type="text" name="new-textbox-' + editInputCount + '" class="content textbox" /><input type="submit" class="button new-delete" value="Delete" /><input type="hidden" name="new-live-' + editInputCount + '" class="is-live" value="1" /></fieldset>');
			editInputCount++;
			return false;
	});	
	
	// Add radio object to rubric when editing rubric form
	$("#add-radio").click(function(){ 
		var order = findMaxOrder();
		$('#form-edit fieldset').last()
			.after('<fieldset class="edit radio ' + editInputCount + '" id="' + editInputCount + '">Order: <input type="text" name="new-order-' + editInputCount + '" class="order" value="' + order + '" /><br />Radio Label: <input type="text" name="new-radio-' + editInputCount + '" class="content textbox" /><p>Options:</p><ul class="radio-options"><li>Option Order: <input type="text" name="new-' + editInputCount + '-valueChron-' + radioValueCount + '" class="value-order" value="1" /><br />Option Label: <input type="text" name="new-' + editInputCount + '-valueLabel-' + radioValueCount + '" class="value-label" /><br />Option Points: <input type="text" name="new-' + editInputCount + '-valuePoints-' + radioValueCount + '" class="value-points" /><br /><input type="submit" class="button delete-new-value" value="Delete Option" /><input type="hidden" name="new-' + editInputCount + '-valueOn-' + radioValueCount + '" class="is-live" value="1" /></li></ul><input type="submit" class="button add-value new-radio" value="Add Option" /><input type="submit" class="button new-delete" value="Delete" /><input type="hidden" name="new-live-' + editInputCount + '" class="is-live" value="1" /></fieldset>');
			editInputCount++;
			radioValueCount++;
			return false;
	});
	
	// Add live click event to delete buttons of newly created rubric objects
	$("fieldset.edit input.button.new-delete").live("click", function(){
  		var $thisButton = $(this);
			
		//if button value = delete, then change is-live to 0 and value to "undo delete"
		if ( $thisButton.val() == "Delete") {
			$thisButton.val("Undelete");
			$thisButton.parent("fieldset").children("input.is-live").val("0");
			$thisButton.parent("fieldset").addClass("deleted");
			$thisButton.parent("fieldset").find("ul.radio-options li").addClass("deleted");
		}
		//else change is-live to 1 and value to "delete"
		else {
			$thisButton.val("Delete");
			$thisButton.parent("fieldset").children('input.is-live').val("1");
			$thisButton.parent("fieldset").removeClass("deleted");
			$thisButton.parent("fieldset").find("ul.radio-options li").removeClass("deleted");
		}
		return false;
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
		
		$(this).siblings("ul").append('<li>Option Order: <input type="text" name="new-' + radioID + '-valueChron-' + radioValueCount + '" class="value-order" value="' + order +'" /><br />Option Label: <input type="text" name="new-' + radioID + '-valueLabel-' + radioValueCount + '" class="value-label" /><br />Option Points: <input type="text" name="new-' + radioID + '-valuePoints-' + radioValueCount + '" class="value-points" /><br /><input type="submit" class="button delete-new-value" value="Delete Option" /><input type="hidden" name="new-' + radioID + '-valueOn-' + radioValueCount + '" class="is-live" value="1" /></li>');
  		
  		radioValueCount++;
  		return false;
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
		
		$(this).siblings("ul").append('<li>Option Order: <input type="text" name="new-' + radioID + '-valueChron-' + radioValueCount + '" class="value-order" value="' + order +'" /><br />Option Label: <input type="text" name="new-' + radioID + '-valueLabel-' + radioValueCount + '" class="value-label" /><br />Option Points: <input type="text" name="new-' + radioID + '-valuePoints-' + radioValueCount + '" class="value-points" /><br /><input type="submit" class="button delete-new-value" value="Delete Option" /><input type="hidden" name="new-' + radioID + '-valueOn-' + radioValueCount + '" class="is-live" value="1" /></li>');
  		
  		radioValueCount++;
  		return false;
  	});
  	
  	// Add live click event to delete buttons of newly created radio values
  	$("fieldset.edit input.button.delete-new-value").live("click", function(){
  	
		var $thisButton = $(this);
			
		//if button value = Delete Option, then change is-live to 0 and value to "undo delete"
		if ( $thisButton.val() == "Delete Option") {
			$thisButton.val("Undelete Option");
			$thisButton.parent("li").children("input.is-live").val("0");
			$thisButton.parent("li").addClass("deleted");
		}
		//else change is-live to 1 and value to "Delete Option"
		else {
			$thisButton.val("Delete Option");
			$thisButton.parent("li").children('input.is-live').val("1");
			$thisButton.parent("li").removeClass("deleted");
		}
		return false;
  	});
  	
  	// delete rubric
	$("#delete-rubric").click( function() {
		$("#delete-prompt.rubric").css("display","block");
		return false;
	});
	
	$("#confirm-rubric-delete").click( function() {
		$("#form-rubric").attr("action", "rubric-delete.php").submit();
	});
	
	$("#cancel-rubric-delete").click( function() {
		$("#delete-prompt.rubric").css("display","none");
		return false;
	});

});