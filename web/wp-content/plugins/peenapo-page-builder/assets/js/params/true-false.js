$(document).on('click', '.bwpb-true-false', function() {
    var $this = $(this);
    if( $('input', $this).is(':checked') ) {
        $this.addClass('active');
    }else{
        $this.removeClass('active');
    }
});