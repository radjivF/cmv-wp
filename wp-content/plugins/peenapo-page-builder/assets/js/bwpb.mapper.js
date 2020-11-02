/*global jQuery:false*/
window.jQuery = window.$ = jQuery;

var BwpbMapper = {
    
    // object contains all data for blocks.
    bw_mapper_data: {},
    // object contains the tree structure of the blocks.
    bw_mapper_tree: [],
    
    /*-------------------------------*/
    /* MAP DATA
    /*-------------------------------*/
    mapperData: function( uid, data, marge_data ) {
        
        if( marge_data ) {
            Bwpb.margeObjData( data, marge_data );
        }
        
        this.bw_mapper_data[uid] = data;
        
    },
    
    /*-------------------------------*/
    /* MAP TREE
    /*-------------------------------*/
    mapperTree: function( append_shortcode ) {
        
        this.bw_mapper_tree = [];
        
        this.parseBlocks( $('#bwpb .bwpb-blocks'), false );
        
        // build shortcodes
        if( append_shortcode ) {
            
            BwpbShortcoder.getShortcode( this.bw_mapper_tree, append_shortcode );
        }
        
    },
    
    clearMapper: function() {
        this.bw_mapper_data = [];
        this.bw_mapper_tree = [];
    },
    
    clearMapperTree: function() {
        this.bw_mapper_tree = [];
    },
    
    parseBlocks: function( $level, parentObj ) {
        
        var self = this;
        
        var pushToObj = parentObj ? parentObj.children : self.bw_mapper_tree;
        
        var $containerLevel = ( parentObj ) ? $level.find('.bwpb-content:first') : $level;
        
        $containerLevel.children('.bwpb-block').each(function() {
            
            var $e = $(this);
            
            var current = {
                'id'        : $e.attr('data-id'),
                'children'  : []
            };
            
            pushToObj.push( current );
            
            if( $( '.bwpb-block', $e ).length > 0 ) {
                self.parseBlocks( $e, current );
            }
            
        });
        
    },
    
    updateMapperData: function( uid, key, value ) {
        
        if( typeof this.bw_mapper_data[uid] !== 'undefined' && typeof this.bw_mapper_data[uid].params[key] !== 'undefined' ) {
            
            var param = this.bw_mapper_data[uid].params[key];
            
            if( typeof param.value !== 'undefined' ) {
                param.value = value;
            }else{
                param['value'] = value;
            }
        }
        
    }
    
};




