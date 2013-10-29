<?php
header('Content-type: text/html');
?>
<script type="text/javascript" src="<?=base_url()?>assets/js/sortedtable.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/app_init.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $(".editable").editable();
  $("#createchanbtn").click(function() {
    var urls = {"add": "<?=site_url()?>/channels/add", "update": "<?=site_url()?>/channels/update"};
    var table = "#channels";
    var form = "#new_channel_form";
    var primary_key = "channel_id";
    create(urls, table, form, primary_key);
    $("#channels_dialog").modal("hide");
  });

  $("#cancelchanbtn").click(function(){$("#channels_dialog").modal("hide")});

  $(".deletechan").click(function() {
    $.post("<?=site_url()?>/channels/delete", {"channel_id":$(this).attr("data-pk")});
    $(this).parent().parent().remove();
    $("#channels").trigger("update");
  });
  $("#deleteallchannels").click(function() {
    $(".channels").each(function(key, value) {
      $(this).remove();
    });
    $("#channels").trigger("update");
  });
});
</script>

<table id="channels" class="table table-striped tablesorter">
  <thead>
    <tr>
      <th>Modulation</th>
      <th>Channel</th>
      <th>Frequency(MHz)</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($channels as $c) {?>
      <tr class="channels">
        <td>
          <a href="#" data-type="text" data-pk="<?=$c['channel_id']?>" data-name="modulation" data-url="<?=site_url()?>/channels/update" class="editable editable-click"><?=$c['modulation']?></a>
        </td>
        <td>
          <a href="#" data-type="text" data-pk="<?=$c['channel_id']?>" data-name="channel" data-url="<?=site_url()?>/channels/update" class="editable editable-click"><?=$c['channel']?></a>
        </td>
        <td>
          <a href="#" data-type="text" data-pk="<?=$c['channel_id']?>" data-name="frequency" data-url="<?=site_url()?>/channels/update" class="editable editable-click"><?=$c['frequency']?></a>
        </td>
        <td>
        <input value="remove" class="deletechan btn btn-small" type="button" data-pk="<?=$c['channel_id']?>" name="delete_channel_id"></input>
        </td>
      </tr>
    <?php } ?>
    </script>
  </tbody>
  <tfoot>
    <tr class="channel">
      <th colspan="7" class="pager form-horizontal tablesorter-pager" data-column="0">
        <button type="button" class="btn first disabled"><i class="icon-step-backward"></i></button>
        <button type="button" class="btn prev disabled"><i class="icon-arrow-left"></i></button>
        <span class="pagedisplay">1 - 10 / 50 (50)</span> <!-- this can be any element, including an input -->
        <button type="button" class="btn next"><i class="icon-arrow-right"></i></button>
        <button type="button" class="btn last"><i class="icon-step-forward"></i></button>
        <select class="pagesize input-mini" title="Select page size">
          <option selected="selected" value="10">10</option>
          <option value="20">20</option>
          <option value="30">30</option>
          <option value="40">40</option>
        </select>
        <select class="pagenum input-mini" title="Select page number"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select>
      </th>
      <th>
        <button type="button" data-toggle="modal" data-target="#channels_dialog" id="addChannel" class="btn-add btn btn-primary">Add</button>
        <div id="channels_dialog" class="modal hide fade in">
          <div class="modal-header">
          </div>
          <div class="modal-body">
          <form id="new_channel_form" action="<?=site_url()?>/channels/add" method="POST">
            <fieldset>
              <label for="modulation">Modulation</label>
              <input type="text" name="modulation" id="modulation" class="text ui-widget-content ui-corner-all" />
              <label for="channel">Channel</label>
              <input type="text" name="channel" id="channel" value="" class="text ui-widget-content ui-corner-all" />
              <label for="frequency">Frequency</label>
              <input type="frequency" name="frequency" id="frequency" value="" class="text ui-widget-content ui-corner-all" />
            </fieldset>
            </form>
          </div>
          <div class="modal-footer">
            <input id="createchanbtn" type="button" class="btn btn-primary" value="Create"/>
            <input id="cancelchanbtn" type="button" value="Cancel"/>
          </div>
        </div>
      </th>
    </tr>
  </tfoot>
</table>
