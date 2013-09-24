<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
require_once(APPPATH."libraries/nitlab_api.php");
class ReservedNodes extends CI_Controller {


	function __construct()
	{
        parent::__construct();
        $this->api = new NitlabAPI\NitlabAPI();
	}

	public function index()
    {
        $this->load->helper('url');
        $this->load->config('config');
        $reservedNodes = $this->api->getReservedNodes(array(), array());
        $slices = $this->api->getSlices(array(), array());
        $nodes = $this->api->getNodes(array(), array());

        // get slice_names from slice_id
        $slice_names = array();
        foreach($reservedNodes as $rn) {
          foreach($slices as $s) {
            if($rn['slice_id'] == $s['slice_id']) {
              $slice_names[] = $s['slice_name'];
            }
          }
        }

        // get node_names from node_id
        $node_names = array();
        foreach($reservedNodes as $rn) {
          foreach($nodes as $n) {
            if($rn['node_id'] == $n['node_id']) {
              $node_names[] = $n['hostname'];
            }
          }
        }

        $data = array('reservedNodes' => $reservedNodes, 'slice_names' => $slice_names, 'node_names' => $node_names, 'slices' => $slices, 'nodes' => $nodes);
        $this->load->view('reservednodes', $data);
	}
    public function add()
    {
        $TIME_ZONE = 'Europe/Athens';
        date_default_timezone_set($TIME_ZONE );
        $slice_id = $this->input->post('slice_id');
        $start_time = strtotime($this->input->post('start_time'));
        $end_time = strtotime($this->input->post('end_time'));
        $nodes = $this->input->post('node_ids');
        $nodesInfo = array('slice_id' => $slice_id, 'start_time' => $start_time, 'end_time' => $end_time, 'nodes' => $nodes);
        $reservedNodes = $this->api->reserveNodes($nodesInfo);
        $slices = $this->api->getSlices(array('slice_id' => $slice_id), array());

        // get slice name from id
        foreach($slices as $s) {
          if($s['slice_id'] == $slice_id) {
            $slice_name = $s['slice_name'];
            break;
          }
        }

        $retValue = array();
        $reservations = $this->api->getReservedNodes(array(), array());
        $reservation = array();
        if(!empty($reservedNodes)) {
            $last_n_elements = array_slice($reservations, -count($reservedNodes));
            foreach($reservedNodes as $key => $rn) {
                $node = $this->api->getNodes(array("node_id" => $rn ), $retValue);
                $reservation[$key]['hostname'] = $node[0]['hostname'];
                $reservation[$key]['slice_id'] = $slice_id;
                $reservation[$key]['start_time'] = date('d/m/Y H:i', $start_time);
                $reservation[$key]['end_time'] = date('d/m/Y H:i', $end_time);
                $reservation[$key]['slice_name'] = $slice_name;
                $reservation[$key]['reservation_id'] = array_shift($last_n_elements)['reservation_id'];
            }
            // error_log("reservation");
            // error_log(implode(",", $reservation));
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
        $error = $this->api->releaseNodes($reservation);
        //TODO : Error Handling if something goes wrong
        $this->output->set_status_header(200, "ok");
    }

    public function now()
    {
        $reservedNodes = $this->api->getReservedNodes(array(), array());
        $server_time = $this->api->getServerTime();
        $reservedNodesNow = array();
        date_default_timezone_set('Europe/Athens');

        foreach($reservedNodes as $rn) {
          $start_time = $rn['start_time'];
          $end_time = $rn['end_time'];
          if($start_time < $server_time && $end_time > $server_time)
          {
            $reservedNodesNow[] = $rn;
          }
        }
        $this->output->set_content_type('application/json')->set_output(json_encode($reservedNodesNow));
    }
}

