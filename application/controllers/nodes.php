<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH.'libraries/nitlab_api.php');
class Nodes extends CI_Controller {

	function __construct()
	{
        parent::__construct();
        $this->api = new NitlabAPI\NitlabAPI();
	}

	public function index()
    {
        $this->load->helper('url');
        $this->load->config('config');
        $nodes = $this->api->getNodes(array(), array());
        $data = array('nodes' => $nodes);
        $this->load->view('nodes', $data);
	}
    public function add()
    {
        $hostname  = $this->input->get_post('hostname');
        $node_type = $this->input->get_post('node_type');
        $floor = $this->input->get_post('floor');
        $view = $this->input->get_post('view');
        $wall = $this->input->get_post('wall');
        $x = $this->input->get_post('x');
        $y = $this->input->get_post('y');
        $z = $this->input->get_post('z');
        $position =  array('x' => $x, 'y' => $y, 'z' => $z);
        $nodeInfo = array('hostname' => $hostname, 'node_type' => $node_type, 'floor' => $floor, 'view' => $view, 'wall' => $wall, 'position' => $position);
        $node_id = $this->api->addNode($nodeInfo);
        $retValue = array();
        $node = $this->api->getNodes(array("node_id" => $node_id ), $retValue);
        $node[0]["X"] = $node[0]["position"]["X"];
        $node[0]["Y"] = $node[0]["position"]["Y"];
        $node[0]["Z"] = $node[0]["position"]["Z"];
        $this->output->set_content_type('application/json')->set_output(json_encode($node[0]));
    }

    public function update()
    {
        $name = $this->input->post('name');
        $value = $this->input->post('value');
        $pk = $this->input->post('pk');
        $nodeInfo = array("node_id" => $pk, "fields" => array($name => $value));
        $error = $this->api->updateNode($nodeInfo);
        if(!$error) {
          $this->output->set_status_header(200, "ok");
        }
        else {
          $this->output->set_status_header(500, "error");
        }
    }

    public function delete()
    {
        $node_id = $this->input->post('node_id');
        $nodeInfo = array("node_id" => intval($node_id));
        $error = $this->api->deleteNode($nodeInfo);
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
