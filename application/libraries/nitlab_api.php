<?php
namespace NitlabAPI;

class NitlabAPI {

  public $xmlrpc_dir = 'xmlrpc-3.0.0.beta/lib/';

  private $xmlrpcserver_ip = '83.212.32.136';
  private $xmlrpcserver_request = '/RPC2';
  private $xmlrpcserver_port = 8084;
  private $client;


  function __construct() {
    require_once($this->xmlrpc_dir."xmlrpc.inc");
    $this->client = new \xmlrpc_client($this->xmlrpcserver_request, $this->xmlrpcserver_ip, $this->xmlrpcserver_port);
  }
  /************************** get methods **************************/


  //getNodes(Auth, filter, retValue) ----->[{reservation_id,slice_id,start_time,end_time,node_id},…]
  function getNodes($filter, $retValue){
      $getNodes = new \xmlrpcmsg('scheduler.server.getNodes');
      $filter_xmlrpc = php_xmlrpc_encode($filter);
      $getNodes->addParam($filter_xmlrpc, "struct");
      $getNodes->addParam(new \xmlrpcval(array(), "array"));
      return $this->api_call($getNodes);
  }


  // //getChannels(Auth, filter, retValue) ----->[{reservation_id,slice_id,start_time,end_time,node_id},…]
  function getChannels($filter, $retValue){
      $getChannels = new \xmlrpcmsg('scheduler.server.getChannels');
      $filter_xmlrpc = php_xmlrpc_encode($filter);
      $getChannels->addParam($filter_xmlrpc, "struct");
      $getChannels->addParam(new \xmlrpcval(array(), "array"));
      return $this->api_call($getChannels);
  }


  // getTestbedInfo(Auth, filter, retValue) ----->[{reservation_id,slice_id,start_time,end_time,node_id},…]
  //No params
  function getTestbedInfo($filter, $retValue){
      $getTestbedInfo = new \xmlrpcmsg('scheduler.server.getTestbedInfo');
      $getTestbedInfo->addParam(array(), "struct");
      $getTestbedInfo->addParam(array(), "array");
      return $this->api_call($getTestbedInfo);
  }


  //getReservedNodes(Auth, filter, retValue) ----->[{reservation_id,slice_id,start_time,end_time,node_id},…]
  function getReservedNodes($filter, $retValue){
      $getReservedNodes = new \xmlrpcmsg('scheduler.server.getReservedNodes');
      $filter_xmlrpc = php_xmlrpc_encode($filter);
      $getReservedNodes->addParam($filter_xmlrpc, "struct");
      $getReservedNodes->addParam(new \xmlrpcval(array(), "array"));
      return $this->api_call($getReservedNodes);
  }


  // getReservedChannels(Auth, filter, retValue) ----->[{reservation_id,slice_id,start_time,end_time,node_id},…]
  //TODO : Does not work
  //NO params
  function getReservedChannels($filter, $retValue){
      $getReservedChannels = new \xmlrpcmsg('scheduler.server.getReservedChannels');
      return $this->api_call($getReservedChannels);
  }


  // //getSlices(Auth, filter, retValue) ----->[{reservation_id,slice_id,start_time,end_time,node_id},…]
  //TODO : Does not work
  //NO params
  function getSlices($filter, $retValue){
      $getSlices = new \xmlrpcmsg('scheduler.server.getSlices');
      $getSlices->addParam(new \xmlrpcval(array(), "struct"));
      $getSlices->addParam(new \xmlrpcval(array(), "array"));
      return $this->api_call($getSlices);
  }


  //getUsers(Auth, filter, retValue) ----->[{reservation_id,slice_id,start_time,end_time,node_id},…]
  //TODO : Does not work
  //No params
  function getUsers($filter, $retValue){
      $getUsers = new \xmlrpcmsg('scheduler.server.getUsers');
      return $this->api_call($getUsers);
  }


  /***************** Add methods ***************/


  function reserveNodes($nodesInfo) {
      $res_xml = php_xmlrpc_encode($nodesInfo);
      $reserveNodes = new \xmlrpcmsg('scheduler.server.reserveNodes');
      $reserveNodes->addParam($res_xml, "struct");
      return $this->api_call($reserveNodes);
  }


  function reserveChannels($channelsInfo) {
      $res_xml = php_xmlrpc_encode($channelsInfo);
      $reserveChannels = new \xmlrpcmsg('scheduler.server.reserveChannels');
      $reserveChannels->addParam($res_xml, "struct");
      return $this->api_call($reserveChannels);
  }


  function addUser($userInfo) {
      $res_xml = php_xmlrpc_encode($userInfo);
      $addUser = new \xmlrpcmsg('scheduler.server.addUser');
      $addUser->addParam($res_xml, "struct");
      return $this->api_call($addUser);
  }


  function addUserToSlice($userToSliceInfo) {
      $res_xml = php_xmlrpc_encode($userToSliceInfo);
      $addUserToSlice = new \xmlrpcmsg('scheduler.server.addUserToSlice');
      $addUserToSlice->addParam($res_xml, "struct");
      return $this->api_call($addUserToSlice);
  }


  function addUserKey($userKeyInfo) {
      $res_xml = php_xmlrpc_encode($userKeyInfo);
      $addUserKey = new \xmlrpcmsg('scheduler.server.addUserKey');
      $addUserKey->addParam($res_xml, "struct");
      return $this->api_call($addUserKey);
  }


  function addSlice($sliceInfo) {
      $res_xml = php_xmlrpc_encode($sliceInfo);
      $addSlice = new \xmlrpcmsg('scheduler.server.addSlice');
      $addSlice->addParam($res_xml, "struct");
      return $this->api_call($addSlice);
  }


  function addNode($nodeInfo) {
      $res_xml = php_xmlrpc_encode($nodeInfo);
      $addNode = new \xmlrpcmsg('scheduler.server.addNode');
      $addNode->addParam($res_xml, "struct");
      return $this->api_call($addNode);
  }


  function addChannel($channelInfo) {
      $res_xml = php_xmlrpc_encode($channelInfo);
      $addChannel = new \xmlrpcmsg('scheduler.server.addChannel');
      $addChannel->addParam($res_xml, "struct");
      return $this->api_call($addChannel);
  }


  /*********** Delete methods ****************************/


  function deleteKey($keyInfo) {
      $res_xml = php_xmlrpc_encode($keyInfo);
      $deleteKey = new \xmlrpcmsg('scheduler.server.deleteKey');
      $deleteKey->addParam($res_xml, "struct");
      return $this->api_call($deleteKey);
  }


  function deleteNode($nodeInfo) {
      $res_xml = php_xmlrpc_encode($nodeInfo);
      $deleteNode = new \xmlrpcmsg('scheduler.server.deleteNode');
      $deleteNode->addParam($res_xml, "struct");
      return $this->api_call($deleteNode);
  }


  function deleteUser($userInfo) {
      $res_xml = php_xmlrpc_encode($userInfo);
      $deleteUser = new \xmlrpcmsg('scheduler.server.deleteUser');
      $deleteUser->addParam($res_xml, "struct");
      return $this->api_call($deleteUser);
  }


  function deleteUserFromSlice($userSliceInfo) {
      $res_xml = php_xmlrpc_encode($userSliceInfo);
      $deleteUserFromSlice = new \xmlrpcmsg('scheduler.server.deleteUserFromSlice');
      $deleteUserFromSlice->addParam($res_xml, "struct");
      return $this->api_call($deleteUserFromSlice);
  }


  function deleteSlice($sliceInfo) {
      $res_xml = php_xmlrpc_encode($sliceInfo);
      $deleteSlice= new \xmlrpcmsg('scheduler.server.deleteSlice');
      $deleteSlice->addParam($res_xml, "struct");
      return $this->api_call($deleteSlice);
  }


  function deleteChannel($channelInfo) {
      $res_xml = php_xmlrpc_encode($channelInfo);
      $deleteChannel= new \xmlrpcmsg('scheduler.server.deleteChannel');
      $deleteChannel->addParam($res_xml, "struct");
      return $this->api_call($deleteChannel);
  }


  function releaseNodes($reservation) {
      $res_xml = php_xmlrpc_encode($reservation);
      $releaseNodes = new \xmlrpcmsg('scheduler.server.releaseNodes');
      $releaseNodes->addParam($res_xml, "struct");
      return $this->api_call($releaseNodes);
  }


  function releaseChannels($reservation) {
      $res_xml = php_xmlrpc_encode($reservation);
      $releaseChannels = new \xmlrpcmsg('scheduler.server.releaseChannels');
      $releaseChannels->addParam($res_xml, "struct");
      return $this->api_call($releaseChannels);
  }


  function updateNode($nodeInfo) {
      $res_xml = php_xmlrpc_encode($nodeInfo);
      $updateNode = new \xmlrpcmsg('scheduler.server.updateNode');
      $updateNode->addParam($res_xml, "struct");
      return $this->api_call($updateNode);
  }


  function updateChannel($channelInfo) {
      $res_xml = php_xmlrpc_encode($channelInfo);
      $updateChannel = new \xmlrpcmsg('scheduler.server.updateChannel');
      $updateChannel->addParam($res_xml, "struct");
      return $this->api_call($updateChannel);
  }


  function updateUser($userInfo) {
      $res_xml = php_xmlrpc_encode($userInfo);
      $updateUser = new \xmlrpcmsg('scheduler.server.updateUser');
      $updateUser->addParam($res_xml, "struct");
      return $this->api_call($updateUser);
  }


  function updateSlice($sliceInfo) {
      $res_xml = php_xmlrpc_encode($sliceInfo);
      $updateSlice = new \xmlrpcmsg('scheduler.server.updateSlice');
      $updateSlice->addParam($res_xml, "struct");
      return $this->api_call($updateSlice);
  }


  function updateReservedNodes($reservationInfo) {
      $res_xml = php_xmlrpc_encode($reservationInfo);
      $updateReservedNodes = new \xmlrpcmsg('scheduler.server.updateReservedNodes');
      $updateReservedNodes->addParam($res_xml, "struct");
      return $this->api_call($updateReservedNodes);
  }


  function updateReservedChannels($reservationInfo) {
      $res_xml = php_xmlrpc_encode($reservationInfo);
      $updateReservedChannels = new \xmlrpcmsg('scheduler.server.updateReservedChannels');
      $updateReservedChannels->addParam($res_xml, "struct");
      return $this->api_call($updateReservedChannels);
  }


  function getServerTime() {
    $serverTime = new \xmlrpcmsg('scheduler.server.getServerTime');
    return $this->api_call($serverTime);
  }


  /********** Private Functions **************************/


  /* Makes an api_call to the api */
  function api_call($xmlrpcmsg) {
      $response = $this->client->send($xmlrpcmsg);
      return php_xmlrpc_decode($response->val);
  }
}
?>
