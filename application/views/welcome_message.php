<?php
require(APPPATH.'libraries/vendor/autoload.php');
require(APPPATH.'libraries/nitlab_api.php');
require(APPPATH.'views/templates/header.php');
$api  = new NitlabAPI\NitlabAPI();
?>

<script type="text/javascript" src="/assets/js/sortedtable.js"></script>
<script type="text/javascript" src="/assets/js/app_init.js"></script>

<div id="tabs">
  <ul>
    <li><a href="/channels"> Channels </a></li>
    <li><a href="/nodes"> Nodes </a></li>
    <li><a href="/reservednodes"> Reserved Nodes </a></li>
    <li><a href="/reservedchannels"> Reserved Channels </a></li>
    <li><a href="/slices"> Slices </a></li>
    <li><a href="/users"> Users </a></li>
  </ul>
</div>
<?php
include(APPPATH.'views/templates/footer.php');
?>
