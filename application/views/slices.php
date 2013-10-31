<?php
header('Content-type: text/html');
?>

<script type="text/javascript" src="<?=base_url()?>assets/js/sortedtable.js"></script>

<script type="text/javascript">
$(document).ready(function() {
    $(".editable").editable();
    $(".updateSliceBtn").click(function() {
    var $form = $(this).parent().parent().parent().find('.slice_form');
    $.post("<?=site_url()?>/slices/update", $form.serialize(), function(json) {
    });
  });
  $("select.select_users_create").select2({'width' : 'resolve'});
  $("select.select_users_update").select2({'width' : 'resolve'});
  $(".slice_names_btn").each(function() {
    var $dialog = $(this).parent().find(".slice_form").dialog({autoOpen: false});
    $(this).click(function() {
      $dialog.dialog('open');
    });
  });
  $("#createslicebtn").click(function() {
    var urls = {"add": "<?=site_url()?>/slices/add", "update": "<?=site_url()?>/slices/update"};
    var table = "#slices";
    var form = "#new_slice_form";
    var primary_key = "slice_id";
    create(urls, table, form, primary_key);
    $("#slices_dialog").modal("hide");
  });

  $("#cancelslcdlgbtn").click(function(){$(".slice_names_dialog").modal("hide")});

  $("#cancelslicebtn").click(function(){$("#slices_dialog").modal("hide")});

  $(".deleteslice").click(function() {
    $.post("<?=site_url()?>/slices/delete", {"slice_id":$(this).attr("data-pk")});
    $(this).parent().parent().remove();
    $(this).trigger("update");
  });

  $("#deleteallslices").click(function() {
    $(".slices").each(function(key, value) {
      $(this).remove();
    });
    $(this).trigger("update");
  });
});

</script>
<table id="slices" class="table table-striped">
  <thead>
    <tr>
      <th>Slice Name</th>
      <th>User IDs</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($slices as $s) {?>
      <tr>
        <td>
          <a href="#" data-type="text" data-pk="<?=$s['slice_id']?>" data-name="slice_name" data-url="<?=site_url()?>/slices/update" class="editable editable-click"><?=$s['slice_name']?></a>
        </td>
        <td>
          <button type="button"  data-target="" class="btn-add btn btn-primary slice_names_btn">Click to View</button>
          <div id="slice_names_dialog<?=$s['slice_id']?>" class="modal hide fade in slice_names_dialog">
            <div class="modal-header">
            </div>
            <div class="modal-body">
              <form class="slice_form">
                <fieldset>
                  <input type="hidden" name="pk" value="<?=$s['slice_id']?>">
                  <label for="user_ids">User IDs</label>
                  <select multiple class="select_users_update" name="user_ids[]">
                    <?php foreach($users as $u) {?>
                      <?php if(in_array($u['user_id'], $s['user_ids'])) {?>
                        <option value="<?=$u['user_id']?>" selected>
                          <?=$u['username']?>
                        </option>
                      <?php } else {?>
                        <option value="<?=$u['user_id']?>">
                          <?=$u['username']?>
                        </option>
                      <?php } ?>
                    <?php } ?>
                  </select>
                  <button type="button" class="updateSliceBtn">Update</button>
                </fieldset>
              </form>
            </div>
            <div class="modal-footer">
              <input id="createslcdlgbtn" type="button" class="btn btn-primary" value="Create"/>
              <input id="cancelslcdlgbtn" type="button" value="Cancel"/>
            </div>
          </div>
        </td>
        <td>
          <input value="remove" class="deleteslice btn btn-small" type="button" data-pk="<?=$s['slice_id']?>" name="delete_slice_id"></input>
        </td>
      </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <tr>
      <th colspan="7" class="pager5 form-horizontal tablesorter-pager" data-column="0">
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
        <select class="pagenum5 input-mini" title="Select page number"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select>
      </th>
      <th>
        <button type="button" data-toggle="modal" data-target="#slices_dialog" class="btn-add btn btn-primary">Add</button>
        <div id="slices_dialog" class="modal hide fade in">
          <div class="modal-header"></div>
          <div class="modal-body">
          <form id="new_slice_form" action="<?=site_url()?>/slices/add" method="POST">
              <fieldset>
                <label for="slice_name">Slice Name</label>
                <input type="text" name="slice_name" class="text ui-widget-content ui-corner-all" />
                <label for="user_ids">User IDs</label>
                <select multiple class="select_users_create" name="user_ids[]">
                  <?php foreach($users as $u) {?>
                    <option value="<?=$u['user_id']?>">
                      <?=$u['username'] ?>
                    </option>
                  <?php } ?>
                </select>
              </fieldset>
            </form>
          </div>
          <div class="modal-footer">
            <input id="createslicebtn" type="button" class="btn btn-primary" value="Create"/>
            <input id="cancelslicebtn" type="button" value="Cancel"/>
          </div>
        </div>
      </th>
    </tr>
  </tfoot>
</table>
