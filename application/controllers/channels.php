<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."libraries/nitlab_api.php");

class Channels extends CI_Controller {

	function __construct()
	{
        parent::__construct();
        $this->api = new NitlabAPI\NitlabAPI();
	}

	public function index()
    {
        $this->load->helper('url');
        $this->load->config('config');
        $channels = $this->api->getChannels(array(), array());
        $data = array('channels' => $channels);
        $this->load->view('channels', $data);
	}
    public function add()
    {
        $channel  = $this->input->get_post('channel');
        $frequency = $this->input->get_post('frequency');
        $modulation = $this->input->get_post('modulation');
        $channelInfo = array('channel' => $channel, 'frequency' => $frequency, 'modulation' => $modulation);
        $channel_id = $this->api->addChannel($channelInfo);
        $retValue = array();
        $channel = $this->api->getChannels(array("id" => $channel_id ), $retValue);
        $this->output->set_content_type('application/json')->set_output(json_encode($channel[0]));
    }

    public function update()
    {
        $name = $this->input->post('name');
        $value = $this->input->post('value');
        $pk = $this->input->post('pk');
        $channelInfo = array("channel_id" => $pk, "fields" => array($name => $value));
        $error = $this->api->updateChannel($channelInfo);
        if(!$error) {
          $this->output->set_status_header(200, "ok");
        }
        else {
          $this->output->set_status_header(500, "error");
        }
    }

    public function delete()
    {
        $channel_id = $this->input->post('channel_id');
        $channelInfo = array("channel_id" => intval($channel_id));
        $error = $this->api->deleteChannel($channelInfo);
       if(!$error) {
          $this->output->set_status_header(200, "ok");
        }
        else {
          $this->output->set_status_header(500, "error");
        }
    }
}
