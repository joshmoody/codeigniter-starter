# CodeIgniter-Starter
Twitter Bootstrap and Bootswatch enabled CodeIgniter skeleton with flexible templating engine, CRUD model operations, and enhanced form validation.

## Why?
I keep finding myself downloading CodeIgniter, then copying various classes from other projects every time I
want to spin up a quick demo, prototype, proof of concept, experiment, etc.

Now I can just clone this project and be up and running with all I need in no time.

***

## Features
- Templating Engine
	- Twitter Bootstrap and Bootswatch Themes
	- Build your own themes
- CRUD Models
	- get()
	- get_by()
	- get\_by\_*()
	- get_all()
	- insert()
	- update()
	- delete()
- Client Side Form Validation using CodeIgniter's Server Side rules.

***

## Configuration
The primary configuration is found in `config/application.php` and contains database connection DSNs and template configuration. These configuration options are discussed below.

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

***

### Built with Bootstrap
The project includes a templating engine pre-configured to work with [Twitter Bootstrap](http://twitter.github.com/bootstrap/). Any of the [Bootswatch Themes](http://bootswatch.com/) available from the [NetDNA Bootstrap CDN](http://www.bootstrapcdn.com/#tab_bootswatch) can be used with a simple configuration change.

To use the default Twitter Bootstrap Theme:

	# config/application.php
	
	$config['bootstrap_theme'] = 'bootstrap'; // Default Twitter Bootstrap Theme

To use one of the Bootswatch Themes:
	
	# config/application.php
	
	$config['bootstrap_theme'] = 'cosmo'; // Bootswatch Theme.

***

### Using the Template Engine
The template engine is loaded automatically.  All you have to do to display your view in the template is load it as usual.
	
	$this->load->view('home/index');

***

### Other Template Features
#### View Variables
Any variables you pass when loading your view will also be available to the template file.

***

#### Passing Global  Variables to The Template Engine
Sometimes you may want to pass "Global" parameters to your views, without the hassle of adding them every time you call `$this->load->view()`. Easy, just call `$this->template->set('name', $value)` from your controller.

	$this->template->set('site_title', 'My Aweseome Site');

***

#### Setting additional stylesheets and javascript
If you want to render additional style sheets or javascript to the `<head>` of the rendered template, do this somewhere in your controller before loading your view:

	$this->template->stylesheet('url/to/stylesheet.css');
	$this->template->javascript('url/to/javascript.js');
* URLS may be fully qualified, or relative to the base url

#### Disable the Template Engine
If you want to disable the template engine for some reason, just change the setting in your config file or in the controller by setting:

	$this->config->set_item('disable_template', TRUE);

***

#### Creating Your Own Templates
Want to roll your own templates?  No problem.

1. Create a directory in views/templates/ with the name you want to call your template.
2. Add a file named "index.php" in the new directory.
	- This file should contain the markup you want to use in your template and
	- A placeholder tag `{body}` where your view body should be injected.

			<!DOCTYPE html>
			<html lang="en">
			<head>
			    <title>CodeIgniter Starter</title>
			    <meta charset="UTF-8">
			</head>
			
			<body>
			{body}
			</body>
			</html>

3. Change the config to use your new template name.

	```$config['template'] = 'mytemplate/index';```
	
*** Tip: Templates work just like regular CodeIgniter views, so you can load partial views as usual from within your template file: ***

	<!DOCTYPE html>
	<html lang="en">
	<head>
	    <title>CodeIgniter Starter</title>
	    <meta charset="UTF-8">
	</head>
	
	<body>
	<?php $this->load->view('home/partials/top_nav');?>
	
	{body}
	</body>
	</html>

***
### CRUD Database Model
Provides methods for easily creating, reading, updating, and deleting data.

#### Model Configuration
Define a database DSN in `config/application.php`

	$config['default_dsn'] = 'mysqli://username:password@localhost/test';


Then create a model that extends `MY_Model`

	// models/Person_model.php
	class Person_model extends MY_Model{
		
		public function __construct()
		{
			parent::__construct();
		}
	}

Then load your model.

	$this->load->model('person_model');

#### Naming conventions.
If you follow convention, the CRUD library will figure out the name of the database table your model references.

1. Model Class name should be singular.
	- Example: "Person_model"
2. Table name should be plural.
	- Example: "people"

If your table name/model name do not follow this convention, you can still use the CRUD model.  Just pass the table name as the first parameter to the parent constructor.

	// models/Person_model.php
	class Person_model extends MY_Model{
		
		public function __construct()
		{
			parent::__construct('persons');
		}
	}

#### Primary Keys
Many of the CRUD features rely on the table primary key.  The default primary key column is "id".  If your primary key is different, set it as class variable
in your model.

	// models/Person_model.php
	class Person_model extends MY_Model{
		
		public $primary = 'rowid';
		
		public function __construct()
		{
			parent::__construct();
		}
	}
	
### Using the CRUD Features.
Once you have your model configured, you can use any of the shortcut methods for interacting with your table.

For all get* operations, an Active Record result object is returned.  See CodeIgniter's [result functions page](http://ellislab.com/codeigniter/user-guide/database/results.html) for more information.

***

#### get($id)
Fetch a row by primary key

	$query = $this->person_model->get(5);
	print $query->row()->firstname;

***

#### get_by($column, $value)

	$query = $this->person_model->get_by('last_name', 'Jones');
	foreach($query->result() as $row)
	{
		print $row->last_name;
	}
	
***

#### get\_by\_*($value)

Overload of the `get_by()` method that allows you to pass the name of the column you wish to filter on as part of the method name.

	$query = $this->person_model->get_by_last_name('Jones');

OR	

	$this->person_model->get_by_first_name('Jim');

***

#### get_all($order_by = FALSE, $limit = FALSE)
Get all rows from the table, optionally ordered by the specified column and limited

	// All records, no ordering or limit
	$this->person_model->get_all();
	
	// All records, ordered by first_name ASCENDING, no limit
	$this->person_model->get_all('first_name');

	// All records, ordered by first_name DESCENDING, no limit
	$this->person_model->get_all('first_name DESC');
	
	// 10 Records, ordered by first_name, limit 10
	$this->person_model->get_all('first_name', 10);
	
	// 10 Records, no sorting, limit 10
	$this->person_model->get_all(FALSE, 10); 

** Note: The `$order_by` parameter accepts any value supported by [CodeIgniter's Active Record](http://ellislab.com/codeigniter/user-guide/database/active_record.html#select).**

***

#### insert($data)
Inserts a record into the table.  $data may be an array or object. The result of an insert operation will be the just-inserted row.

	$data = array('firstname' => 'Josh', 'lastname' => 'Moody');
	$result = $this->person_model->insert($data);

***

#### update($data, $id = FALSE)
Updates records in the table by primary key. The result of an update operation will be the just-updated row.

The primary key may be included in the $data parameter:

	$update = array('phone' => '555-555-5555', 'id' => 1);
	$result = $this->person_model->update($update);

...Or passed in as the 2nd parameter.

	$update = array('phone' => '555-555-5555');
	$result = $this->person_model->update($update, 1);

*** 

#### delete($id)
Deletes a record by primary key. Returns the number of affected results.

	$affected_count = $this->person_model->delete(1);

*** 

#### query($sql, $params = FALSE)
Execute a query on the database connection backing this model.

	$query = $this->person_model->query("SELECT * FROM people WHERE first_name = 'Josh'");

You can also use parameter binding with this method:

	$query = $this->person_model->query("SELECT * FROM people WHERE first_name = ?", array('Josh'));

*** 

#### get\_last\_query()
Returns string containing the last query executed for this database connection.

	$last_query = $this->person_model->get_last_query();
	
*** 

#### get\_last\_error()
Returns object with details on the last error encountered for this database connection.

	$last_error = $this->person_model->get_last_error();
	print $last_error->message;
	print $last_error->query;

***

### Client Side Validation
The extended Form_validation library and form helper included with this project allows you to use the same form validation rules
client side and server side via the jQuery validation plugin.

#### To Use
1. Configure your rules config/form_validation.php as documented in the "Creating Sets of Rules" heading at http://ellislab.com/codeigniter/user-guide/libraries/form_validation.html#savingtoconfig

2. Load the Form Validation Library and Form Helper. In your controller method is a good place.

		$this->load->library('form_validation');
		$this->load->helper('form');

3. At the bottom of your view:

		<?=jquery_validate($config_group);?>

Where $config_group is the name of the rule set you configured in step 1.

Not all CI validation rules have been mapped to jQuery validation rules.  Below are the ones currently available.

 - required
 - min_length
 - max_length
 - exact_length
 - valid_email
 - numeric
 - is_natural

 - valid_url (custom rule)
 - valid_phone (custom rule)
 - valid_zip (custom rule)

#### More Info on Validation 
	- http://ellislab.com/codeigniter/user-guide/libraries/form_validation.html#rulereference
	- http://docs.jquery.com/Plugins/Validation#List_of_built-in_Validation_methods

***

### Messages Library
Sometimes you want to pass a message or messages back to the view to indicate the success or failure of the operation.
To aid in this task, there is messages library that stores informational, error, and success messages in session. There is also a messages function
in `MY_form_helpers.php` to display these using Twitter Bootstrap's alert class.

### To Set Messages

	$this->load->library('messages'); // This library is already auto-loaded in `config/autoload.php`.
	
	$this->messages->error('Oops');
	$this->messages->info('FYI');
	$this->messages->info('Success!');
	
### To display the message in a view:
	
	<?=messages();?>
	

*Note: Once the messages() function has been called, it automatically removes all messages from session.*

***

### Acknowledgments
The following third-party libraries are included in this package:

- https://github.com/appleboy/CodeIgniter-Native-Session