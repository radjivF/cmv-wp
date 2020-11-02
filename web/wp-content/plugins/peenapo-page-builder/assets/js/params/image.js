!function($) {
    $(".input-upload-image").each(function() {
        
        var $input = $(this).find('input[type="text"]');
        var $thumbnail = $('.upload-thumbnail', this);
        var $thumbnailImg = $('.upload-thumbnail img', this);
        
        $(this).find('.after-remove').bind('click', function(e) {
            $thumbnail.removeClass('has-image');
            $thumbnailImg.attr('src', $thumbnailImg.attr('data-placeholder'));
            $input.val('');
            return false;
        });

        $(this).find('.upload-thumbnail').bind('click', function(e){
            e.preventDefault();

            //Extend the wp.media object
            custom_uploader = wp.media.frames.file_frame = wp.media({
                /*title: 'Choose Image',
                button: {
                    text: 'Choose Image'
                },*/
                library: {
                    type: 'image'
                },
                multiple: false
            });

            //When a file is selected, grab the URL and set it as the text field's value
            custom_uploader.on('select', function() {
                attachment = custom_uploader.state().get('selection').first().toJSON();
                console.log(attachment);
                $input.val( attachment.url );
                $thumbnail.addClass('has-image');
                if( typeof attachment.sizes.thumbnail !== 'undefined' ) {
                    $thumbnailImg.attr( 'src', attachment.sizes.thumbnail.url );
                }else{
                    $thumbnailImg.attr( 'src', attachment.url );
                }
                
            });

            //Open the uploader dialog
            custom_uploader.open();
        });
    });
}(window.jQuery);