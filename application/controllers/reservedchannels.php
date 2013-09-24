<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."libraries/nitlab_api.php");
class ReservedChannels extends CI_Controller {

	function __construct()
	{
        parent::__construct();
        $this->api = new NitlabAPI\NitlabAPI();
	}

	public function index()
    {
        $this->load->helper('url');
        $this->load->config('config');
        $reservedChannels = $this->api->getReservedChannels(array(), array());
        $slices = $this->api->getSlices(array(), array());
        $channels = $this->api->getChannels(array(), array());
        // get slice names by slice_id
        $slice_names = array();
        foreach($reservedChannels as $rc) {
          foreach($slices as $s) {
            if($rc['slice_id'] == $s['slice_id']) {
              $slice_names[] = $s['slice_name'];
            }
          }
        }
        // get channel_names by channel_id
        $channel_names = array();
        foreach($reservedChannels as $rc) {
          foreach($channels as $c) {
            if($rc['channel_id'] == $c['channel_id']) {
              $channel_names[] = $c['channel'];
            }
          }
        }

        $data = array('reservedChannels' => $reservedChannels, 'slice_names' => $slice_names, 'channel_names' => $channel_names, 'channels' => $channels, 'slices' => $slices);
        $this->load->view('reservedchannels', $data);
	}
    public function add()
    {
        $TIME_ZONE = 'Europe/Athens';
        date_default_timezone_set($TIME_ZONE );
        $slice_id = $this->input->post('slice_id');
        $start_time = strtotime($this->input->post('start_time'));
        $end_time = strtotime($this->input->post('end_time'));
        $channels = $this->input->post('channel_ids');
        $channelsInfo = array('slice_id' => $slice_id, 'start_time' => $start_time, 'end_time' => $end_time, 'channels' => $channels);
        $reservedChannels = $this->api->reserveChannels($channelsInfo);
        $slices = $this->api->getSlices(array('slice_id' => $slice_id), array());

        // get slice name from id
        foreach($slices as $s) {
          if($s['slice_id'] == $slice_id) {
            $slice_name = $s['slice_name'];
            break;
          }
        }

        $retValue = array();
        $reservations = $this->api->getReservedChannels(array(), array());
        $reservation = array();
        if(!empty($reservedChannels)) {
            $last_n_elements = array_slice($reservations, -count($reservedChannels));
            foreach($reservedChannels as $key => $rc) {
                $channel = $this->api->getChannels(array("id" => $rc ), $retValue);
                $reservation[$key]['channel'] = $channel[0]['channel'];
                $reservation[$key]['slice_id'] = $slice_id;
                $reservation[$key]['start_time'] = date('d/m/Y H:i', $start_time);
                $reservation[$key]['end_time'] = date('d/m/Y H:i', $end_time);
                $reservation[$key]['slice_name'] = $slice_name;
                $reservation[$key]['reservation_id'] = array_shift($last_n_elements)['reservation_id'];
            }
            $this->output->set_output(json_encode($reservation));
        }
        else {
            $this->output->set_status_header(500, "error")->set_output("error");
        }
    }

    public function update()
    {
        //No need to implement this function
    }

    public function delete()
    {
        $reservation_id = $this->input->post('reservation_id');
        $reservation = array("reservation_ids" => array(intval($reservation_id)));
        $error = $this->api->releaseChannels($reservation);
        //TODO : Error Handling if something goes wrong
        $this->output->set_status_header(200, "ok");
    }

    public function now()
    {
        $reservedChannels = $this->api->getReservedChannels(array(), array());
        $server_time = $this->api->getServerTime();
        $reservedChannelsNow = array();
        date_default_timezone_set('Europe/Athens');

        foreach($reservedChannels as $rc) {
          $start_time = $rc['start_time'];
          $end_time = $rc['end_time'];
          if($start_time < $server_time && $end_time > $server_time)
          {
            $reservedChannelsNow[] = $rc;
          }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($reservedChannelsNow));
    }
}

