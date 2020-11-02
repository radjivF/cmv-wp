!function($) {
    
    //function bwpbFormat( state ) {
        //console.log( state );
        //return "<i class='fa " + state.id.toLowerCase() + "'/></i>" + state.text + "";
    //}

    $(".bwpb-select2 > select").each(function() {
        $(this).select2({
            language: "en",
            placeholder: "Select",
            allowClear: true,
            //templateResult: bwpbFormat,
            //templateSelection: bwpbFormat,
            escapeMarkup: function(m) { return m; }
        });
    });
}(window.jQuery);