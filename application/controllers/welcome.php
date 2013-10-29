<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Welcome extends CI_Controller {

	function __construct()
	{
		parent::__construct();
	}

	public function index()
	{
		$this->load->config('config');
		$this->load->helper('url');
		$this->load->view('welcome_message');
	}
}

