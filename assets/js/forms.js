/*
function masks()
{
	$('input[type=tel]').mask('999-999-9999');
	$('input.zip').mask('99999');
}

function placeholders()
{
	$('input[type=email]').attr('placeholder', 'you@example.com');
	$('input[type=url]').attr('placeholder', 'http://www.example.com');
	$('input[type=tel]').attr('placeholder', '555-555-5555');
}

function buttons()
{
	$('.btn-wizard-prev').prepend("\u2190 ");
	$('.btn-wizard-next').append(" \u2192");
}
*/

function indicate_field_error(selector)
{
	$(selector).parents('.control-group').addClass('error');
}

function remove_field_error(selector)
{
	$(selector).parents('.control-group').removeClass('error');
	
	var error_selector = '.' + $(selector).attr('id') + '-error';
	$(error_selector).remove();
}

function required_field(selector)
{
	$(selector).attr('required', 'required');
	$(selector).parents(".control-group").children(".control-label").prepend('<span class="required">*</span>');
}

function errors()
{
	$('span.help-inline.validation-message').hide();
	
}

$(function() {
/*
	placeholders();
	masks();
	buttons();
*/
	
	errors();
});