<?php

class Template{

	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->load->library('parser');

		if (!isset($this->CI->template_vars))
		{
			$this->CI->template_vars = array();
		}
	}
	
	public function render()
	{
		$content = $this->output->get_output();
		
		if ($this->config->item('disable_template') === TRUE)
		{
			return $this->output->_display($content);
		}
		
		$template_name = $this->config->item('template');
		
		$layout = $this->get_template_content($template_name);

		$this->CI->template_vars['body'] = $this->output->get_output();

		$this->wrap_content();
				
		$content = $this->parser->parse_string($layout, $this->CI->template_vars);
		
		# Send cache control headers.
		$this->CI->output->set_header("Cache-Control: no-cache, must-revalidate"); // HTTP/1.1
		$this->CI->output->set_header("Pragma: no-cache");
		$this->CI->output->set_header("Expires: Mon, 26 Jul 1997 05:00:00 GMT"); // Date in the past

		# Use the default _display() function to include all it's goodies like profiling.
		$this->CI->output->_display($content);
	}
	
	protected function get_template_content($template_name = FALSE)
	{
		if ($template_name === FALSE)
		{
			return '{body}';
		}
		else
		{
			$template_path = APPPATH . 'views/templates/' . $template_name . '.php';
			
			if (!file_exists($template_path))
			{
				show_error('Specified template does not exist: ' . $template_name);
			}
			else
			{
				ob_start();
				include $template_path;
				return ob_get_clean();
			}
		}
	}

	/**
	 * Sometimes you want to wrap your view content in additional HTML before embedding in a template.
	 * The template to use is defined in content_wrapper config option 
	 */
	public function wrap_content()
	{
		$wrapper = $this->get('content_wrapper');
		
		if (!$wrapper)
		{
			$wrapper = $this->config->item('content_wrapper');
			$this->set('wrapper', $wrapper);
		}

		if ($wrapper)
		{
			$this->CI->template_vars['body'] = $this->parser->parse($wrapper, $this->CI->template_vars, TRUE);
		}
	}
	
	public function set($name, $value)
	{
		$this->CI->template_vars[$name] = $value;
	}

	public function get($name)
	{
		if (array_key_exists($name, $this->CI->template_vars))
		{
			return $this->CI->template_vars[$name];
		}
		else
		{
			return FALSE;
		}
	}

	/**
	 * __get
	 *
	 * Allows access CI's loaded classes using the same yntax as controllers.
	 *
	 * @param   string
	 * @access private
	 */
	public function __get($key)
	{
	    $CI =& get_instance();
	    return $CI->$key;
	}
}