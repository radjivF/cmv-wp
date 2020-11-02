// Expose jQuery to the global object
window.jQuery = window.$ = jQuery;

// main object
var BwAdmin = {
    init: function() {

        BwAdmin.ajaxQueue();
        
        BwAdmin.import_sample_data();

        BwAdmin.dynamic_fonts();

        BwAdmin.bw_gallery_advanced.init();

        BwAdmin.bw_on_off_button();

        BwAdmin.acf_radio_image();

        BwAdmin.acf_number_slider();

        BwAdmin.on_template_switch();

    },
    
    ajaxQueue: function() {
        
        //this is the ajax queue
        BwAdmin.qInst = $.qjax({
            timeout: 3000,
            ajaxSettings: {
                //Put any $.ajax options you want here, and they'll inherit to each Queue call, unless they're overridden.
                type: "POST",
                url: bw_admin_root.ajax,
            },
            onStop: function () {
                //stop everything on error
                //qInst.Clear();
                BwAdmin.importInfo( 'Finito!' );
                var $import = $('#bw-import-content');
                $(".bw-import-loading", $import).hide();
                $(".bw-import-success", $import).show();
            }
        });
        
    },
    
    import_sample_data: function() {

        var $import = $('#bw-import-content');
        
        $('.bw-demo-choices li').on('click', function() {
            $('.bw-demo-choices li').removeClass('bw-active');
            $(this).addClass('bw-active');
        });
        
        $('.bw-import-posts-result-toggle').live('click', function() {
            $('.bw-import-posts-result').toggleClass('bw-visible');
        });

        $(".bw-import-btn", $import).on('click', function(e) {

            e.preventDefault();
            
            if( $('.bw-demo-choices li.bw-active').length === 0 ) {
                alert('Please select demo version.');return false;
            }

            if (confirm('You are advised to use this importer only on new WordPress sites. Importing the demo data will overwrite your current Theme Options settings. Proceed anyway?') == false) {
                return;
            }

            $(".bw-import-btn", $import).hide();
            $(".bw-import-loading", $import).show();
            $(".bw-import-info", $import).show();
            
            BwAdmin.importMessageStop = 0;
            BwAdmin.importInfo('Start importing demo content..');
            
            var demo_index = $('.bw-demo-choices li').index( $('.bw-demo-choices li.bw-active') ) + 1;
            
            var importCalls = {
                1 : {'action' : '__call_import_theme_options',      'message' : 'Importing theme options..'},
                2 : {'action' : '__call_import_sample_data',        'message' : 'Importing posts..<span class="bw-import-posts-result-toggle"></span>'},
                3 : {'action' : '__call_import_menus',              'message' : 'Assigning menus..'},
                4 : {'action' : '__call_import_static_pages',       'message' : 'Assigning static pages..'},
                5 : {'action' : '__call_import_permalink_format',   'message' : 'Assigning permalink format..'},
                6 : {'action' : '__call_import_custom_post_meta',   'message' : 'Importing custom post meta..'},
                7 : {'action' : '__call_import_custom_options',     'message' : 'Importing custom options..'},
            };
            
            for ( var key in importCalls ) {
                BwAdmin.qInst.Queue({
                    beforeSend: function() {
                        BwAdmin.importInfo( importCalls[BwAdmin.importMessageStop]['message'] );
                    },
                    data: {
                        'action': importCalls[key]['action'],
                        'demo_index': demo_index
                    },
                    success: function( response ) {
                        if( typeof response.importer_result !== 'undefined' ) {
                            $('.bw-import-posts-result-toggle').html('( View post results ).').after('<div class="bw-import-posts-result">' + response.importer_result + '</div>');
                        }
                    }
                });
            }
            
        });
    },
    
    importInfo: function( message ) {
        $('.bw-import-info').append('<p>' + ( ++BwAdmin.importMessageStop ) + '. ' + message + '</p>');
    },
    
    on_template_switch: function() {
        
        if($('#page_template').length) {
            $("#page_template").on('change', BwAdmin.show_hide_template_element);
            $(window).load(function() {
                BwAdmin.show_hide_template_element();
            });
            
        }
        
    },
    
    show_hide_template_element: function() {
        
        BwAdmin.show_hide_default();
        
        var template = $("#page_template").val().replace('templates/','').replace('.php','');
        
        switch( template ) {
            case 'default': break;
            case 'landing-page-builder':
                BwAdmin.show_vc(); break;
            
        }
        
    },
    
    show_hide_default: function() {
        
        BwAdmin.hide_vc();
        
    },
    
    hide_vc: function() {
        $(".composer-switch").hide();
        $("#wpb_visual_composer").hide();
    },
    
    show_vc: function() {
        $(".composer-switch").show();
        $("#wpb_visual_composer").show();
    },
    
    acf_number_slider: function() {

        $('.acf-slider-wrap').each(function() {

            var self = $(this),
                    $label = $(".acf-slider-label strong", self),
                    $input = $("input", self),
                    $slider = $(".acf-slider", self);

            $(".acf-slider", self).slider({
                range: 'min',
                value: ($input.val() > 0) ? parseInt($input.val()) : 0,
                min: ($input.attr('min') > 0) ? parseInt($input.attr('min')) : 0,
                max: ($input.attr('max') > 0) ? parseInt($input.attr('max')) : 100,
                step: ($input.attr('step') > 0) ? parseInt($input.attr('step')) : 1,
                slide: function(event, ui) {
                    $label.html(ui.value);
                    $input.val(ui.value);
                }
            });
            //$slider.slider( "value", $input.val() );
            $label.html($slider.slider("value"));
            $input.val($slider.slider("value"));

        });

    },
    
    acf_radio_image: function() {

        $(document).on('click', '.acf-radio-image', function() {
            var $radioList = $(this).closest('.acf-radio-list');
            $('.acf-radio-image', $radioList).removeClass('active');
            $(this).addClass('active');
        });

        $('.acf-radio-image').each(function() {
            self = $(this);
            if (self.find('input[type="radio"]').is(':checked')) {
                self.addClass('active');
            }
        });

    },
    
    acf_check_radio_image: function() {
        
        $('.acf-radio-image').each(function() {
            self = $(this);
            if (self.find('input[type="radio"]').is(':checked')) {
                self.addClass('active');
            }
        });
        
    },
    
    bw_on_off_button: function() {

        BwAdmin.bw_check_on_off();

        $(document).on("click", ".bw-on-off", function() {

            if ($(this).find('input').is(':checked')) {
                $(this).addClass('checked');
            } else {
                $(this).removeClass('checked');
            }

        });

    },
    
    bw_check_on_off: function() {

        $(".bw-on-off").each(function() {

            var $label = $(this);

            if ($label.find("input").is(":checked")) {
                $label.addClass("checked");
            }

        });

    },
    
    bw_gallery_advanced: {
        
        init: function() {

            BwAdmin.bw_gallery_advanced.create();
            BwAdmin.bw_gallery_advanced.bind();

            if ($('.bw-gallery-advanced').length > 0) {
                BwAdmin.bw_gallery_advanced.get_preview();
            }

        },
        
        bind: function() {

            $(document).on('click', '.enable-video', function() {
                BwAdmin.bw_gallery_advanced.check_video();
            });

            $(document).on('click', '#bw-gallery-bg, .gallery-popup-settings .close-popup, .gallery-popup-settings .btn-done', function() {

                BwAdmin.bw_gallery_advanced.check_video_thumb();

                $('#bw-gallery-bg').removeClass('visible');
                $('.gallery-popup-settings').removeClass('visible');
            });

            $(document).on('click', '.bw-gallery-advanced.enabled-advanced .item-holder', function() {

                $('#bw-gallery-bg').addClass('visible');
                $(this).closest('li').find('.gallery-popup-settings').addClass('visible');

                BwAdmin.bw_gallery_advanced.check_video();

            });

            $(document).on('click', '.bw-gallery-advanced .fa.close', function() {

                $(this).closest('li').remove();

            });

        },
        
        check_video: function() {

            var visible = $('.gallery-popup-settings.visible');

            if ($('.enable-video input', visible).is(':checked')) {
                $('.enabled-video', visible).addClass('visible');
            } else {
                $('.enabled-video', visible).removeClass('visible');
            }

        },
        
        check_video_thumb: function() {

            var visible = $('.gallery-popup-settings.visible');

            if ($('.enable-video input', visible).is(':checked')) {
                visible.closest('li').addClass('video');
            } else {
                visible.closest('li').removeClass('video');
            }

        },
        
        create: function() {

            var $addItem = $('.bw-gallery-advanced .add-items');

            if ($addItem.length > 0) {

                var frame = wp.media({
                    displaySettings: false,
                    id: 'bwgallery-frame',
                    title: 'BwGallery',
                    filterable: 'uploaded',
                    frame: 'post',
                    state: 'gallery-edit',
                    library: {type: 'image'},
                    multiple: true, // Set to true to allow multiple files to be selected
                    editing: true,
                    selection: BwAdmin.bw_gallery_advanced.select()
                });

                $addItem.on('click', function(e) {

                    e.preventDefault();

                    frame.on('update', function() {

                        var controller = frame.states.get('gallery-edit');
                        var library = controller.get('library');
                        var ids = library.pluck('id');

                        $('.bw-gallery-advanced .gallery-ids').val(ids.join(','));

                        var items = "";

                        for (var i = 0; i < ids.length; i++) {
                            items += "<li><div class='item'>" + ids[i] + "</div></li>";
                        }

                        $('.bw-gallery-advanced .items').html(items);

                        BwAdmin.bw_gallery_advanced.get_preview();

                    });

                    frame.open();

                });
            }
        },
        
        get_preview: function() {

            var $gallery = $('.bw-gallery-advanced');
            ids = $('.gallery-ids', $gallery).val();

            $('.bw-gallery-advanced').removeClass('loaded');

            $.ajax({
                type: "post", url: bw_admin_root.ajax,
                data: {
                    action: '__call_gallery_advanced_preview',
                    attachments_ids: ids,
                    field_key: $('.gallery-field', $gallery).val(),
                    post_id: $('.gallery-post', $gallery).val(),
                    field_name: $gallery.closest('.field').attr('data-field_name'),
                    enabled_advanced: $('.bw-gallery-advanced').hasClass('enabled-advanced'),
                },
                beforeSend: function() {
                    $('#bw-gallery-add i').removeClass('fa-camera-retro').addClass('icon-spin fa-refresh');
                },
                complete: function() {
                    $('#bw-gallery-add i').removeClass('icon-spin fa-refresh').addClass('fa-camera-retro');
                },
                success: function(response) {

                    var result = JSON.parse(response);
                    if (result.success) {
                        $('.bw-gallery-advanced .welcome').remove();
                        $('.bw-gallery-advanced .items').html(result.output);
                    }

                    if (!result.success && !$('.bw-gallery-advanced .items li').length) {
                        $('.bw-gallery-advanced').append('<p class="welcome"><i class="fa fa-camera-retro"></i>Create your gallery by clicking the button above "Edit gallery".</p>');
                    }
                    setTimeout(function() {
                        $('.bw-gallery-advanced').addClass('loaded');
                    }, 100);

                }
            });

        },
        
        select: function() {
            var galleries_ids = $('.bw-gallery-advanced .gallery-ids').val(),
                shortcode = wp.shortcode.next('gallery', '[gallery ids="' + galleries_ids + '"]'),
                defaultPostId = wp.media.gallery.defaults.id,
                attachments, selection;
            // Bail if we didn't match the shortcode or all of the content.
            if (!shortcode)
                return;

            // Ignore the rest of the match object.
            shortcode = shortcode.shortcode;

            if (_.isUndefined(shortcode.get('id')) && !_.isUndefined(defaultPostId))
                shortcode.set('id', defaultPostId);

            attachments = wp.media.gallery.attachments(shortcode);
            selection = new wp.media.model.Selection(attachments.models, {
                props: attachments.props.toJSON(),
                multiple: true
            });

            selection.gallery = attachments.gallery;

            // Fetch the query's attachments, and then break ties from the
            // query to allow for sorting.
            selection.more().done(function() {
                // Break ties with the query.
                selection.props.set({query: false});
                selection.unmirror();
                selection.props.unset('orderby');
            });

            return selection;
        }

    },
    
    dynamic_fonts: function() {

        $('.ot-bw-google-font').change(function() {

            BwAdmin.change_font($(this));

        });

        if ($('.ot-bw-google-font').length > 0) {
            $('.ot-bw-google-font').each(function() {
                BwAdmin.change_font($(this));
            });
        }

    },
    
    change_font: function(element) {

        var $bwFont = element.closest('.ot-bw-google-font'),
                $bwPrev = $('.bw-font-review', $bwFont),
                font = $('.option-tree-ui-select option', element).filter(":selected").val(),
                fontClass = $('.option-tree-ui-select option', element).filter(":selected").attr('class');

        if (typeof font !== 'undefined') {
            if (font !== '' && font !== null) {

                var $fontRel = $('<link rel="stylesheet" type="text/css" />');
                $("head").append($fontRel);
                $bwPrev.removeClass('hide has_regulat has_bold has_italic has_bolditalic').addClass(fontClass);

                $fontRel
                        .attr("href", 'https://fonts.googleapis.com/css?family=' + font.replace(/ /, "+"))
                        .load(function() {
                            $bwPrev.find('p').css('font-family', font);
                        });

            } else {
                $bwPrev.addClass('hide');
            }
        }

    }
};

// call main object on document ready
$(document).ready(function() {
    BwAdmin.init();
});
