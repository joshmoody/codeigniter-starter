<?php

/**
 * Wrapper around PHP's print_r and var_dump.
 * 
 * Wraps output in HTML pre tag for easier viewing.
 * @access public
 * @param mixed $content (default: NULL)
 * @param string $debug_func (default: 'print_r')
 * @return void
 */
function print_var($content = NULL, $debug_func = 'print_r')
{
	echo '<pre>';
	if ($content === NULL OR $content === FALSE)
	{
		$debug_func = 'var_dump';
	}
	call_user_func($debug_func, $content);
	echo '</pre>';
}