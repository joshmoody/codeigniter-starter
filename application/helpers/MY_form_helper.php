<?php

function form_error($field = '', $prefix = '<span class="help-inline">', $suffix = '</span>')
{
	if (FALSE === ($OBJ =& _get_validation_object()))
	{
		return '';
	}

	return $OBJ->error($field, $prefix, $suffix);
}

function mark_required_fields($config_group)
{
	$CI =& get_instance();
	$CI->load->library('form_validation');
	
	$required = $CI->form_validation->get_required_fields($config_group);
	
	if (count($required) > 0)
	{
		$output = array();
		
		$output[] = '<script>';
		$output[] = '$(function(){';
		
		foreach($required as $r)
		{
			$output[] = sprintf("required_field('#%s');", $r);
		}
		$output[] = '});';
		$output[] = '</script>';
	}
	
	return join("\n", $output);
}