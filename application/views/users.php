<?php
header('Content-type: text/html');
?>
<script type="text/javascript" src="<?=base_url()?>assets/js/sortedtable.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $(".editable").editable();
  $("#addUser").prop('disabled', true);
  // $(".deleteuser").prop('disabled', true);
  // $("#deleteallusers").prop('disabled', true);

  $(".user-keys").each(function() {
    $(this).click(function() {
      var div = $(this).parent().find("div").clone();
      inputs = $(div).find("input");
      $(inputs).each(function() {
        $(div).append($("<p>").text($(this).val()));
      });
      $(div).dialog({
        autoOpen: false,
      });
      $(div).dialog("open");
    });
  });

  $("#createuser").click(function() {
    var urls = {"add": "<?=site_url()?>/users/add", "update": "<?=site_url()?>/users/update"};
    var table = "#users";
    var form = "#new_user";
    var primary_key = "user_id";
    create(urls, table, form, primary_key);
    $("#users_dialog").modal("hide");
  });

  $("#canceluserbtn").click(function(){$("#users_dialog").modal("hide")});

  $(".deleteuser").click(function() {
    $.post("<?=site_url()?>/users/delete", {"user_id":$(this).attr("data-pk")});
    //TODO : This check fails
    // alert(parseInt(data.toString()));
    // if(parseInt(data.toString()) == 0) {
      $(this).parent().parent().remove();
      $(this).trigger("update");
    // }
  });

  $("#deleteallusers").click(function() {
    $(".users").each(function(key, value) {
      print = $(this);
      $(this).remove();
    });
    $("#users").trigger("update");
  });
});
</script>

<table id="users" class="table table-striped">
  <thead>
    <tr>
      <th>Username</th>
      <th>email</th>
      <th>keys</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($users as $u) {?>
      <tr>
        <td>
          <a href="#" data-type="text" data-name="username" data-pk="<?=$u['user_id']?>" data-url="<?=site_url()?>/users/update" class="editable editable-click" ><?=$u['username']?></a>
        </td>
        <td>
          <a href="#" data-type="text" data-name="email" data-pk="<?=$u['user_id']?>" data-url="<?=site_url()?>/users/update" class="editable editable-click" ><?=$u['email']?></a>
        </td>
        <td>
          <button type="button" class="user-keys btn btn-primary">Click to View</button>
          <div data-pk="<?=$u['user_id']?>">
            <?php foreach($u['keys'] as $k) {
              if($k != null) {?>
                <input type="hidden" value="<?=$k?>"></input>
              <?php }?>
            <?php } ?>
          </div>
        </td>
        <td>
          <input value="remove" class="deleteuser btn btn-small" type="button" data-pk="<?=$u['user_id']?>" name="delete_user_id"></input>
        </td>
      </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <tr>
      <th colspan="7" class="pager6 form-horizontal tablesorter-pager" data-column="0">
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
        <select class="pagenum6 input-mini" title="Select page number"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select>
      </th>
      <th>
        <button type="button" data-toggle="modal" data-target="#users_dialog" id="addUser" class="btn-add btn btn-primary">Add</button>
        <div id="users_dialog" class="modal hide fade in">
          <div class="modal-header">
          </div>
          <div class="modal-body">
          <form id="new_user_form" action="<?=site_url()?>/users/add" method="POST">
            <fieldset>
              <label for="username">username</label>
              <input type="text" name="username" id="username" class="text ui-widget-content ui-corner-all" />
              <label for="email">Email</label>
              <input type="text" name="email" id="email" value="" class="text ui-widget-content ui-corner-all" />
            </fieldset>
            </form>
          </div>
          <div class="modal-footer">
            <input id="createuserbtn" type="button" class="btn btn-primary" value="Create"/>
            <input id="canceluserbtn" type="button" value="Cancel"/>
          </div>
        </div>
      </th>
    </tr>
  </tfoot>
</table>
