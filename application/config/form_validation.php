<?php
$config = array(
	'home/demoform' => array(

		array(
			'field' => 'firstname',
			'label' => 'First Name',
			'rules' => 'trim|required|min_length[2]|',
		),

		array(
			'field' => 'lastname',
			'label' => 'Last Name',
			'rules' => 'trim|required|min_length[2]',
		),

		array(
			'field' => 'state',
			'label' => 'State',
			'rules' => 'trim|required',
		),

		array(
			'field' => 'address',
			'label' => 'Address',
			'rules' => 'trim|required|min_length[5]',
		),

		array(
			'field' => 'zip',
			'label' => 'Zip Code',
			'rules' => 'trim|valid_zip',
		),
	
		array(
			'field' => 'phone',
			'label' => 'Phone',
			'rules' => 'trim|required|valid_phone',
		),

		array(
			'field' => 'email',
			'label' => 'Email',
			'rules' => 'trim|required|valid_email',
		),
		
		array(
			'field' => 'url',
			'label' => 'Web Site',
			'rules' => 'trim|required|valid_url',
		),
	)
);
