/*global jQuery:false, $:false, bwpb_data, BwpbMapper, tinymce, bwpb_admin_root, base64_encode, arrayForm, BwpbShortcoder, BwpbBlocker, ace, currentColHtml, marge_data, uid, i, $li, data, tabId, getChildren */
window.jQuery = window.$ = jQuery;

var $panel = $('.bwpb-panel');
var $panelS = $('#bwpb-panel');
var $panelC = $('#bwpb-cols');
var $panelCSS = $('#bwpb-custom-css');

var Bwpb = {
    
    // status of the page builder.
    status: Boolean( bwpb_data.status ),
    // post id
    post_id: parseInt( bwpb_data.post_id, 10 ),
    // parent modal id when calling a block.
    bw_modal_parent: 0,
    // the latest block id
    latest_block_id: 0,
    // the latest row id
    latest_row_id: 0,
    // the lated col id
    latest_col_id: 0,
    // the id to update
    panel_edit_id: 0,
    // flag for manually added elements
    element_manually: false,
    // will append or prepend on pushBlock
    append_element_top: false,
    // i don\'t remember what this is for..
    customRowId: 0,
    
    start: function() {
        
        this.onLoad();
        this.onReady();
        this.renderBackend();
        this.sortableRows();
        this.callModules();
        this.bind();
        this.openModal();
        this.onSmartResize();
        this.statusCheck();
        
    },
    
    onLoad: function() {
        
        $(window).load(function() {
            //..
        });
        
    },
    
    onReady: function() {
        
        $(document).ready(function() {
            $('.bwpb-ele-categories li:first-child').trigger('click');
        });
        
    },
    
    onSmartResize: function() {
        
        $(window).on("debouncedresize", function() {
            Bwpb.panelSHeight();
        });
        
    },
    
    clearIds: function() {
        this.latest_block_id = 0;
        this.latest_row_id = 0;
        this.latest_col_id = 0;
    },
    
    renderBackend: function() {
        
        this.$bwpbSwitch = $('<div id="bwpb-switch"><span class="bwpb-switch-mode bwpb-switch-mode-pb">' + $('#bwpb').attr('data-classic') + '</span><span class="bwpb-switch-mode bwpb-switch-mode-classic">' + $('#bwpb').attr('data-editor') + '</span></div>').insertAfter('div#titlediv');
        if( ! $('body').hasClass('bwpb-active') ) {
            this.$bwpbSwitch.addClass('active');
        }
        
    },
    
    elementsInit: function() {
        
        this.tab.start();
        
    },
    
    tab: {
        
        start: function() {
            
            $('.bwpb-block.bwpb-tab').each(function() {
                
                var $tab = $(this);
                var $tabList = $('.bwpb-tab-list', this);
                
                $('li:eq(0)', $tabList).addClass('active');
                $('.bwpb-content:first > .bwpb-tab-item', $tab).addClass('bwpb-tab-hidden');
                $('.bwpb-content:first > .bwpb-tab-item:first', $tab).removeClass('bwpb-tab-hidden');
            });
            
            this.bind();
        },
        
        unbind: function() {
            $('.bwpb-tab-list li').unbind('click');
        },
        
        bind: function() {
            
            this.unbind();
            
            $('.bwpb-block.bwpb-tab').each(function() {
                
                var $tab = $(this);
                var $tabList = $('.bwpb-tab-list', this);
                
                $('li', $tabList).on('click', function() {
                    $tabList.find('li').removeClass('active');
                    $(this).addClass('active');
                    $( '.bwpb-content:first > .bwpb-tab-item', $tab ).addClass('bwpb-tab-hidden');
                    $( '.bwpb-content:first > .bwpb-tab-item:eq(' + $( 'li', $tabList ).index( $(this) ) + ')', $tab ).removeClass('bwpb-tab-hidden');
                });
                
            });
            
        }
    },
    
    beforeOpenModal: function( $this, e ) {
        
        var $block = $this.closest('.bwpb-block');
        
        // first hide them all
        $('.bwpb-elements li').hide();
        
        $li = $('#bwpb-modal .bwpb-elements li[data-module="' + $block.attr('data-module') + '"]');
        
        if( typeof $li.attr('data-children') !== 'undefined' ) {
            var dataChildren = $li.attr('data-children');
            if( dataChildren.indexOf(',') == -1 ) {
                $('.bwpb-elements li[data-module="' + dataChildren + '"]').show();
            }else{
                var childrenArr = dataChildren.split(',');
                for ( var i = 0; i < childrenArr.length; i++ ) {
                    $('.bwpb-elements li[data-module="' + childrenArr[i] + '"]').show();
                }
            }
        }else{
            $('.bwpb-elements li').show();
            $('.bwpb-elements li[data-parent]').hide();
        }
        
        // row
        var $row = $('.bwpb-elements li[data-module="bw_row"]');
        if( ! Bwpb.bw_modal_parent ) {
            $row.show();
        }else{
            $row.hide();
        }
        
        var parentData = BwpbMapper.bw_mapper_data[ Bwpb.bw_modal_parent ];
        
        // row inner
        var $rowInner = $('.bwpb-elements li[data-module="bw_row_inner"]');
        $rowInner.hide();
        if( typeof parentData !== 'undefined' ) {
            if( parentData.base == 'bw_column' ) {
                $rowInner.show();
            }
        }
        
    },
    
    openModal: function() {
        
        var self = this;
        
        $(document).on('click', '#bwpb-bg', function( e ) {
            e.preventDefault();
            Bwpb.closeModal();
            Bwpb.panelClose();
        });
        
        $(document).on('click', '#bwpb .bwpb-open-modal', function( e ) {
            
            var $this = $(this);
            var $modal = $('#bwpb-modal');
            var $parentBlock = $this.closest('.bwpb-block');
            
            self.append_element_top = $this.hasClass('append-ele-top');
            
            // close any panel
            self.panelClose();
            
            // set modal id
            Bwpb.bw_modal_parent = $parentBlock.length ? $parentBlock.attr('data-id') : 0;
            
            // check items and show / hide children
            self.beforeOpenModal( $this, e );
            
            $('#bwpb-bg').css('visibility','visible');
            $modal.addClass('visible');
            
        });
        
    },
    
    closeModal: function() {
        $('#bwpb-modal').removeClass('visible');
        $('#bwpb-bg').css('visibility','hidden');
    },
    
    // settings panel
    panelSOpen: function( uid ) {
        
        this.panelClose();
        data = BwpbMapper.bw_mapper_data[ uid ];
        this.panelSSetIcon( data.icon );
        this.panelSetTitle( $panelS, data.name );
        this.panelSLoading();
        this.panelSGetSettings( uid, data );
        this.panelShow();
        this.panelDraggable( $panelS );
        $('#bwpb-bg').css('visibility','visible');
        
    },
    
    panelShow: function() {
        $panelS.addClass( 'open' );
    },
    
    panelSHeight: function() {
        
        var pHeight = ( $(window).height() * 0.88 ) - ( $('.panel-title', $panelS).outerHeight() + $('.panel-footer', $panelS).outerHeight() );
        $('.panel-content', $panelS).css( 'max-height', pHeight );
        $('.panel-content', $panelS).scrollTop(0);
        
    },
    
    panelDraggable: function( $p ) {
        
        $p.draggable({
            handle : '.bwpb-drag-handler'
        });
        
    },
    
    panelClose: function() {
        this.panel_edit_id = 0;
        $panel.removeClass( 'open' );
        if( typeof tinymce !== 'undefined' ) {
            tinymce.remove('.bwpb-tinymce-container textarea');
        }
        $('#bwpb-bg').css('visibility','hidden');
    },
    
    panelSetTitle: function( $p, name ) {
        $('.panel-title', $p).html( name );
    },
    
    panelSSetIcon: function( icon ) {
        $('.panel-header .bwpb-icon', $panelS).addClass( icon );
    },
    
    panelSLoading: function() {
        $panelS.addClass('loading');
    },
    
    panelLoaded: function() {
        $panelS.removeClass('loading');
    },
    
    panelSGetSettings: function( uid, data ) {
        
        var self = this;
        
        $('#bwpb-panel').removeClass('bwpb-has-extra-class');
        $('#bwpb-panel .panel-extra-class-label').html('');
        $('#bwpb-panel').removeClass('panel-extra-input-visible');
        
        $.ajax({
            type: "POST",
            url: bwpb_admin_root.ajax,
            data: {
                'action'        : '__panel_get_settings',
                'mapped_data'   : {'uid': uid, 'data': data}
            },
            success: function( html_response ) {
                
                self.panel_edit_id = uid;
                self.panelLoaded();
                $( '.panel-content', $panelS ).html( html_response );
                self.panelEnqueueScripts();
                self.panelSHeight();
                
                // additional class name
                if( typeof data.params.class !== 'undefined' ) {
                    
                    $('#bwpb-panel').addClass('bwpb-has-extra-class');
                    var extraClassvalue = BwpbMapper.bw_mapper_data[ uid ].params.class.value;
                    $('#bwpb-panel .bwpb-heading-class').val( extraClassvalue );
                    $('#bwpb-panel .panel-extra-class-label').html( extraClassvalue );
                    
                }
                
            }
        });
        
    },
    
    panelEnqueueScripts: function() {
        
        var scripts = $.parseJSON( bwpb_data.enqueue_params_scripts );
        
        for( i = 0; i < scripts.length; i++ ) {
            $.ajax({ url: scripts[i], dataType: "script" });
        }
    },
    
    panelSSave: function() {
        
        this.panelSBeforeSave();
        var uid = this.updateMapOnFields( this.parsePanelSFields() );
        this.updateBlockHtml( uid );
        
    },
    
    panelSBeforeSave: function() {
        
        $('.panel-row[data-type="base64"]', $panelS).each(function() {
            var $row = $(this);
            var $rInput = $('input', $row);
            var rTextareaVal = $('textarea', $row).val();
            $rInput.val( str_replace( '=', '_', base64_encode( rTextareaVal ) ) );
            
        });
        
    },
    
    panelCSave: function() {
        
        var customLayout = $('#bwpb-cols input#bwpb-custom-col-string').val();
        var regex = /^([0-9,])+([\d])$/;
        
        if ( regex.test( customLayout ) ) {
            
            var parseLayout = customLayout;
            var col_exists = true;
            
            for (var i = 0; i < parseLayout.length; i++) {
                if( bwpb_data.col_sizes.indexOf( parseLayout[i] ) == -1 ) {
                    col_exists = false;
                }
            }
            
            if( col_exists && this.customRowId ) {
                
                var $row = $('.bwpb-block[data-id="' + this.customRowId + '"]'),
                    parentId = $row.attr('data-id');
                
                this.switchCol( parseLayout, parentId );
                
            }else{
                
                alert( 'Incorrect layout!' );
                
            }
            
        }else{
            
            alert( 'Incorrect layout!' );
            
        }
        
    },
    
    updateBlockHtml: function( uid ) {
        
        var data = BwpbMapper.bw_mapper_data[ uid ];
        
        for ( var param in data.params ) {
            if( typeof data.params[ param ].holder !== 'undefined' ) {
                $( '.bwpb-block[data-id="' + uid + '"] > .bwpb-block-container > .bwpb-holder > ' + data.params[ param ].holder ).html('');
            }
        }
        
        for ( var param in data.params ) {
            if( typeof data.params[ param ].holder !== 'undefined' ) {
                
                var selector = $( '.bwpb-block[data-id="' + uid + '"] > .bwpb-block-container > .bwpb-holder > ' + data.params[ param ].holder );
                var val = data.params[ data.params[ param ].param_name ].value;
                var value = ( selector.html() === '' ) ? val : ', ' + val;
                
                if( typeof value !== 'undefined' ) {
                    if( data.params[ param ].type === 'editor' ) {
                        value = '<p>' + Bwpb.wpautop( value ) + '</p>';
                    }
                    selector.html( Bwpb.unescapeParam( selector.html() + value ) );
                }
            }
        }
        
    },
    
    escapeParam: function ( value ) {
        if( typeof value == 'string') {
            return value.replace(/"/g, '``');
        }
        return value;
    },
    
    unescapeParam: function ( value ) {
      return value.replace(/(\`{2})/g, '"');
    },
    
    parsePanelSFields: function() {
        
        var inputValues = {};
        
        arrayForm = $('#bwpb-panel-form').serializeArray();
        
        for ( var i = 0; i < arrayForm.length; i++ ) {
            if( typeof inputValues[ arrayForm[i].name ] !== 'undefined' ) {
                inputValues[ arrayForm[i].name ] = inputValues[ arrayForm[i].name ] + ',' + arrayForm[i].value;
            }else{
                // remove empty values from parameters.
                if( arrayForm[i].value !== 'undefined' && arrayForm[i].value !== '' && arrayForm[i].value !== '0') {
                    inputValues[ arrayForm[i].name ] = arrayForm[i].value;
                }
            }
        }
        
        // tinymce get content
        $( '.panel-content .bwpb-tinymce-container.tmce-active', $panelS ).each(function() {
            if( typeof $('textarea:first', this).attr('name') !== 'undefined' ) {
                inputValues[ $('textarea:first', this).attr('name') ] = tinymce.get( $(this).attr('data-editor-id') ).getContent();
            }
        });
        
        return inputValues;
    },
    
    switchEditor: function( e ) {
        var $container = $(e).closest('.bwpb-tinymce-container');
        var tab = $(e).attr('data-switch');
        window.switchEditors.go( $container.attr('data-editor-id'), tab );
        $container.removeClass('tmce-active html-active').addClass( tab + '-active' );
    },
    
    updateMapOnFields: function( fields ) {
        
        var uid = this.panel_edit_id;
        
        if( typeof uid === 'string' ) {
                
            var b = BwpbMapper.bw_mapper_data[ uid ];
            
            // empty params ( if public )
            for (var param in b.params) {
                if( typeof b.params[ param ].value !== 'undefined' ) {
                    if( ! ( typeof b.params[ param ].public !== 'undefined' && b.params[ param ].public === false ) ) {
                        b.params[ param ].value = '';
                    }
                }
            }
            
            for (var field_name in fields) {
                
                if( typeof b === 'object' ) {
                    if( typeof b.params === 'object' ) {
                        if( typeof b.params[ field_name ] === 'object' ) {
                            if( typeof b.params[ field_name ].value === 'undefined' ) {
                                if( fields[ field_name ] !== '' ) {
                                    b.params[ field_name ].value = fields[ field_name ];
                                }
                            }else{
                                b.params[ field_name ].value = fields[ field_name ];
                            }
                        }
                    }
                }
                
            }
            
            // get new shortcode and append to content
            BwpbShortcoder.getShortcode( BwpbMapper.bw_mapper_tree, true );
            // close the panel settings
            this.panelClose();
        }
        
        return uid;
        
    },
    
    bind: function() {
        
        var self = this;
        
        // cols
        $('#bwpb').on('click', '.bwpb-blocks .bwpb-columns-list li', function() {
            
            var cols = $(this).attr( 'data-cols' ),
                $row = $(this).closest('.bwpb-block'),
                parentId = $row.attr('data-id');
            
            self.switchCol( cols, parentId );
            
        });
        $('#bwpb-cols').on('click', '.bwpb-columns-list li', function() {
            
            if( self.customRowId ) {
                
                $('#bwpb-cols input#bwpb-custom-col-string').val( $(this).attr( 'data-cols' ) );
                
                var cols = $(this).attr( 'data-cols' ),
                    $row = $('.bwpb-block[data-id="' + self.customRowId + '"]'),
                    parentId = $row.attr('data-id');
                
                self.switchCol( cols, parentId );
            }
            
        });
        
        // edit options
        $('#bwpb').on('click', '.bwpb-edit', function() {
            var $block = $(this).closest('.bwpb-block');
            var uid = $block.attr('data-id');
            self.panelSOpen( uid );
        });
        
        // close panel
        $panel.on('click', '.button-close', function() {
            self.panelClose();
        });
        
        // close modal
        $('#bwpb-modal').on('click', '.modal-close', function() {
            self.closeModal();
        });
        
        // list elemenets filter by categories
        $('#bwpb-modal').on('click', '.bwpb-ele-categories li', function() {
            $('#bwpb-modal .bwpb-elements li').addClass('hide-by-filter');
            $('.bwpb-ele-categories li').removeClass('active');
            $(this).addClass('active');
            var cat = $(this).attr('data-filter');
            if( typeof cat !== 'undefined' ) {
                $('#bwpb-modal .bwpb-elements li' + cat).removeClass('hide-by-filter');
            }else{
                self.modalShowAll();
            }
        });
        
        // open css extra class
        $panel.on('click', '.panel-extra-class', function() {
            $('#bwpb-panel').addClass('panel-extra-input-visible');
        });
        
        // save settings panel
        $panelS.on('click', '.button-save', function() {
            self.panelSSave();
        });
        
        // save column panel
        $panelC.on('click', '.button-save', function() {
            self.panelCSave();
        });
        
        // disable empty url\'s
        $('#bwpb').on('click', 'a[href="#"]', function(e) {
            e.preventDefault();
        });
        
        // disable text block url\'s
        $('#bwpb').on('click', '.bwpb-html-text a', function(e) {
            e.preventDefault();
        });
        
        // remove column
        $('#bwpb').on('click', '.block-column > .bwpb-block-container > .bwpb-top-column > .bwpb-top-ctrl > .bwpb-trash', function() {
            self.cutColumn( $(this).closest('.block-row'), false );
        });
        
        // remove block
        $('#bwpb').on('click', '.bwpb-blocks .bwpb-trash', function() {
            if( $(this).closest('.bwpb-block').hasClass('block-column') ) { return; }
            self.deleteBlock( $(this) );
        });
        
        // remove tab
        $('#bwpb').on('click', '.bwpb-blocks .bwpb-trash-tab', function() {
            $(this).closest('.bwpb-block.bwpb-tab').find('.bwpb-tab-ctrl .bwpb-add-element').removeClass('bwpb-option-unactive');
            self.deleteTab( $(this) );
        });
        
        // cut column
        $('#bwpb').on('click', '.bwpb-blocks .bwpb-cut', function() {
            self.cutColumn( $(this).closest('.bwpb-block'), true );
        });
        
        // visibility
        $('#bwpb').on('click', '.bwpb-blocks .bwpb-visibility', function() {
            self.visibilityBlock( $(this) );
        });
        
        // duplicate block
        $('#bwpb').on('click', '.bwpb-blocks .bwpb-duplicate', function() {
            self.dusplicateBlock( $(this) );
        });
        $('#bwpb').on('click', '.bwpb-blocks .bwpb-duplicate-tab', function() {
            self.dusplicateTab( $(this) );
        });
        
        // add new tab
        $('#bwpb').on('click', '.bwpb-add-element', function() {
            
            var maxTabs = $(this).closest('.bwpb-block.bwpb-tab').attr('data-max-tabs');
            var currentTabs = $(this).closest('.bwpb-block.bwpb-tab').find('.bwpb-tab-list li').length;
            
            if( maxTabs <= currentTabs ) {
                return;
            }
            
            if( maxTabs <= currentTabs + 1 ) {
                $(this).addClass('bwpb-option-unactive');
            }
            
            var uid = Bwpb.singleModule( $(this).attr('data-toadd'), $(this).closest('.bwpb-block.bwpb-tab').attr('data-id'), true );
            var $newTab = $('.bwpb-block.bwpb-tab-item[data-id="' + uid + '"]');
            $newTab.addClass('bwpb-tab-hidden');
            self.reload();
            self.reloadBlocks();
            $(this).closest('.bwpb-block.bwpb-tab').find('.bwpb-tab-list li[data-tabid="' + uid + '"]').trigger('click');
        });
        
        // switch panel tabs
        $panel.on('click', '.panel-tabs li:not(.active)', function() {
            var $this = $(this).closest('.bwpb-panel');
            $('.panel-tabs li', $this).removeClass('active');
            $(this).addClass('active');
            $('.panel-content > .bwpb-tab', $this).removeClass('tab-visible');
            $('.panel-content > ' + $(this).attr('data-tab'), $this).addClass('tab-visible');
        });
        
        // open custom columns panel
        $('#bwpb').on('click', '.bwpb-col-custom', function(e) {
            e.preventDefault();
            
            self.customRowId = $(this).closest('.block-row').attr('data-id');
            
            self.panelCOpen();
            
        });
        
        // open custom css panel
        $('#bwpb').on('click', '.bwpb-open-custom-css-panel', function( e ) {
            e.preventDefault();
            self.panelCSSOpen();
        });
        
        // save custom css
        $('#bwpb-custom-css').on('click', '.button-save', function( e ) {
            e.preventDefault();
            self.panelCSSSave();
        });
        
        // switch page builder
        this.$bwpbSwitch.on('click', function() {
            $(this).hasClass('active') ? Bwpb.statusEnable() : Bwpb.statusDisable();
        });
        
        // empty all blocks
        $('#bwpb').on('click', '.bwpb-empty-content', function() {
            if ( confirm( "Press Ok to delete all the elements, cancel to leave." ) === true ) {
                $('.bwpb-blocks').empty();
                BwpbMapper.clearMapper();
                BwpbShortcoder.setContent('');
                self.welcomeShow();
            }
        });
        
    },
    
    // check for the current status of the page builder
    statusCheck: function() {
        $('body').hasClass('bwpb-active') ? this.statusEnable() : this.statusDisable();
    },
    
    // enable page builder
    statusEnable: function() {
        
        this.welcomeHide();
        this.$bwpbSwitch.removeClass('active');
        $('.current', this).html('default wp editor');
        if( ! $('#bwpb').hasClass('not-hide-editor') ) { $('#postdivrich').css('display', 'none'); }
        $('#bw_page_builder_section').css('display', 'block');
        $('#bw_status').val(1);
        this.rebuildBlocks();
    },
    
    // disable page builder
    statusDisable: function() {
        
        this.$bwpbSwitch.addClass('active');
        $('.current', this).html('page builder');
        if( ! $('#bwpb').hasClass('not-hide-editor') ) { $('#postdivrich').css('display', 'block'); }
        $('#bw_page_builder_section').css('display', 'none');
        $('#bw_status').val('');
    },
    
    rebuildBlocks: function() {
        this.clearIds();
        BwpbMapper.clearMapper();
        BwpbBlocker.emptyBlocks();
        BwpbBlocker.parse();
        
    },
    
    loading: function() {
        $('#bwpb').addClass('loading');
    },
    
    loaded: function() {
        $('#bwpb').removeClass('loading');
    },
    
    panelCSSOpen: function() {
        
        this.panelClose();
        this.panelSetTitle( $panelCSS, $panelCSS.attr('data-title') );
        this.panelDraggable( $panelCSS );
        this.setEditorAce();
        $panelCSS.addClass('open');
        $('#bwpb-bg').css('visibility','visible');
        
    },
    
    panelCSSSave: function() {
        
        $('#bwpb textarea[name="bw_custom_css"]').val( this.$editor.getSession().getValue() );
        this.panelClose();
        
    },
    
    setEditorAce: function() {
        if( ! this.$editor) {
            this.$editor = ace.edit('bw_custom_css_editor');
            this.$editor.setTheme("ace/theme/chrome");
            this.$editor.getSession().setMode("ace/mode/css");
        }
        this.$editor.clearSelection();
        this.$editor.focus();
        var count = this.$editor.getSession().getLength();
        this.$editor.gotoLine(count, this.$editor.getSession().getLine(count-1).length);
    },
    
    panelCOpen: function() {
        
        this.panelClose();
        
        $panelC.addClass('open');
        $('input#bwpb-custom-col-string', $panelC).val('');
        
        this.panelSetTitle( $panelC, $panelC.attr('data-title') );
        this.panelDraggable( $panelC );
        
    },
    
    addNewTab: function( newId, $tab ) {
        
        $('.bwpb-tab-list', $tab).append('<li data-tabid="' + newId + '">' + $tab.closest('.bwpb-block.bwpb-tab').attr('data-tabtext') + '</li>');
        
    },
    
    dusplicateTab: function( e ) {
        
        var $toDuplicate = e.closest('.bwpb-block');
        var $duplicated = $toDuplicate.clone().addClass('bwpb-tab-hidden');
        var newId = this.duplicateDataObject( $duplicated );
        $duplicated.insertAfter( $toDuplicate );
        this.addNewTab( newId, e.closest('.bwpb-block.bwpb-tab') );
        
        this.reload();
        this.reloadBlocks();
        
    },
    
    // reinit items based on editor content
    reload: function() {
        
        // clear the mapped tree data
        BwpbMapper.clearMapperTree();
        // and build it again based on the blocks
        BwpbMapper.parseBlocks( $('#bwpb .bwpb-blocks'), false );
        // get the new shortcode and insert it to the editor
        BwpbShortcoder.append( BwpbShortcoder.getShortcode( BwpbMapper.bw_mapper_tree, false ) );
        
    },
    
    reloadBlocks: function() {
        
        this.sortableBlocks();
        this.tab.bind();
        
    },
    
    visibilityBlock: function( e ) {
        
        var rowHolder = e.closest('.block-row');
        rowHolder.toggleClass('bwpb-row-hidden'); // add class to highlight hidden element.
        
        BwpbMapper.updateMapperData( rowHolder.attr('data-id'), 'visibility', rowHolder.hasClass('bwpb-row-hidden') ? 'true' : '' );
        
        this.reload(); // reinit items based on editor content.
        
    },
    
    dusplicateBlock: function( e ) {
        
        // element to duplicate
        var $toDuplicate = e.closest('.bwpb-block');
        // duplicate as block in html
        var $duplicated = $toDuplicate.clone();
        // duplicated data object for new elements
        this.duplicateDataObject( $duplicated );
        // insert duplicated element in html
        $duplicated.insertAfter( $toDuplicate );
        // reinit items based on editor content
        this.reload();
        
        // refresh blocks
        this.reloadBlocks();
        
    },
    
    duplicateDataObject: function( $dup ) {
        
        var self = this;
        
        var uid = $dup.attr( 'data-id' );
        var newId = this.getUniqueId();
        var dupObj = $.extend( true, {}, BwpbMapper.bw_mapper_data[ uid ] );
        
        BwpbMapper.bw_mapper_data[ newId ] = dupObj;
        $dup.attr( 'data-id', newId );
        
        if( $( '*[data-id]', $dup ) ) {
            $( '*[data-id]', $dup ).each(function() {
                self.duplicateDataObject( $(this) );
            });
        }
        
        return newId;
        
    },
    
    deleteBlock: function( e ) {
        
        if ( confirm( "Do you want to remove this element?" ) == true ) {
            
            // check if the block is empty
            this.emptyBlock( e );
            // remove as block in html
            e.closest('.bwpb-block').remove();
            // reinit items based on editor content
            this.reload();
            // reload sortable
            this.reloadBlocks();
            // check welcome page
            this.welcomeCheck();
            
        }
        
    },
    
    welcomeCheck: function() {
        
        BwpbMapper.bw_mapper_tree.length === 0 ? this.welcomeShow() : this.welcomeHide();
        
    },
    
    welcomeShow: function() {
        
        $('#bwpb-welcome').css('display', 'block');
        
    },
    
    welcomeHide: function() {
        
        $('#bwpb-welcome').css('display', 'none');
        
    },
    
    cutColumn: function( $row, sum ) {
        
        // count columns
        var columnLength = $(' > .bwpb-block-container > .bwpb-content > .bwpb-block', $row).length + ( sum ? +1 : -1 );
        if( columnLength > 8 || columnLength < 1 ) { return; }
        var colValues = [];
        var colPush = 100 / columnLength;
        
        for( i = 0; i < columnLength; i++ ) {
            colValues.push( Math.floor(colPush * 10) / 10 );
        }
        this.switchCol( colValues.join(','), $row.attr('data-id') );
        
    },
    
    deleteTab: function( e ) {
        
        if ( confirm( "Do you want to remove this element?" ) == true ) {
            
            this.emptyBlock( e );
            
            var uid = e.closest('.bwpb-block').attr('data-id');
            var $tabs = e.closest('.bwpb-block.bwpb-tab').find('.bwpb-tab-list');
            var $currentTab = $('li[data-tabid="' + uid + '"]', $tabs);
            
            // next tab trigger click
            var tabIndex = $('li', $tabs).index($currentTab);
            e.closest('.bwpb-block').remove();
            $currentTab.remove();
            if( tabIndex === 0 ) {
                $('li:eq(0)', $tabs).trigger('click');
            }else if( tabIndex > 0 ) {
                if( $('li:eq(' + tabIndex + ')', $tabs).length ) {
                    $('li:eq(' + tabIndex + ')', $tabs).trigger('click');
                }else{
                    $('li:eq(' + ( tabIndex - 1 ) + ')', $tabs).trigger('click');
                }
            }
            
            this.reload();
            
        }
        
    },
    
    emptyBlock: function( e ) {
        
        if( $(e).hasClass('bwpb-trash-check-empty') && $(e).closest('.bwpb-block') !== 'bwpb-module-bw_row' ) {
            if( $(e).closest('.bwpb-content').children().length <= 1 ) {
                $(e).closest('.bwpb-content').closest('.bwpb-block').removeClass('not-empty');
            }
        }
        
    },
    
    switchCol: function( cols, parentId ) {
        
        var newCols = [];
        var currentColumnBlocks = [];
        var currentColumnIds = [];
        
        var $row = $('#bwpb *[data-id="' + parentId + '"]');
        var $cols = $row.hasClass('bwpb-module-bw_row') ? $row.find('.bwpb-module-bw_column') : $row.find('.bwpb-module-bw_column_inner');
        cols = cols.split(',');
        
        $cols.each(function() {
            
            var $oldCol = $(this);
            currentColHtml = $oldCol.hasClass('not-empty') ? $( '.bwpb-content', $oldCol ).html() : '';
            currentColumnBlocks.push( currentColHtml );
            currentColumnIds.push( $oldCol.attr('data-id') );
            
        });
        
        $cols.remove();
        
        for ( var i = 0; i < cols.length; i++ ) {
            
            marge_data = { 'col_width': cols[i] };
            
            // get current col data and push it to the new col. This will save the changes on column switch.
            if( typeof currentColumnIds[i] !== 'undefined' ) {
                
                if( typeof BwpbMapper.bw_mapper_data[ currentColumnIds[i] ] !== 'undefined' ) {
                    
                    var cParam = BwpbMapper.bw_mapper_data[ currentColumnIds[i] ].params;
                    
                    for ( var param in cParam ) {
                        
                        if( typeof cParam[ param ].value !== 'undefined' && cParam[ param ].value !== '' && cParam[ param ].param_name !== 'col_width' ) {
                            marge_data[ cParam[ param ].param_name ] = cParam[ param ].value;
                        }
                    }
                    
                    // remove the previous column data
                    delete BwpbMapper.bw_mapper_data[ currentColumnIds[i] ];
                    
                }
                
            }
            
            newCols.push( this.singleModule( $cols.attr('data-module'), parentId, true, marge_data ) );
            
        }
        
        for ( var i = 0; i < currentColumnBlocks.length; i++ ) {
            
            if( currentColumnBlocks[i] !== '' ) {
                if( typeof newCols[i] !== 'undefined' ) {
                    
                    var $block = $('#bwpb .bwpb-block[data-id="' + newCols[i] + '"]').addClass('not-empty');
                    $(' > .bwpb-block-container > .bwpb-content', $block).html( currentColumnBlocks[i] );
                    
                }else{
                    
                    for ( var j = i; j < currentColumnBlocks.length; j++ ) {
                        
                        if( currentColumnBlocks[j] !== '' ) {
                            $('#bwpb .bwpb-block[data-id="' + newCols[i-1] + '"]').addClass('not-empty').find('.bwpb-content:first').append( currentColumnBlocks[j] );
                        }
                    }
                }
            }
        }
        
        // map tree
        BwpbMapper.mapperTree( true );
        // refresh sortable
        this.sortableBlocks();
        
    },
    
    margeObjData: function( obj, params ) {
        
        if( typeof params === 'object' ) {
            
            for (var param in params) {
                
                var param_value = params[param];
                
                if( typeof obj.params[param] !== 'undefined' ) {
                    
                    obj.params[param].value = param_value;
                    
                }
            }
        }
        
    },
    
    singleModule: function( module, parentId, append_shortcode, marge_data ) {
        
        var modules = $.parseJSON( window.bwpb_data.map );
        
        if( typeof modules[module] === 'object' ) {
            
            var uid = this.getUniqueId(); // unique id
            BwpbMapper.mapperData( uid, modules[module], marge_data ); // map data
            Bwpb.pushBlock( uid, module, parentId, append_shortcode, marge_data ); // push the block
            
            return uid;
            
        }else{ alert( 'The module "' + module + '" doesn\'t have a template.' ); }
        
    },
    
    pushBlock: function( uid, module, parentId, append_shortcode, marge_data ) {
        
        // hide welcome screen
        this.welcomeHide();
        
        // latest block id
        this.latest_block_id = uid;
        
        // latest row id
        if( module === 'bw_row' ) {
            this.latest_row_id = uid;
        }
        
        var allModules = $.parseJSON( window.bwpb_data.map );
        var data = allModules[module];
        
        // marge additionals parameters with the module data
        this.margeObjData( data, marge_data );
        
        // the view of the current module
        var moduleView = ( typeof data.view !== 'undefined' ) ? data.view : 'block';
        
        if( $( '#bwpb_template-' + moduleView ).length ) {
            
            // find requested module
            var $block = $( $( '#bwpb_template-' + moduleView ).html() );
            $block.attr( 'data-id', uid ).find('.just-edit .bwpb-label').html( data.name );
            $block.addClass('bwpb-module-' + data.base);
            
            $block.attr( 'data-module', data.base );
            
            if( moduleView === 'listing' || moduleView === 'listing_item' ) {
                if( typeof data.icon !== 'undefined' ) {
                    $block.attr( 'data-container', data.base );
                    $('.bwpb-listing-icon', $block).addClass( data.icon );
                }
            }
            
            // if text item, add content as text
            if( moduleView === 'listing_item' ) {
                $(' > .bwpb-block-container > .bwpb-holder > h4', $block).html( data.name );
            }
            
            // if simple block
            if( moduleView === 'block' ) {
                $block.find('.bwpb-holder h4').html( data.name );
                this.latest_col_id = uid;
            }
            
            // if row
            if( moduleView === 'row' ) {
                // row visibility
                if( data.params.visibility.value ) {
                    $block.addClass('bwpb-row-hidden');
                }
            }
            
            // if row inner
            if( module === 'bw_row_inner' ) {
                $('.bwpb-ctrl-right:first', $block).html( $('.bwpb-ctrl-right:first', $block).html() + ' inner');
            }
            
            // if column
            if( moduleView === 'column' ) {
                $block.css( 'width', data.params.col_width.value + '%' );
                this.latest_col_id = uid;
                
                // add col width param
                $block.attr( 'data-col-width', data.params.col_width.value );
                // add percent
                $(' > .bwpb-block-container > .bwpb-top-column > .bwpb-col-ctrl > span', $block).html( data.params.col_width.value );
                $(' > .bwpb-column-width em', $block).html( data.params.col_width.value );
            }
            
            // add element color
            if( $('.bwpb-label', $block).length && typeof bwpb_data.ele_colors[data.base] !== 'undefined' ) {
                $('.bwpb-label', $block).css('background-color', bwpb_data.ele_colors[data.base]);
            }
            
            // inner row label text
            if( data.base === 'bw_row_inner' ) {
                $('.bwpb-row-label:first', $block).html('Row inner');
            }
            
            // deeper elements
            if( ! this.element_manually && ! parentId && module !== 'bw_row' ) {
                parentId = this.latest_col_id;
            }
            // element without row
            else if( ! parentId && module !== 'bw_row' ) {
                this.singleModule( 'bw_row', 0, append_shortcode, false );
                parentId = this.latest_block_id;
            }
            
            if( typeof data.icon !== 'undefined' ) {
                $block.find('.bwpb-icon:first').addClass( data.icon );
            }
            
            if( parentId ) {
                // no parent
                if( this.append_element_top ) {
                    $('#bwpb .bwpb-block[data-id="' + parentId + '"] .bwpb-content:first').prepend( $block );
                    this.append_element_top = false;
                }else{
                    $('#bwpb .bwpb-block[data-id="' + parentId + '"] .bwpb-content:first').append( $block );
                }
                if( module !== 'bw_column' ) {
                    $('#bwpb .bwpb-block[data-id="' + parentId + '"]').closest('.bwpb-block').addClass('not-empty');
                }
            }else{
                // has parent
                if( this.append_element_top ) {
                    $('#bwpb .bwpb-blocks').prepend( $block );
                    this.append_element_top = false;
                }else{
                    $('#bwpb .bwpb-blocks').append( $block );
                }
            }
            
            if( moduleView == 'tab' ) {
                
                if( typeof data.max_tabs !== 'undefined' ) {
                    $block.attr( 'data-max-tabs', data.max_tabs );
                }
                $('.bwpb-add-element', $block).attr( 'data-toadd', data.container_child );
                var tab_text = typeof data.tab_text !== 'undefined' ? data.tab_text : 'Tab';
                $block.attr('data-tabtext', tab_text);
                if( Bwpb.element_manually === true ) {
                    $block.find('.bwpb-option.bwpb-add-element').trigger('click').trigger('click').trigger('click');
                    $block.find('.bwpb-tab-list li:eq(0)').trigger('click');
                }
            }
            
            if( moduleView == 'tab_item' ) {
                var $closestTab = $block.closest('.bwpb-tab');
                
                $closestTab.find('.bwpb-tab-list').append('<li data-tabid="' + uid + '">' + $closestTab.attr('data-tabtext') + '</li>');
            }
            
            // drag placeholder
            if( $('.bwpb-drag-placeholder', $block).length ) {
                var $drag = $('.bwpb-drag-placeholder', $block);
                
                if( typeof data.icon !== 'undefined' ) {
                    $('.bwpb-drag-icon i', $drag).addClass( data.icon );
                }
                $('.bwpb-drag-label', $drag).html( data.name );
            }
            
            // if holder, add holders as text
            this.updateBlockHtml( uid );
            
            // if row, call some column inside, except when append_shortcode representation is not requested ( the col will be pushed after ).
            if( module === 'bw_row' && append_shortcode ) {
                this.singleModule( 'bw_column', uid, append_shortcode, false );
            }
            // same for inner row
            if( module === 'bw_row_inner' && append_shortcode ) {
                this.singleModule( 'bw_column_inner', uid, append_shortcode, false );
            }
            
        }else{
            console.log('The template "#bwpb_template-' + moduleView + '" doesn\'t exists.');
        }
        
    },
    
    callModules: function() {
        
        var self = this;
        
        $(document).on('click', '#bwpb-modal .bwpb-elements li', function() {
            
            // close modal
            self.closeModal();
            
            Bwpb.element_manually = true;
            
            var module = $(this).attr('data-module');
            
            uid = self.singleModule( module, self.bw_modal_parent, true, false );
            
            // map tree
            BwpbMapper.mapperTree( true );
            
            // open settings on create
            var openOnCreate = BwpbMapper.bw_mapper_data[ uid ].open_settings_on_create;
            if( openOnCreate !== 'undefined' && openOnCreate === true ) {
                Bwpb.panelSOpen( uid );
            }
            
            self.sortableBlocks();
            
            Bwpb.element_manually = false;
            
        });
    },
    
    getUniqueId: function() {
      return '4xxxxx-yxxxxx'.replace(/[xy]/g,
        function(c) {
          var r = Math.random() * 16 | 0,
            v = c == 'x' ? r : (r & 0x3 | 0x8);
          return v.toString(16);
        }).toLowerCase();
    },
    
    sortableRows: function() {
        
        $( "#bwpb .bwpb-blocks" ).sortable({
            
            items               : ' > .bwpb-block',
            connectWith         : '.bwpb-row-content',
            cursor              : 'move',
            cursorAt            : { left: 15, top: 17 },
            handle              : '.bwpb-drag:first',
            placeholder         : 'bwpb-placeholder-row',
            distance            : 15,
            update              : this.sortableUpdate,
            start: function(e, ui) {
                ui.item.toggleClass('bwpb-drag');
            },
            stop: function(e, ui) {
                ui.item.toggleClass('bwpb-drag');
            }
            
        });
        
    },
    
    sortableBlocks: function() {
        
        var $elBlocks = $( "#bwpb .block-column > .bwpb-block-container > .bwpb-content" );
        var blocksConnections = '.block-column > .bwpb-block-container > .bwpb-content';
        
        $elBlocks.sortable({
            
            items               : ' > .bwpb-separator-block, > .bwpb-text-block, > .bwpb-simple-block, > .bwpb-listing, > .bwpb-tab, > .bwpb-module-bw_row_inner',
            connectWith         : blocksConnections,
            cursor              : 'move',
            cursorAt            : { left: 15, top: 17 },
            forcePlaceholderSize: true,
            placeholder         : 'bwpb-placeholder-block',
            distance            : 15,
            update              : this.sortableUpdate,
            tolerance           : 'pointer',
            start: function(e, ui) {
                
                // convert to edit block
                ui.item.addClass('bwpb-drag');
                
                // inner row
                if (ui.item.hasClass("bwpb-module-bw_row_inner")) {
                    $elBlocks.sortable("option", "connectWith", '.bwpb-module-bw_column > .bwpb-block-container > .bwpb-content');
                    $elBlocks.sortable("refresh");
                }
                
            },
            stop: function(e, ui) {
                
                // removes the edit block style
                ui.item.removeClass('bwpb-drag');
                
                // inner row
                if ( ui.item.hasClass( "bwpb-module-bw_row_inner" ) ) {
                    $elBlocks.sortable( "option", "connectWith", blocksConnections );
                    $elBlocks.sortable( "refresh" );
                }
                
            },
            
            receive: function(e, ui) {
                
                // if no elements, remove \'not empty\' class
                if( ui.sender.children().length <= 0 ) {
                    ui.sender.closest('.block-column').removeClass('not-empty');
                }
                
            }
            
        });
        
        $('.bwpb-column-drag').draggable({
            axis: 'x',
            handle: '.bwpb-col-drag-handle',
            containment: '.bwpb-content',
            start: function( event, ui ) {
                
            },
            stop: function( event, ui ) {
                
                var $dragSeparator = ui.helper,
                    $row = $dragSeparator.closest('.block-row');
                
                $row.removeClass('bwpb-col-dragging');
                
                var colValues = [];
                $(' > .bwpb-block-container > .bwpb-content > .bwpb-block', $row).each(function() {
                    colValues.push( $(' > .bwpb-column-width > .bwpb-col-width-label em', this).html() );
                });
                Bwpb.switchCol( colValues.join(','), $row.attr('data-id') );
                
            },
            drag: function( event, ui ) {
                
                var $dragSeparator = ui.helper,
                    $colLeft = $dragSeparator.closest('.block-column'),
                    $colRight = $colLeft.next();
                
                var leftHand = parseFloat( ( ui.position.left / $dragSeparator.closest('.bwpb-content').width() ) * 100 ).toFixed(1);
                var numChange = parseFloat( $colLeft.attr('data-col-width') ) - leftHand;
                var rightHand = parseFloat( $colRight.attr('data-col-width') ) + numChange;
                var doSo = true;
                
                $dragSeparator.closest('.block-row').addClass('bwpb-col-dragging');
                
                // left limitation
                if( parseFloat(leftHand) < 12.5 ) {
                    ui.position.left = false;
                    doSo = false;
                }
                
                // right limitation
                if( parseFloat(rightHand) < 12.5 ) {
                    ui.position.left = false;
                    doSo = false;
                }
                
                if( doSo ) {
                    
                    $('> .bwpb-column-width > .bwpb-col-width-label em', $colLeft).html( leftHand );
                    $('> .bwpb-column-width > .bwpb-col-width-label em', $colRight).html( rightHand.toFixed(1) );
                    
                    // change col width
                    $colLeft.css('width', leftHand + '%');
                    $colRight.css('width', rightHand.toFixed(1) + '%');
                    
                }
                
            }
        });
        
        this.sortableContainer();
        
    },
    
    sortableContainer: function() {
        
        $('#bwpb .bwpb-listing > .bwpb-block-container > .bwpb-content').sortable({
            
            items               : ' > .bwpb-listing-item',
            connectWith         : '.bwpb-listing > .bwpb-block-container > .bwpb-content',
            forcePlaceholderSize: true,
            cursor              : 'move',
            cursorAt            : { left: 15, top: 17 },
            placeholder         : 'bwpb-placeholder-listing',
            distance            : 15,
            update              : this.sortableUpdate,
            start: function(e, ui) {
                ui.item.toggleClass('bwpb-drag');
            },
            stop: function(e, ui) {
                ui.item.toggleClass('bwpb-drag');
            },
            receive: function(e, ui) {
                
                var senderContainer = ui.sender.closest('.bwpb-listing').attr('data-container');
                var receiverContainer = ui.item.closest('.bwpb-listing').attr('data-container');
                
                // cancel the sortable
                if ( senderContainer !== receiverContainer ) {
                   $(ui.sender).sortable('cancel');
                }else{
                    if( ui.sender.children().length <= 0 ) {
                        ui.sender.closest('.bwpb-block').removeClass('not-empty');
                    }
                }
                
            }
            
        }).disableSelection();
        
        this.sortableTabs();
        
    },
    
    sortableTabs: function() {
        
        $('#bwpb .bwpb-tab > .bwpb-block-container > .bwpb-tab-list').sortable({
            
            axis                : 'x',
            items               : 'li',
            forcePlaceholderSize: true,
            cursor              : 'move',
            placeholder         : 'bwpb-placeholder-tab',
            distance            : 15,
            update              : this.sortableTabUpdate,
            
        }).disableSelection();
        
    },
    
    sortableUpdate: function() {
        
        if($(this).hasClass('bwpb-content')) {
            if( $(this).children().length > 0 ) {
                $(this).closest('.bwpb-block').addClass('not-empty');
            }
        }
        
        Bwpb.reload();
        
    },
    
    sortableTabUpdate: function( e, ui ) {
        
        var $tabList = ui.item.closest('.bwpb-tab-list');
        var $block = ui.item.closest('.bwpb-block.bwpb-tab');
        var $tabContent = $(' > .bwpb-block-container > .bwpb-content', $block);
        var tabList = [];
        var tabContent = [];
        
        $('li', $tabList).each( function() {
            tabId = $(this).attr('data-tabid');
            tabList.push( tabId );
            tabContent[ tabId ] = $(' > .bwpb-tab-item[data-id="' + tabId + '"]', $tabContent);
        });
        
        $tabContent.empty();
        
        for ( var i = 0; i < tabList.length; i++ ) {
            $tabContent.append( tabContent[ tabList[i] ] );
        }
       
        Bwpb.reload();
    },
    
    getOrder: function(elem) {
        var parent = [];

        $(elem).children('.bwpb-row-content').each(function() {
            parent.push( 
                $(this).children('div').length ? getChildren(this) : this.id
            );
        });
        
        return parent;
    },
    
    wpautop: function( content ) {
        
        if( typeof content == 'undefined' ) { return; }
        
        if( content.substring(0, 7) == "</p><p>" ) {
            content = content.substring(7);
        }else if( content.substring(0, 3) == "<p>" ) {
            content = content.substring(3);
        }
        var regex = /^.*<\/p><p>$/;
        var regex2 = /^.*<\/p>$/;
        if ( regex.test( content ) ) {
            content = content.slice(0, -7);
        }else if( regex2.test( content ) ) {
            content = content.slice(0, -4);
        }
        
        return content;
        
    },
    
    elHide: function( dataName ) {
        $('#bwpb-panel .panel-row' + dataName ).css('display', 'none');
    },
    
    elShow: function( dataName ) {
        $('#bwpb-panel .panel-row' + dataName ).css('display', 'block');
    }
    
};

$(document).ready(function() {
    Bwpb.start();
});