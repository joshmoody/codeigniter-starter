<?php

function jquery_ready($output = ''){
	$prefix = '<script>$(function(){';
	$suffix = '});</script>';
	
	return $prefix . $output . $suffix;
}

function client_side_errors($config_group)
{
	$output = mark_required_fields($config_group);

	$CI =& get_instance();
	$CI->load->library('form_validation');


	$errors = $CI->form_validation->get_error_array();

	$error_keys = array_keys($errors);

	foreach($error_keys as $field)
	{
		$output .= sprintf("indicate_field_error('#%s');", $field);
	}

	return jquery_ready($output);
}

function jquery_validate_rules($config_group)
{
	$CI =& get_instance();
	$CI->load->library('form_validation');

	return $CI->form_validation->jquery_validate_rules($config_group);
}

function mark_required_fields($config_group)
{
	$CI =& get_instance();
	$CI->load->library('form_validation');
    
	$required = $CI->form_validation->get_required_fields($config_group);

	$output = array();
			
	if (count($required) > 0)
	{
		foreach($required as $r)
		{
			$output[] = sprintf("required_field('#%s');", $r);
		}
	}
	
	return join(' ', $output);
}

function validation_errors_array()
{
    if (FALSE === ($OBJ =& _get_validation_object()))
    {
        return '';
    }
    
    return $OBJ->get_error_array();
}

/**
 * Apply Bootstrap Styling to each form error.
 */
function form_error($field = '', $prefix = '<span class="help-inline">', $suffix = '</span>')
{
	if (FALSE === ($OBJ =& _get_validation_object()))
	{
		return '';
	}

	return $OBJ->error($field, $prefix, $suffix);
}

/**
 * Apply Bootstrap Styling to error summary.
 */
function validation_errors($prefix = '', $suffix = '')
{
	if (FALSE === ($OBJ =& _get_validation_object()))
	{
		return '';
	}

	$error_string = $OBJ->error_string($prefix, $suffix);
	
	return '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $error_string . '</div>';
}