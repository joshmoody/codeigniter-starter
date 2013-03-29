<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Validation extends CI_Controller{

	public function __construct()
	{
		parent::__construct();

		$this->config->set_item('disable_template', TRUE);
		$this->load->library('form_validation');
		$this->load->helper('form');
	}
	
	public function process()
	{
		$config_group = $this->input->get('config_group');
		
		$viewdata = array();
		$viewdata['rules'] = $this->form_validation->jquery_validate_rules($config_group);
		$viewdata['required_fields'] = $this->form_validation->get_required_fields($config_group);
		$viewdata['config_group'] = $config_group;
		
		$content = $this->load->view('templates/jquery_validate/javascript', $viewdata, TRUE);
		$this->output->set_content_type('application/javascript')->set_output($content);
	}
}

/* End of file validation.php */
/* Location: ./application/controllers/validation.php */