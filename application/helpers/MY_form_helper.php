<?php

function form_error($field = '', $prefix = '<span class="help-inline">', $suffix = '</span>')
{
	if (FALSE === ($OBJ =& _get_validation_object()))
	{
		return '';
	}

	return $OBJ->error($field, $prefix, $suffix);
}