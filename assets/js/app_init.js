$(document).ready(function() {
    $.fn.editable.defaults.mode = 'inline';
    $("#tabs").tabs({
            beforeLoad: function(event, ui) {
                $(".ui-tabs-panel").empty();
                $.fn.spin.presets.flower = {
                    lines: 9,
                    length: 5,
                    width: 3,
                    radius: 5
                };
                $(ui.tab).spin('flower', 'gray');
                ui.jqXHR.error(function() {
                    $(ui.tab).spin(false);
                    ui.panel.html("Couldn't load this tab. Please try again later")
                });
            },
            load: function(event, ui) {
                $(ui.tab).spin(false);
            }
        });
});

