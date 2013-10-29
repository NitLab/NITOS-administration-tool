<?php
require(APPPATH.'libraries/nitlab_api.php');
require(APPPATH.'views/templates/header.php');
$api  = new NitlabAPI\NitlabAPI();
?>


<div id="tabs">
  <ul>
  <li><a href="<?=site_url();?>/nodes"> Nodes </a></li>
  <li><a href="<?=site_url();?>/channels"> Channels </a></li>
  <li><a href="<?=site_url();?>/reservednodes"> Reserved Nodes </a></li>
  <li><a href="<?=site_url();?>/reservedchannels"> Reserved Channels </a></li>
  <li><a href="<?=site_url();?>/slices"> Slices </a></li>
  <li><a href="<?=site_url();?>/users"> Users </a></li>
  </ul>
</div>
<?php
include(APPPATH.'views/templates/footer.php');
?>
