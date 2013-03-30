<?php

function jquery_validate($config_group)
{
	return '<script src="' . site_url('validation/process') . '?config_group=' . $config_group . '"></script>';
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