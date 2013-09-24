<script type="text/javascript" src="/assets/js/app_init.js"></script>
<script type="text/javascript" src="/assets/js/sortedtable.js"></script>
<script type="text/javascript">
var print;
$(document).ready(function() {
  update_active_reservations("/reservedchannels/now", "#reservedchannels");
  setInterval(function() {
    update_active_reservations("/reservedchannels/now", "#reservedchannels");
  }, 10000);
  $("body").on("create", function() {
    update_active_reservations("/reservedchannels/now", "#reservedchannels");
  });
  $(".datetimepicker").datetimepicker({
    timeFormat : 'HH:mm:ss',
    stepHour : 1,
    stepMinute : 30,
    stepSecond : 60
  });
  $(".select_channels_update").select2({'width' : 'resolve'});
  $("#createreschannelbtn").click(function() {
    var urls = {"add": "/reservedchannels/add", "update": "/reservedchannels/update"};
    var table = "#reservedchannels";
    var form = "#new_reschannel_form";
    var primary_key = "reservation_id";
    create(urls, table, form, primary_key);
    $("#reschannels_dialog").modal("hide");
  });

  $("#cancelreschannelbtn").click(function(){$("#reschannels_dialog").modal("hide")});

  $(".deletereschannel").click(function() {
    print = $(this);
    $.post("/reservedchannels/delete", {"reservation_id":$(this).attr("data-pk")});
      $(this).parent().parent().remove();
      $("#reservedChannels").trigger("update");
    // }
  });

  $("#deleteallreschannels").click(function() {
    $(".reservedchannels").each(function(key, value) {
      $(this).remove();
    });
    $("#reservedChannels").trigger("update");
  });

});
</script>

<table id="reservedchannels" class="table">
  <thead>
    <tr>
      <th>Slice Name</th>
      <th>Start Time</th>
      <th>End Time</th>
      <th>Channel</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($reservedChannels as $key => $rc) {?>
      <tr>
        <td>
          <a href="#" data-type="text" data-pk="<?=$rc['reservation_id']?>" class=""><?=$slice_names[$key]?></a>
        </td>
        <td>
          <a href="#" data-type="datetime" data-pk="<?=$rc['reservation_id']?>" class=""><?=date($this->config->item('date_format'), $rc['start_time'])?></a>
        </td>
        <td>
          <a href="#" data-type="datetime" data-pk="<?=$rc['reservation_id']?>" class=""><?=date($this->config->item('date_format'), $rc['end_time'])?></a>
        </td>
        <td>
          <?php if(!empty($channel_names[$key])) {?>
            <a href=""><?=$channel_names[$key]?></a>
          <?php } ?>
        </td>
        <td>
          <input value="remove" class="deletereschannel btn btn-small" type="button" data-pk="<?=$rc['reservation_id']?>" name="delete_reschannel_id"></input>
        </td>
      </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <tr>
      <th colspan="7" class="pager4 form-horizontal tablesorter-pager" data-column="0">
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
        <select class="pagenum4 input-mini" title="Select page number"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select>
      </th>
      <th>
        <button type="button" data-toggle="modal" data-target="#reschannels_dialog" id="addResChannel" class="btn-add btn btn-primary">Add</button>
        <div id="reschannels_dialog" class="modal hide fade in">
          <div class="modal-header">
          </div>
          <div class="modal-body">
            <form id="new_reschannel_form" action="/reservedchannels/add" method="POST">
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
              <label for="channels">Channels</label>
              <select multiple class="select_channels_update" name="channel_ids[]">
                <?php foreach($channels as $c) {?>
                    <option value="<?=$c['channel_id']?>">
                      <?=$c['channel']?>
                    </option>
                <?php } ?>
              </select>
            </fieldset>
            </form>
          </div>
          <div class="modal-footer">
            <input id="createreschannelbtn" type="button" class="btn btn-primary" value="Create"/>
            <input id="cancelreschannelbtn" type="button" value="Cancel"/>
          </div>
        </div>
      </th>
    </tr>
  </tfoot>
</table>
<?php
?>

