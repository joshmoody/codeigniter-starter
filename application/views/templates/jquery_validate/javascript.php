<script>
/**
 * Supporting javascript for CI client side validation.
 */
var required_fields		= <?php echo $required_fields;?>;
var validation_rules	= <?php echo $validation_rules;?>;

/**
 * Add error indicator to a field
 */
function indicate_field_error(selector)
{
	$(selector).parents('.control-group').addClass('error');
}

/**
 * Add the error indicators to a field
 */
function highlight_field_errors()
{
	$('.validation-error').parents('.control-group').addClass('error');
}

/**
 * Remove the error indicators from a field
 */
function remove_field_error(selector)
{
	$(selector).parents('.control-group').removeClass('error');
	
	var error_selector = '.' + $(selector).attr('id') + '-error';
	$(error_selector).remove();
}

/**
 * Set the "required" attribute on the input, add "*" to the field label.
 */
function mark_required_field(selector)
{
	$(selector).attr('required', 'required');
	
	// Remove existing required field indicators before adding new one - otherwise there will be multiple indicators in some cases.
	$(selector).parents('.control-group').children('.control-label').find('.required').remove();
	$(selector).parents(".control-group").children(".control-label").prepend('<span class="required">*</span>');
}

/**
 * Accepts array of required fields and marks each as required.
 */
function mark_all_required_fields(required_fields)
{
	if (required_fields.length > 0)
	{
		for(var i=0; i<required_fields.length; i++)
		{
			mark_required_field('#' + required_fields[i]);
		}
	}
}

/**
 * Define custom jquery validate methods.
 */
function add_validate_methods()
{
	// Add custom validator for phone numbers.
	jQuery.validator.addMethod("phoneUS", function(phone_number, element) {
	    phone_number = phone_number.replace(/\s+/g, ""); 
		return this.optional(element) || phone_number.length > 9 &&
			phone_number.match(/^(1-?)?(\([2-9]\d{2}\)|[2-9]\d{2})-?[2-9]\d{2}-?\d{4}$/);
	}, "Please specify a valid phone number.");

	// Add custom validator for zip codes.
	jQuery.validator.addMethod("zipcode", function(zipcode, element) {
	    zipcode = zipcode.replace(/\s+/g, ""); 
		return this.optional(element) || zipcode.length == 5 && zipcode.match(/^\d{5}(-\d{4})?$/);
	}, "Please specify a valid zip code.");

	// Add custom validator for exact length
	jQuery.validator.addMethod("exactlength", function(value, element, param) {
	 return this.optional(element) || value.length == param;
	}, jQuery.format("Please enter exactly {0} characters."));		
}

function init_jquery_validate()
{
	// Add a few custom validation methods.
	add_validate_methods();
	
	// Disable HTML5 validation.
	$('.validate').attr('novalidate', 'novalidate');


	// Run jquery validation
	$('.validate').validate({
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
		rules: validation_rules
	});
}

$(function(){
	highlight_field_errors()
 	mark_all_required_fields(required_fields);
 	init_jquery_validate();
});
</script>