<?php

class MY_Form_validation extends CI_Form_validation{

	public function __construct($rules = array())
	{
		parent::__construct($rules);
		
		$this->set_custom_errors();
	}

	protected function jquery_rule_map()
	{
		$rules = array();
		$rules['required'] = 'required';
		$rules['min_length'] = 'minlength';
		$rules['max_length'] = 'maxlength';
		$rules['exact_length'] = 'exactlength';
		$rules['valid_email'] = 'email';
		$rules['valid_url'] = 'url';
		$rules['numeric'] = 'number';
		$rules['is_natural'] = 'digits';
		$rules['valid_phone'] = 'phoneUS';
		$rules['valid_zip'] = 'zipcode';
		
		return $rules;
	}
	
	protected function set_custom_errors()
	{
		$this->set_message('valid_phone', 'The %s field must contain a valid phone number.');
		$this->set_message('valid_zip', 'The %s field must contain a valid Postal Code.');
		$this->set_message('valid_url', 'The %s field must contain a valid URL.');
	}

	function valid_phone($str) 
	{
		return preg_match("/^\(?([0-9]{3})\)?[- ]?([0-9]{3})[- ]?([0-9]{4})$/", $str) ? TRUE : FALSE;
	}
		
	function valid_zip($str)
	{
		return preg_match('/^\d{5}(-\d{4})?$/', $str) ? TRUE : FALSE;
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
	
	public function get_required_fields($config_group)
	{
		$rules = $this->get_rules($config_group);
		
		$ruleset = array();
		
		$required = array();

		foreach($rules as $rule)
		{
			if (preg_match('/required/', $rule['rules']))
			{
				$required[] = $rule['field'];
			}
		}
		
		return $required;
	}
	
	public function jquery_validate_rules($config_group)
	{
		$rules = $this->get_rules($config_group);
		$jq_rule_map = $this->jquery_rule_map();
		
		$jquery_rules = array();
		
		foreach($rules as $rule)
		{
			$field = $rule['field'];
			
			$rule_list = explode('|', $rule['rules']);

			foreach($rule_list as $item)
			{
				// Looking for rules like max_length[2] that accepts a name and a parameter.
				if (preg_match('/(.*)\[(.*)\]/', $item, $matches))
				{
					$rule_name = $matches[1];
					$rule_param = $matches[2];
					
					if (array_key_exists($rule_name, $jq_rule_map))
					{
						$jq_rule_name = $jq_rule_map[$rule_name];
						$jq_rule_items[$field][$jq_rule_name] = '*' . $rule_param . '*';
					}
				}
				else
				{
					if (array_key_exists($item, $jq_rule_map))
					{
						$jq_rule_name = $jq_rule_map[$item];
						$jq_rule_items[$field][$jq_rule_name] = 'true';
					}
				}
			}
		}

		$encoded = str_replace('*', '"', str_replace('"', '', json_encode($jq_rule_items, JSON_FORCE_OBJECT)));
		return $encoded;
	}	
	
	function get_error_array()
	{
		return $this->_error_array;
	}
}