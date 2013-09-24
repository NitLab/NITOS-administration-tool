var highlight_active_reservations = function(table, data) {
    $(table + " tbody tr").each(function(value) {
      $(this).css("background-color", "");
    });
    $(data).each(function(key, value) {
      row = $(table + ' *[data-pk="' + value['reservation_id'] + '"]').parent().parent();
      $(row).css("background-color", "salmon");
    });
};

var update_active_reservations = function(url, table) {
  $.get(url, function(data) {
    highlight_active_reservations(table, data);
  });
};
