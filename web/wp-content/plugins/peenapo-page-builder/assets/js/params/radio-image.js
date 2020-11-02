$(document).on('click', '.bwpb-radio-image-row', function() {
    
    var $thisRow = $(this);
    var $thisInput = $('input[type="radio"]:first', this);
    
    $('#bwpb-panel input[type=radio][name="' + $thisInput.attr('name') + '"]').closest('.bwpb-radio-image-row').removeClass('checked');
    $thisRow.addClass('checked');
    
});