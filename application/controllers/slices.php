<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'libraries/nitlab_api.php');
class Slices extends CI_Controller {

	/**
	 * Index Page for this controller.
	 *
	 * Maps to the following URL
	 * 		http://example.com/index.php/welcome
	 *	- or -
	 * 		http://example.com/index.php/welcome/index
	 *	- or -
	 * Since this controller is set as the default controller in
	 * config/routes.php, it's displayed at http://example.com/
	 *
	 * So any other public methods not prefixed with an underscore will
	 * map to /index.php/welcome/<method_name>
	 * @see http://codeigniter.com/user_guide/general/urls.html
	 */

	function __construct()
	{
        parent::__construct();
        $this->api = new NitlabAPI\NitlabAPI();
	}

	public function index()
    {
        $this->load->helper('url');
        $this->load->config('config');
        $slices = $this->api->getSlices(array(), array());
        $users = $this->api->getUsers(array(), array());

        $user_names = array();
        foreach($slices as $s) {
          foreach($users as $u) {
            if(in_array($u['user_id'], $s['user_ids'])) {
              $user_names[$s['slice_id']][] = $u['username'];
            }
          }
        }

        $data = array('slices' => $slices, 'user_names' => $user_names, 'users' => $users);
        $this->load->view('slices', $data);

	}
    public function add()
    {
        $slice_name  = $this->input->get_post('slice_name');
        $user_ids = $this->input->get_post('user_ids');
        error_log(implode(",", $user_ids));
        $sliceInfo = array('slice_name' => $slice_name);
        $slice_id = $this->api->addSlice($sliceInfo);
        foreach($user_ids as $ui) {
            $userToSliceInfo = array('user_id' => $ui, 'slice_id' => $slice_id);
            $error = $this->api->addUserToSlice($userToSliceInfo);
            if($error) {
                $this->output->set_status_header(500, "error")->set_output("error");
                return;
            }
        }
        $userToSliceInfo['slice_name'] = $slice_name;
        $this->output->set_status_header(200);
        $this->output->set_content_type('application/json')->set_output(json_encode($userToSliceInfo));
    }

    public function update()
    {
        $name = $this->input->post('name');
        $value = $this->input->post('value');
        $pk = $this->input->post('pk');
        $user_ids_in_request = $_REQUEST['user_ids'];

        //Do we need to modify slice name?
        if($name) {
            error_log("modifying ".$name);
            $sliceInfo = array("slice_id" => $pk, "fields" => array($name => $value));
            $error = $this->api->updateSlice($sliceInfo);
        }
        if($error) {
          $this->output->set_status_header(500, "error");
          return;
        }
        //If the parameter user_ids exists in the request then we have to update users for this slice
        if(isset($user_ids_in_request)) {
            //get user_ids for this slice
            $slices = $this->api->getSlices();
            foreach($slices as $s) {
                if($s['slice_id'] ==  $pk) {
                    $slice = $s;
                    break;
                }
            }
            $user_ids_in_slice = $slice['user_ids'];

            //Update user_ids for slice based on the user_ids received in the request
            foreach($user_ids_in_request as $uir) {
                if(!in_array($uir, $user_ids_in_slice)) {
                    //id exists in request but not in slice. Add it to slice
                    $userToSliceInfo = array('user_id' => $uir, 'slice_id' => $pk);
                    $error = $this->api->addUserToSlice($userToSliceInfo);
                    if($error) {
                        $this->output->set_status_header(500, "error");
                        return;
                    }
                }
            }
            foreach($user_ids_in_slice as $uis) {
                if(!in_array($uis, $user_ids_in_request)) {
                    //id exists in slice but not in request. Remove it from slice
                    $userToSliceInfo = array('user_id' => $uis, 'slice_id' => $pk);
                    $error = $this->api->deleteUserFromSlice($userToSliceInfo);
                    if($error) {
                        $this->output->set_status_header(500, "error");
                        return;
                    }
                }
            }
        }
        if(!$error) {
          $this->output->set_status_header(200, "ok");
        }
        else {
          $this->output->set_status_header(500, "error");
        }
    }

    public function delete()
    {
        $slice_id = $this->input->post('slice_id');
        $sliceInfo = array("slice_id" => intval($slice_id));
        $error = $this->api->deleteSlice($sliceInfo);
       if(!$error) {
          $this->output->set_status_header(200, "ok");
        }
        else {
          $this->output->set_status_header(500, "error");
        }
    }
}

