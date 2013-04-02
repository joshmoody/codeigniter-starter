<?php
// Database DSN.
$config['default_dsn'] = 'mysqli://root:root@localhost/test';

// Which template file to use?  Path should be a sub directory of 'views/templates'
$config['template'] = 'bootstrap/index';

/**
 * Use 'bootstrap' for out of the box Twitter Bootstrap theme, or any of the theme names
 * from the Bootstrap CDN http://www.bootstrapcdn.com/#tab_bootswatch
 */
$config['bootstrap_theme'] = 'bootstrap';

// You can wrap your view in additional HTML before inserting into the template.
$config['content_wrapper'] = 'templates/bootstrap/content';
