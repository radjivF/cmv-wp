/*global jQuery:false*/
window.jQuery = window.$ = jQuery;

var BwpbBlocker = {
    
    parse: function() {
        this.doAjax( this.getContent() );
    },
    
    getContent: function() {
        
        if( typeof tinymce !== 'undefined' ) {
            var editor = tinymce.get('content');
            return ( editor && editor instanceof tinymce.Editor ) ? editor.getContent() : $('#content').val();
        }
        return;
    },
    
    emptyBlocks: function() {
        $('#bwpb .bwpb-blocks').empty();
    },
    
    doAjax: function( c ) {
        
        var self = this;
        
        Bwpb.loading();
        
        $.ajax({
            type: "POST",
            url: bwpb_admin_root.ajax,
            data: {
                'action'        : '__parse_shortcode',
                'editor_content': c
            },
            dataType: "json",
            success: function( data ) {
                
                self.parseAjaxData( data );
                
                // map tree
                BwpbMapper.mapperTree( false );
                
                BwpbShortcoder.getShortcode( BwpbMapper.bw_mapper_tree, false );
                
                BwpbBlocker.finishAjax();
                
            }
        });
        
    },
    
    finishAjax: function() {
        
        Bwpb.loaded();
        Bwpb.elementsInit();
        Bwpb.welcomeCheck();
        this.checkNonBuilderContent();
        Bwpb.reloadBlocks();
        
    },
    
    checkNonBuilderContent: function( s ) {
        
        if( BwpbShortcoder.s === '' && this.getContent() !== '' ) {
            
            Bwpb.singleModule( 'bw_text',
                Bwpb.singleModule( 'bw_column',
                    Bwpb.singleModule( 'bw_row' )
                ), false, {'content': this.getContent() }
            );
            
            Bwpb.reload();
        }
        
    },
    
    parseAjaxData: function( data ) {
        
        var self = this;
        
        for( var i = 0; i < data.length; i++ ) {
            self.parseAjaxItem( data[i] );
        }
        
    },
    
    parseAjaxItem: function( item ) {
        
        var modules = $.parseJSON( window.bwpb_data.map );
        
        if( typeof modules[item.base] === 'object' ) {
            
            // unique id
            var uid = item.uid;
            
            // fix for empty params
            var emptyParams = $.extend( true, {}, modules[item.base].params );
            var emptyArray = {};
            var is_content_param = false;
            for (var k in emptyParams) {
                if( typeof modules[item.base].params[k].is_content !== 'undefined' ) {
                    is_content_param = modules[item.base].params[k].param_name;
                }
                emptyArray[k] = ( typeof item.params[k] !== 'undefined' ) ? item.params[k] : '';
            }
            
            // is_content
            if( typeof item.is_content !== 'undefined' && typeof item.children !== 'undefined' ) {
                emptyArray[is_content_param] = item.children;
            }
            
            // map data
            BwpbMapper.mapperData( uid, modules[item.base], /*item.params*/ emptyArray );
            
            //update block data
            this.updateParsedData( uid, item );
            
            Bwpb.pushBlock( uid, item.base, item.parent_id, false, item.params );
            
            if( item.children !== '' && typeof item.children == 'object') {
                this.parseAjaxData( item.children );
            }
            
        }else{
            console.log('The shortcode "' + item.base + '" is not owned by bwpb.');
        }
        
    },
    
    updateParsedData: function( uid, item ) {
        
        if( typeof item.params !== 'undefined' ) {
            
            var params = item.params;
            
            if( typeof params !== 'undefined' ) {
                for (var key in params) {
                    BwpbMapper.updateMapperData( uid, key, params[key] );
                }
            }
            
        }
        
    }
    
}