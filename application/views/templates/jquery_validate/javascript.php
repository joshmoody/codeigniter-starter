function run_jquery_validate(form_id)
{
	// Disable HTML5 validation.
	$('form').attr('novalidate', 'novalidate');

	// Add custom validator for phone numbers.
	jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
	    phone_number = phone_number.replace(/\s+/g, ""); 
		return this.optional(element) || phone_number.length > 9 &&
			phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
	}, "Please specify a valid phone number");

	// Add custom validator for zip codes.
	jQuery.validator.addMethod("zipcode", function(zipcode, element) {
	    zipcode = zipcode.replace(/\s+/g, ""); 
		return this.optional(element) || zipcode.length == 5 && zipcode.match(/^\d{5}(-\d{4})?$/);
	}, "Please specify a valid zip code");

	// Add custom validator for exactlength
	jQuery.validator.addMethod("exactlength", function(value, element, param) {
	 return this.optional(element) || value.length == param;
	}, jQuery.format("Please enter exactly {0} characters."));		

	// Run jquery validation
	$('#foo').validate({
			errorElement: "span",
			errorClass: "help-inline",
			onfocusout: function(element){
				$(element).valid();
				},
			highlight: function(element, errorClass, validClass){
					indicate_field_error(element);
				},
			unhighlight: function(element, errorClass, validClass){
					remove_field_error(element);
				},
			rules: <?=$rules;?>
		});
}

$(function() {
 	run_jquery_validate('<?php echo $config_group;?>');
	<?php echo client_side_errors($config_group);?>

});
