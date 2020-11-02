$('.bwpb-number-slider').each(function() {
    
    var $this = $(this);
    
    var min = parseFloat( $this.attr('data-min') );
    var max = parseFloat( $this.attr('data-max') );
    var step = parseFloat( $this.attr('data-step') );
    var value = parseFloat( $this.attr('data-value') );
    
    if( isNaN( min ) || isNaN( max ) || isNaN( step ) || isNaN( value ) ) {
        min = 0; max = 100; step = 1; value = 0;
    }
    
    $this.slider({
        
        range          : "min",
        min            : min,
        max            : max,
        step           : step,
        value          : value,
        slide: function( event, ui ) {
            
            $('input', $this).val( ui.value );
            $this.closest('.panel-row').find('.bwpb-ns-counter i').html( ui.value );
            
        }
        
    });
    
});