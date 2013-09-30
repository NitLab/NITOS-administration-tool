<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'libraries/nitlab_api.php');
class Users extends CI_Controller {

	function __construct()
	{
        parent::__construct();
        $this->api = new NitlabAPI\NitlabAPI();
	}


	public function index()
    {
        $this->load->helper('url');
        $this->load->config('config');
        $users = $this->api->getUsers(array(), array());
        $data = array('users' => $users);
        $this->load->view('users', $data);
	}

    public function add()
    {
        $this->output->set_output("No need to implement this");
    }

    public function update()
    {
        $name = $this->input->post('name');
        $value = $this->input->post('value');
        $pk = $this->input->post('pk');
        $userInfo = array("user_id" => $pk, "fields" => array($name => $value));
        $error = $this->api->updateUser($userInfo);
        if(!$error) {
          $this->output->set_status_header(200, "ok");
        }
        else {
          $this->output->set_status_header(500, "error");
        }
    }

    public function delete()
    {
        $user_id = $this->input->post('user_id');
        $userInfo = array("user_id" => intval($user_id));
        $error = $this->api->deleteUser($userInfo);
        if(!$error) {
          $this->output->set_status_header(200, "ok");
        }
        else {
          $this->output->set_status_header(500, "error");
        }
    }
}

/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */
