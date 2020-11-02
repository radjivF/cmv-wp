!function($) {
    
    function bwpbGetFont( $icon, onChange ) {
        
        var fontSelected = $(' > select', $icon).val();
        var $list = $(' > .bwpb-icon-container', $icon);
        
        if( $('#bwpb_font-' + fontSelected).length ) {
            $list.empty().append( $('#bwpb_font-' + fontSelected).html() );
            if( onChange || $(' > input', $icon).val() === '' ) {
                bwpbIconSelect( $icon, 0, fontSelected, false );
            }
        }else{
            alert('This font was not found!');
        }
        
    }
    
    function bwpbIconSelect( $icon, index, font, changeData ) {
        
        if( index < 0 ) { return; }
        
        var $lis = $(' > .bwpb-icon-container li', $icon);
        
        $lis.removeClass('active').eq( index ).addClass('active');
        
        var $iconSelect = $('.bwpb-icon-container li', $icon).eq( index );
        var iconString = $iconSelect.attr('data-value');
        var iconClass = $iconSelect.attr('data-class');
        var iconAll = typeof iconClass !== 'undefined' ? iconClass + ' ' + iconString : iconString;
        // change data font and icon only if icon selected manually.
        if( changeData ) {
            $('.bwpb-icon-container', $icon).attr('data-icon', iconString).attr('data-font', font);
        }
        
        // change input value
        $('> input', $icon).val( font + ',' + iconAll );
        // change label icon
        $('.bwpb-icon-label i', $icon).removeAttr('class').addClass( iconAll );
    }
    
    $(".bwpb-icon-select").each(function() {
        
        var $this = $(this);
        var $container = $('.bwpb-icon-container', $this);
        
        // toggle icon panel
        $('.bwpb-icon-select').on('click', '.bwpb-icon-label, .bwpb-icon-expand', function() {
            $(this).closest('.bwpb-icon-select').toggleClass('icon-expand');
        });
        // bind search
        $('.bwpb-icon-search input').on('keyup', function() {
            var search = $(this).val();
            if( search !== '' ) {
                $('.bwpb-icon-container li').addClass('exclude');
                $('.bwpb-icon-container li[data-value*="' + search + '"]', $this).removeClass('exclude');
                console.log( $('.bwpb-icon-container li[data-value*="' + search + '"]', $this) );
            }else{
                $('.bwpb-icon-container li').removeClass('exclude');
            }
        });
        
        bwpbGetFont( $this, false );
        bwpbIconSelect( $this, $('li', $container).index( $('li[data-value="' + $container.attr('data-icon').replace('fa ', '') + '"]', $container) ), $(' > select', $this).val(), false );
        
        $(' > select', $this).on('change', function() {
            $('.bwpb-icon-search input', $this).val('');
            bwpbGetFont( $this, true );
            
            // select current icon on font chaning
            if( typeof $container.attr('data-icon') !== 'undefined'
                && typeof $container.attr('data-font') !== 'undefined' ) {
                $('li[data-value="' + $container.attr('data-icon') + '"]', $container).trigger('click');
            }
            
        });
        
        $(this).on('click', '.bwpb-icon-container li', function() {
            bwpbIconSelect( $this, $('li', $container).index($(this)), $(' > select', $this).val(), true );
        });
        
        // select current icon
        if( typeof $container.attr('data-icon') !== 'undefined' ) {
            $('li[data-value="' + $container.attr('data-icon') + '"]', $container).trigger('click');
        }
        
    });
    
}(window.jQuery);