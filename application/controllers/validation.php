<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Validation extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
	}
	
	public function get_rules($rule_set)
	{
		$this->load->library('Form_Validation');
		
		$rules = $this->form_validation->get_rules($rule_set);
	}
}

/* End of file validation.php */
/* Location: ./application/controllers/validation.php */