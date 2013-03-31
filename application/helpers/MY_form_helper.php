<?php

function jquery_validate($config_group)
{
	$CI =& get_instance();
	$CI->load->library('form_validation');
	
	$viewdata = array();
	$viewdata['validation_rules'] = $CI->form_validation->jquery_validate_rules($config_group);
	$viewdata['required_fields'] = json_encode($CI->form_validation->get_required_fields($config_group), TRUE);
	
	return $CI->load->view('jquery_validate/javascript.php', $viewdata, TRUE, FALSE);
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

function alert($text, $class='alert')
{
	return sprintf('<div class="%s"><button type="button" class="close" data-dismiss="alert">&times;</button>%s</div>', $class, $text);
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
		return alert($error_string);		
	}
	else
	{
		return '';		
	}
}

function messages()
{
	$CI =& get_instance();
	$CI->load->library('messages');
	$messages = $CI->messages->get_all();

	$output = array();
	
	if (count($messages['info']) > 0)
	{
		$output[] = alert(ul(array_values($messages['info']), array('class' => 'unstyled')), 'alert alert-info');
	}
	
	if (count($messages['error']) > 0)
	{
		$output[] = alert(ul(array_values($messages['error']), array('class' => 'unstyled')), 'alert alert-error');
	}
	
	if (count($messages['success']) > 0)
	{
		$output[] = alert(ul(array_values($messages['success']), array('class' => 'unstyled')), 'alert alert-success');
	}
	
	return join("\n", $output);
}