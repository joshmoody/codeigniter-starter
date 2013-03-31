<?php

class Messages{

	function __construct()
	{
		$this->load->library('session');
	}

	function info($message)
	{
		$this->add($message, 'info');
	}
		
	function error($message)
	{
		$this->add($message, 'error');
	}

	function success($message)
	{
		$this->add($message, 'success');
	}

	function add($message, $type = 'info')
	{
		
		$messages = $this->session->userdata('messages');
		
		if (!$messages)
		{
			$messages = array('info' => array(), 'error' => array(), 'success' => array());
		}
		
		$messages[$type][] = $message;
		
		$this->session->set_userdata('messages', $messages);
	}
	
	function get_all($delete = TRUE)
	{
		$messages = $this->session->userdata('messages');
		
		if ($delete === TRUE)
		{
			$this->session->unset_userdata('messages');
		}
		
		return $messages;
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