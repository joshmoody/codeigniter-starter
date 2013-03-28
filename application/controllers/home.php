<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Home extends CI_Controller{

	public function __construct()
	{
		parent::__construct();
		$this->template->set('site_title', 'CodeIgniter Starter');
		$this->template->set('page_title', 'CodeIgniter Starter');
	}
	
	public function index()
	{
		$this->load->view('home/index');
	}
	
	public function readme()
	{
		$this->config->set_item('disable_template', TRUE);

		$this->load->helper('file');

		$viewdata = array();
		$viewdata['readme'] = read_file('README.md');
		
		$this->load->view('home/readme', $viewdata);		
	}
	
	public function demoform()
	{
		$this->load->helper('form');
		$this->load->library('form_validation');
		
		if ($this->input->post()){

			if ($this->form_validation->run('home/demoform') === FALSE)
			{
				// Form Errors.
			}
			else
			{
				die('success');
			}
		}
		
		$this->load->view('home/form');
	}
}

/* End of file home.php */
/* Location: ./application/controllers/home.php */