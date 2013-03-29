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

$(function() {
	placeholders();
	masks();
	buttons();
});