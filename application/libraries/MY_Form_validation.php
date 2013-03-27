<?php

class MY_Form_validation{


	protected function jquery_validate_rules()
	{
		$rules = new stdclass();
		$rules->required = 'required';
		$rules->min_length = 'minlength';
		$rules->max_length = 'maxlength';
		$rules->valid_email = 'email';
		$rules->valid_url = 'url';
		$rules->numeric = 'number';
		$rules->is_natural = 'digits';
		$rules->valid_phone = 'phoneUS';
	}
	
	protected function log_custom_errors()
	{
		$this->set_message('valid_phone', 'The %s field must contain a valid phone number.');
		$this->set_message('valid_zip', 'The %s field must contain a valid Postal Code.');
		$this->set_message('valid_url', 'The %s field must contain a valid URL.');
		
	}
		
	function valid_zip($str)
	{
		return preg_match('/^\d{5}(-\d{4})?$/', $str) ? TRUE : FALSE;
	}
	
	function valid_phone($str) 
	{
		return preg_match("/^\(?([0-9]{3})\)?[- ]?([0-9]{3})[- ]?([0-9]{4})$/", $str) ? TRUE : FALSE;
	}
	
	function valid_url($str)
	{
		return preg_match('/^(http|https):\/\/[a-z0-9]+([\-\.]{1}[a-z0-9]+)*\.[a-z]{2,5}((:[0-9]{1,5})?\/.*)?$/i', $str) ? TRUE : FALSE;
	}

	public function get_rules($config_group)
	{
		if (array_key_exists($config_group, $this->_config_rules))
		{
			return $this->_config_rules[$config_group];	
		}
		else
		{
			return array();
		}	
	}
	
	function get_error_array()
	{
		return $this->_error_array;
	}
}