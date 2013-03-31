<?php

class Template{

	protected $CI;
	
	public function __construct()
	{
		$this->CI =& get_instance();
		$this->load->library('parser');
		$this->load->helper('html');

		if (!isset($this->CI->template_vars))
		{
			$this->CI->template_vars = array();
		}
		
		if (!array_key_exists('stylesheets', $this->CI->template_vars))
		{
			$this->CI->template_vars['stylesheets'] = array();
		}

		if (!array_key_exists('scripts', $this->CI->template_vars))
		{
			$this->CI->template_vars['scripts'] = array();
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

		$this->inject_head_content($layout);
		
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
	
	protected function inject_head_content(&$layout)
	{
		if (count($this->CI->template_vars['stylesheets']) > 0)
		{
			$styles = join("\n", $this->CI->template_vars['stylesheets']) . "\n</head>";
			$layout = str_replace('</head>', $styles, $layout);
		}

		if (count($this->CI->template_vars['scripts']) > 0)
		{
			$scripts = join("\n", $this->CI->template_vars['scripts']) . "\n</head>";
			$layout = str_replace('</head>', $scripts, $layout);
		}
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

	/**
	 * Inject a css file into the final page.
	 *
	 * @param $urls - Array of URLS or single URL string.
	 */
	public function stylesheet($urls = array())
	{
		if (!is_array($urls))
		{
			$x = $urls;
			$urls = array();
			$urls[] = $x;
		}

		foreach($urls as $url)
		{
			$this->CI->template_vars['stylesheets'][] = link_tag($url, 'stylesheet', 'text/css');
		}
	}

	/**
	 * Inject a javascript file into the final page.
	 *
	 * @param $urls - Array of URLS or single URL string.
	 */
	public function javascript($urls = array())
	{
		if (!is_array($urls))
		{
			$x = $urls;
			$urls = array();
			$urls[] = $x;
		}
		
		foreach($urls as $url)
		{
			if (!preg_match('/^http/', $url) && !preg_match('/\/\//', $url))
			{
				$url = base_url($url);
			}
			$this->CI->template_vars['scripts'][] = sprintf('<script src="%s"></script>', $url);
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