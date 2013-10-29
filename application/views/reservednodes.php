<script type="text/javascript" src="<?=base_url()?>assets/js/app_init.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/sortedtable.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $("#slices_select").editable({
    dataType: 'json'
  });
  update_active_reservations("<?=site_url()?>/reservednodes/now", "#reservednodes");
  setInterval(function() {
    update_active_reservations("<?=site_url()?>/reservednodes/now", "#reservednodes");
  }, 10000);
  $("body").on("create", function() {
    update_active_reservations("<?=site_url()?>/reservednodes/now", "#reservednodes");
  });
  $(".datetimepicker").datetimepicker({
    timeFormat : 'HH:mm:ss',
    stepHour : 1,
    stepMinute : 30,
    stepSecond : 60
  });
  $(".select_nodes_update").select2({'width' : 'resolve'});
  $("#createresnodebtn").click(function() {
    var urls = {"add": "<?=site_url()?>/reservednodes/add", "update": "<?=site_url()?>/reservednodes/update"};
    var table = "#reservednodes";
    var form = "#new_resnode_form";
    var primary_key = "reservation_id";
    create(urls, table, form, primary_key, false);
    $("#resnodes_dialog").modal("hide");
  });

  $("#cancelresnodebtn").click(function(){$("#resnodes_dialog").modal("hide")});

  $(".deleteresnode").click(function() {
    $.post("<?=site_url()?>/reservednodes/delete", {"reservation_id":$(this).attr("data-pk")});
    $(this).parent().parent().remove();
    $("#reservedNodes").trigger("update");
  });

  $("#deleteallresnodes").click(function() {
    $(".reservednodes").each(function(key, value) {
      $(this).remove();
    });
    $("#reservedNodes").trigger("update");
  });
});
</script>
<table id="reservednodes" class="table">
  <thead>
    <tr>
      <th>Slice Name</th>
      <th>Start Time</th>
      <th>End Time</th>
      <th>Node Name</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($reservedNodes as $key => $rn) {?>
      <tr>
        <td>
          <a id="slices_select" href="#" data-type="select2" data-source="<?=site_url()?>/slices/" data-pk="<?=$rn['reservation_id']?>" class="editable editable-click" data-name="slice_name" data-value="<?=$slice_names[$key]?>"><?=$slice_names[$key]?></a>
        </td>
        <td>
          <a href="#" data-type="datetime" data-pk="<?=$rn['reservation_id']?>" class="editable editable-click" data-name="start_time" ><?=date($this->config->item('date_format'), $rn['start_time'])?></a>
        </td>
        <td>
          <a href="#" data-type="datetime" data-pk="<?=$rn['reservation_id']?>" class="editable editable-click" data-name="end_time" ><?=date($this->config->item('date_format'), $rn['end_time'])?></a>
        </td>
        <td>
          <a href="#" data-type="select2" data-source="<?=site_url()?>/nodes/" class="editable editable-click" data-pk="<?=$rn['reservation_id']?>" data-name="hostname" data-value="<?=$slice_names[$key]?>"><?=$node_names[$key]?></a>
        </td>
        <td>
          <input value="remove" class="deleteresnode btn btn-small" type="button" data-pk="<?=$rn['reservation_id']?>" name="delete_resnode_id"></input>
        </td>
      </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <tr>
      <th colspan="7" class="pager3 form-horizontal tablesorter-pager" data-column="0">
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
        <select class="pagenum3 input-mini" title="Select page number"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select>
      </th>
      <th>
        <button type="button" data-toggle="modal" data-target="#resnodes_dialog" id="addResNode" class="btn-add btn btn-primary">Add</button>
        <div id="resnodes_dialog" class="modal hide fade in">
          <div class="modal-header">
          </div>
          <div class="modal-body">
          <form id="new_resnode_form" action="<?=site_url()?>/reservednodes/add" method="POST">
            <fieldset>
              <label for="slice">Slice</label>
              <select name="slice_id">
                <?php foreach($slices as $s) {?>
                  <option value="<?=$s['slice_id']?>"><?=$s['slice_name']?></option>
                <?php }?>
              </select>
              <label for="start_time">Start Time</label>
              <input class="datetimepicker" type="text" name="start_time">
              <label for="end_time">End Time</label>
              <input class="datetimepicker" type="text" name="end_time">
              <label for="nodes">Nodes</label>
              <select multiple class="select_nodes_update" name="node_ids[]">
                <?php foreach($nodes as $n) {?>
                    <option value="<?=$n['node_id']?>">
                      <?=$n['hostname']?>
                    </option>
                <?php } ?>
              </select>
            </fieldset>
            </form>
          </div>
          <div class="modal-footer">
            <input id="createresnodebtn" type="button" class="btn btn-primary" value="Create"/>
            <input id="cancelresnodebtn" type="button" value="Cancel"/>
          </div>
        </div>
      </th>
    </tr>
  </tfoot>
</table>
<?php
?>

