var create = function(urls, table, form, primary_key, editable) {
    if(typeof(editable) === 'undefined') {
        editable = true;
    }
    $.post(urls['add'], $(form).serialize(), function(json) {
      if(!(json instanceof Object)) {
          json = JSON.parse(json);
      }
      if(!(json instanceof Array)) {
        json = [json];
      }
      $.each(json, function(key, value) {
        row = $(table + " tbody tr:last").clone();
        $(row).css("background-color", "");
        anchors = $(row.find('a'));
        pk = value[primary_key];
        $.each(value, function(key, value) {
            link = $(row.find('*[data-name="' + key + '"]'));
            link.text(value);
            link.attr("data-value", value);
            link.attr("data-pk", pk);
            link.attr("data-url", urls['update']);
            if(editable) {
             link.editable();
            }
        });
        $(table + " tbody").append(row);
        $(table).trigger("update");
      });
    });
    $(".deletechan").click(function() {
        $.post("/channels/delete", {"channel_id":$(this).attr("data-pk")});
        $(this).parent().parent().remove();
        $(table).trigger("update");
    });
};


