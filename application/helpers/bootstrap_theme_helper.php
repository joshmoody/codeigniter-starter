<?php

function bootstrap_theme_url()
{
	$ci =& get_instance();
	$theme = $ci->config->item('bootstrap_theme');
	
	if (!$theme)
	{
		# Use default bootstrap theme from the CDN.
		$theme = 'bootstrap'; 
	}
	
	$theme = strtolower($theme);
	
	if ($theme == 'bootstrap')
	{
		return '//netdna.bootstrapcdn.com/twitter-bootstrap/latest/css/bootstrap-combined.min.css';
	}
	else
	{
		return '//netdna.bootstrapcdn.com/bootswatch/latest/' . $theme . '/bootstrap.min.css';
	}
}