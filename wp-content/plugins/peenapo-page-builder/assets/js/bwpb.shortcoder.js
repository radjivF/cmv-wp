/*global jQuery:false*/
window.jQuery = window.$ = jQuery;

var BwpbShortcoder = {
    
    s: '',
    
    getShortcode: function( arrayEle, append_shortcode ) {
        
        this.clearString();
        
        this.parse( arrayEle );
        
        if( append_shortcode ) {
            this.append();
        }
        
        return this.s;
        
    },
    
    clearString: function() {
        this.s = '';
    },
    
    parse: function( arrayEle ) {
        
        var self = this;
        
        for( var i = 0; i < arrayEle.length; i++ ) {
            
            var element = arrayEle[i];
            self.build( element );
            
        }
        
    },
    
    build: function( element ) {
        
        var self = this;
        var module = BwpbMapper.bw_mapper_data[ element.id ];
        var params = '', content = '';
        
        if(typeof module !== 'undefined' ) {
            for (var key in module.params) {
                var moduleParam = module.params[key];
                if( typeof moduleParam.value !== 'undefined' && moduleParam.value !== '' ) {
                    
                    var setContent = typeof moduleParam.is_content !== 'undefined' ? true : false;
                    
                    if( ! setContent ) {
                        params += self.addParam( moduleParam.param_name, moduleParam );
                    }else{
                        content = moduleParam.value;
                    }
                    
                }
            }
            
            this.s += '[' + module.base + params + ']' + content;
            
            if( element.children.length > 0 ) {
                this.parse( element.children );
            }
            
            this.s += '[/' + module.base + ']';
        }
        
    },
    
    addParam: function( param_name, moduleParam ) {
        
        if( moduleParam.type == 'editor' ) {
            moduleParam.value = Bwpb.wpautop( moduleParam.value );
        }
        
        return ' ' + param_name + '="' + Bwpb.escapeParam( moduleParam.value ) + '"';
    },
    
    append: function() {
        this.setContent( this.s );
    },
    
    setContent: function( c ) {
        if( typeof tinymce !== 'undefined' ) {
            var editor = tinymce.get( 'content' );
            if( editor && editor instanceof tinymce.Editor && ! editor.isHidden() ) {
                editor.setContent( c );
            }else{
                $('textarea#content').val( c );
            }
        }
    }
    
};




