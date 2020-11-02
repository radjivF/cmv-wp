!function($) {
    $(".input-upload-file").each(function() {
        
        var $input = $(this).find('input[type="text"]');

        $(this).find('.select-file-image').bind('click', function(e){
            e.preventDefault();

            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                multiple: false
            });

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on('select', function() {
                attachment = custom_uploader.state().get('selection').first().toJSON();
                var url = attachment.url;
                $input.val( url );
                custom_uploader.close();
            });

            //Open the uploader dialog
            custom_uploader.open();
        });
    });
}(window.jQuery);