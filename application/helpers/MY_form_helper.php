<?php

function jquery_validate($config_group)
{
	$CI =& get_instance();
	$CI->load->library('form_validation');
	
	$viewdata = array();
	$viewdata['validation_rules'] = $CI->form_validation->jquery_validate_rules($config_group);
	$viewdata['required_fields'] = json_encode($CI->form_validation->get_required_fields($config_group), TRUE);
	
	return $CI->load->view('templates/jquery_validate/javascript.php', $viewdata, TRUE, FALSE);
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
function form_error($field = '', $prefix = '<span class="help-inline validation-error">', $suffix = '</span>')
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
	
	if (strlen(trim($error_string) > 0))
	{
		return '<div class="alert alert-error"><button type="button" class="close" data-dismiss="alert">&times;</button>' . $error_string . '</div>';		
	}
	else
	{
		return '';		
	}
}