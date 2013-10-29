<?php
header('Content-type: text/html');
?>
<script type="text/javascript" src="<?=base_url()?>assets/js/sortedtable.js"></script>
<script type="text/javascript" src="<?=base_url()?>assets/js/app_init.js"></script>
<script type="text/javascript">
$(document).ready(function() {
  $(".editable").editable();
  $("#createnodebtn").click(function() {
    var urls = {"add": "<?=site_url()?>/nodes/add", "update": "<?=site_url()?>/nodes/update"};
    var table = "#nodes";
    var form = "#new_node_form";
    var primary_key = "node_id";
    create(urls, table, form, primary_key);
    $("#nodes_dialog").modal("hide");
  });

  $("#cancelnodebtn").click(function(){$("#nodes_dialog").modal("hide")});

  $(".deletenode").click(function() {
    $.post("<?=site_url()?>/nodes/delete", {"node_id":$(this).attr("data-pk")}); 
    //TODO : This check fails
    // alert(parseInt(data.toString()));
    // if(parseInt(data.toString()) == 0) {
      $(this).parent().parent().remove();
      $(this).trigger("update");
    // }
  });

  $("#deleteallnodes").click(function() {
    $(".nodes").each(function(key, value) {
      print = $(this);
      $(this).remove();
    });
    $(this).trigger("update");
  });

});
</script>
<table id="nodes" class="table table-striped tablesorter">
  <thead>
    <tr>
      <th>Name</th>
      <th>Type</th>
      <th>Floor</th>
      <th>View</th>
      <th>Wall</th>
      <th>X</th>
      <th>Y</th>
      <th>Z</th>
    </tr>
  </thead>
  <tbody>
    <?php foreach($nodes as $n) {?>
      <tr class="nodes">
        <td> 
          <a href="#" data-type="text" data-pk="<?=$n['node_id']?>" data-name="hostname" data-url="<?=site_url()?>/nodes/update" class="editable editable-click"><?=$n['hostname']?></a>
        </td>
        <td>
          <a href="#" data-type="text" data-pk="<?=$n['node_id']?>" data-name="node_type" data-url="<?=site_url()?>/nodes/update" class="editable editable-click"><?=$n['node_type']?></a>
        </td>
        <td>
          <a href="#" data-type="text" data-pk="<?=$n['node_id']?>" data-name="floor" data-url="<?=site_url()?>/nodes/update" class="editable editable-click"><?=$n['floor']?></a>
        </td>
        <td>
          <a href="#" data-type="text" data-pk="<?=$n['node_id']?>" data-name="view" data-url="<?=site_url()?>/nodes/update" class="editable editable-click"><?=$n['view']?></a>
        </td>
        <td>
          <a href="#" data-type="text" data-pk="<?=$n['node_id']?>" data-name="wall" data-url="<?=site_url()?>/nodes/update" class="editable editable-click"><?=$n['wall']?></a>
        </td>
        <td>
          <a href="#" data-type="text" data-pk="<?=$n['node_id']?>" data-name="x" data-url="<?=site_url()?>/nodes/update" class="editable editable-click"><?=$n['position']['X']?></a>  
        </td> 
        <td>
          <a href="#" data-type="text" data-pk="<?=$n['node_id']?>" data-name="y" data-url="<?=site_url()?>/nodes/update" class="editable editable-click"><?=$n['position']['Y']?></a>  
        </td> 
        <td>
          <a href="#" data-type="text" data-pk="<?=$n['node_id']?>" data-name="z" data-url="<?=site_url()?>/nodes/update" class="editable editable-click"><?=$n['position']['Z']?></a>  
        </td>
        <td>
          <input value="remove" class="deletenode btn btn-small" type="button" data-pk="<?=$n['node_id']?>" name="delete_node_id"></input>
        </td>
      </tr>
    <?php } ?>
  </tbody>
  <tfoot>
    <tr>
      <th colspan="7" class="pager2 form-horizontal tablesorter-pager" data-column="0">
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
        <select class="pagenum2 input-mini" title="Select page number"><option>1</option><option>2</option><option>3</option><option>4</option><option>5</option></select>
      </th>
      <th>
        <button type="button" data-toggle="modal" data-target="#nodes_dialog" id="addNode" class="btn-add btn btn-primary">Add</button>
        <div id="nodes_dialog" class="modal hide fade in">
          <div class="modal-header">
          </div>
          <div class="modal-body">
          <form id="new_node_form" action="<?=site_url()?>/nodes/add" method="POST">
            <fieldset>
              <label for="hostname">Hostname</label>
              <input type="text" name="hostname" id="hostname" class="text ui-widget-content ui-corner-all" />
              <label for="node_type">Type</label>
              <input type="text" name="node_type" id="node_type" value="" class="text ui-widget-content ui-corner-all" />
              <label for="floor">Floor</label>
              <input type="floor" name="floor" id="floor" value="" class="text ui-widget-content ui-corner-all" />
              <label for="view">View</label>
              <input type="text" name="view" id="view" value="" class="text ui-widget-content ui-corner-all" />
              <label for="wall">Wall</label>
              <input type="text" name="wall" id="wall" value="" class="text ui-widget-content ui-corner-all" />
              <label for="X">X</label>
              <input type="text" name="x" id="x" value="" class="text ui-widget-content ui-corner-all" />
              <label for="Y">Y</label>
              <input type="text" name="y" id="y" value="" class="text ui-widget-content ui-corner-all" />
              <label for="Z">Z</label>
              <input type="text" name="z" id="z" value="" class="text ui-widget-content ui-corner-all" />
            </fieldset>
            </form>
          </div>
          <div class="modal-footer">
            <input id="createnodebtn" type="button" class="btn btn-primary" value="Create"/>
            <input id="cancelnodebtn" type="button" value="Cancel"/>
          </div>
        </div>
      </th>
      <th>
        <button type="button" id="deleteallnodes" class="btn-remove-all btn btn-danger">Remove All</button>
      </th>
    </tr>
  </tfoot>
</table>
