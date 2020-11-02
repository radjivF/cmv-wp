/*global jQuery:false, $:false*/
window.jQuery = window.$ = jQuery;

/* main front end object */
var Bwpb = {
    
    dynamicCount: 0,
    
    // initiation
    start: function() {
        
        // load before new ajax request, to unbind unused events
        if( this.dynamicCount > 0 ) { this.unload(); }
        
        this.onSmartResize();
        this.onImagesLoaded();
        this.magnificPopup();
        this.dynamicCount > 0 ? this.onAjaxLoad() : this.onLoad();
        
        this.dynamicCount++;
        
        // Create the event
        this.bwpbEvent = new CustomEvent("bwpbFinished");
        
    },
    
    // build the elements
    elements: function() {
        
        this.tab();
        this.faq();
        this.pie.start();
        this.numberCounter.start();
        this.grid.start();
        this.map.start();
        this.accordion();
        
    },
    
    // fire when the entire document has beed loaded
    onLoad: function() {
        
        var self = this;
        
        if( Boolean( window.bwpb_params.front_end_load_js ) ) { // regular
            $(window).load(function() { self.loadAll(); });
        }else{ // dynamic call
            $('img').imagesLoaded(function() {
                self.loadAll();
            });
        }
        
    },
    
    onAjaxLoad: function() {
        
        var self = this;
        
        $('img').imagesLoaded(function() {
            self.loadAll();
        });
        
    },
    
    loadAll: function() {
        
        this.waypoints();
        this.videoBg();
        
    },
    
    // load before new ajax request, to unbind unused events
    unload: function() {
        
        this.revealScrolling.stop();
        
    },
    
    // fire once all the images are loaded
    onImagesLoaded: function() {
        
        this.slider.start();
        
        var self = this;
        
        var callFunctions = function() {
            self.animations();
            self.cols();
        }
        
        $('img').imagesLoaded(function() {
            callFunctions();
            self.elements();
            self.revealScrolling.start();
        });
        
    },
    
    // element: accordion
    accordion: function() {
        
        $('.bwpb-accordion').each(function() {
            
            var $accordion = $(this);
            
            $('.bwpb-accordion-label', $accordion).bind('click', function() {
                if( ! $(this).closest('.bwpb-accordion-item').hasClass('bwpb-accordion-is-active') ) {
                    $('.bwpb-accordion-is-active', $accordion).find('.bwpb-accordion-content').stop(true,false).slideUp(300);
                    $('.bwpb-accordion-item', $accordion).removeClass('bwpb-accordion-is-active');
                    $(this).closest('.bwpb-accordion-item').addClass('bwpb-accordion-is-active').find('.bwpb-accordion-content').slideDown(300);
                }else{
                    $('.bwpb-accordion-is-active', $accordion).find('.bwpb-accordion-content').stop(true,false).slideUp(300);
                    $('.bwpb-accordion-item', $accordion).removeClass('bwpb-accordion-is-active');
                }
            });
            
        });
        
    },
    
    // element: slider
    slider: {
        
        start: function() {
            
            this.build();
            
        },
        
        build: function() {
            
            var self = this;
            
            $('.bwpb-slider').each(function() {
                
                // autoplay
                var owlAutoplay = false;
                if( self.check(this, 'data-autoplay') ) {
                    owlAutoplay = self.check(this, 'data-autoplay-timeout') ? parseInt( $(this).attr('data-autoplay-timeout') ) : true;
                }
                
                var owlSetting = {
                    
                    items               : typeof $(this).attr( 'data-slides' ) !== 'undefined' ? $(this).attr( 'data-slides' ) : 1,
                    singleItem          : typeof $(this).attr('data-slides') !== 'undefined' && $(this).attr('data-slides') == '1' ? true : false,
                    pagination          : self.check(this, 'data-pagination'),
                    navigation          : self.check(this, 'data-navigation'),
                    autoPlay            : owlAutoplay,
                    autoHeight          : self.check(this, 'data-autoheight'),
                    
                };
                
                $(this).owlCarousel( owlSetting );
                
            });
            
        },
        
        check: function(el, param) {
            return typeof $(el).attr(param) !== 'undefined';
        }
        
    },
    
    // element: google map
    map: {
        
        start: function() {
            this.build();
        },
        
        build: function() {
            if( $('.bwpb-gmap').length && typeof google !== 'undefined' ) {
                $('.bwpb-gmap').bwpbMap();
            }
        }
        
    },
    
    // element: grid layout, latest posts
    grid: {
        
        start: function() {
            
            this.build();
            this.filter();
            this.loadMore();
            
        },
        
        build: function() {
            
            var $grid = $('.bwpb-grid:not(.no-isotope)');
            
            if( $grid.length > 0 ) {
                
                var isotopeOptions = {
                    itemSelector: '.bwpb-grid-item'
                }
                
                if( $grid.hasClass('bwpb-auto-adjust-image') ) { isotopeOptions[ 'layoutMode' ] = 'fitRows'; }
                
                $grid.imagesLoaded(function() {
                    $grid.isotope( isotopeOptions );
                });
            }
            
        },
        
        filter: function() {
            
            var $filter = $('.bwpb-grid-filter');
            
            if( $filter.length > 0 ) {
                $filter.on('click', 'li', function(e) {
                    e.preventDefault();
                    $(this).parent().find('li').removeClass('active');
                    $(this).addClass('active');
                    var $mixer = $(this).closest('.bwpb-grid-holder').find('.bwpb-grid'),
                        $elementToMix = $(this).parent().next('.section-latest-posts'),
                        ftr = $(this).attr('data-filter');
                    $('.filter-content span', $filter).html($(this).html());
                    if(typeof(ftr) !== 'undefined') {
                        $mixer.isotope({filter: '.' + ftr});
                    }else{
                        $mixer.isotope({filter: '*'});
                    }
                });
            }
            
        },
        
        loadMore: function() {
            
            var self = this;
            
            $( '.bwpb-section-load-more' ).each(function( i, el ) {
                
                var $grid = $( el ),id = $( el ).attr( 'id' );
                
                $(el).on( 'click', '.bwpb-load-more-btn', function( e ) {
                    
                    e.preventDefault();
                    
                    var $this = $(this);
                    
                    if( $this.hasClass('bwpb-ajax-loading') ) { return; }
                    
                    $this.addClass('bwpb-ajax-loading');
                    
                    var $new_archive = $( '<div/>' ),
                        elIndex = $grid.index('.bwpb-section-load-more');
                    
                    $grid.find( '.bwpb-load-more' ).find( 'i' ).addClass('fa-spin');
                    
                    $.ajax({
                        type: "POST",
                        url: $this.attr( 'href' ) + ' #' + id + ':first',
                        success: function( response ) {
                            
                            $new_archive = $(response).find( '.bwpb-section-load-more' );
                            
                            var $new_items = $new_archive.children(),
                                $new_items_clicked = $new_archive.eq(elIndex);
                            
                            $this.replaceWith($new_items_clicked.find('.bwpb-load-more'));
                            
                            $new_items_clicked.imagesLoaded(function() {
                                
                                $toAppend = $new_items_clicked.find('.bwpb-section-append').children();
                                $grid.find('.bwpb-section-append').append( $toAppend ).isotope( 'appended', $toAppend ).isotope( 'layout' ).isotope({filter: '*'});
                                
                                $(window).trigger('resize');
                                
                                if( typeof App.djax !== 'undefined' ) { App.djax( $toAppend ); }
                                
                                var $loadMoreBtn = $grid.find('.bwpb-load-more-btn');
                                if( $loadMoreBtn.length ) {
                                    // ..
                                }else{
                                    $grid.find('.bwpb-load-more').html('<span class="bwpb-grid-load-more-placeholder"><i class="fa fa-check"></i></span>');
                                    setTimeout(function() {
                                        $grid.find('.bwpb-grid-load-more-placeholder').css('opacity', 0.12);
                                    }, 2000);
                                }
                                
                                $(this).removeClass('bwpb-ajax-loading');
                                
                            });
                            $this.removeClass('bwpb-ajax-loading');
                            self.clearFilter( $grid );
                            
                        }
                    });
                    
                });
            });
            
        },
        
        clearFilter: function( grid ) {
            
            var filter = grid.prev('.bwpb-grid-filter');
            filter.find('li').removeClass('active');
            $('li:first', filter).addClass('active');
            
        }
        
    },
    
    // will be called after resizing has finished
    onSmartResize: function() {
        
        var self = this;
        
        $(window).on("debouncedresize", function( event ) {
            self.cols();
        });
        
    },
    
    // element: number counder
    numberCounter: {
        start: function() {
            var self = this;
            $(window).imagesLoaded(function() {
                setTimeout(function() {
                    self.animated();
                }, 200);
            });
            this.notAnimated();
        },
        animated: function() {
            
            var self = this;
            
            $('.bwpb-number-counter:not(.bwpb-number-counter-visible)').waypoint( function( direction ) {
                
                var $counter = $(this.element);
                
                setTimeout(function() {
                    self.build( $counter );
                }, $counter.attr('data-delay'));
                
                this.destroy();
                
            }, { offset: '85%' });
        },
        notAnimated: function() {
            var self = this;
            $('.bwpb-number-counter.bwpb-number-counter-visible').each(function() {
                self.build( $(this) );
            });
        },
        build: function( $counter ) {
            
            $counter.absoluteCounter({
                speed: parseInt( $counter.attr('data-speed') ),
                fadeInDelay: 0
            });
        },
        
    },
    
    // element: pie chart
    pie: {
        start: function() {
            var self = this;
            $(window).imagesLoaded(function() {
                setTimeout(function() {
                    self.animated();
                }, 200);
            });
            this.notAnimated();
        },
        animated: function() {
            
            var self = this;
            
            $('.bwpb-pie:not(.bwpb-pie-visible)').waypoint( function( direction ) {
                
                var $pie = $(this.element);
                
                setTimeout(function() {
                    self.build( $pie );
                }, $pie.attr('data-delay'));
                
                this.destroy();
                
            }, { offset: '85%' });
            
        },
        notAnimated: function() {
            var self = this;
            $('.bwpb-pie.bwpb-pie-visible').each(function() {
                self.build( $(this) );
            });
        },
        build: function( $pie ) {
            
            $pie.addClass('bwpb-pie-visible').easyPieChart({
                easing: 'easeOutElastic',
                delay: 3000,
                barColor: $pie.attr('data-barcolor'),
                trackColor: $pie.attr('data-trackcolor'),
                scaleColor: false,
                lineWidth: $pie.attr('data-linewidth'),
                trackWidth: $pie.attr('data-linewidth'),
                lineCap: $pie.attr('data-linecap'), // round, butt
                onStep: function(from, to, percent) {
                    $(this.el).find('.bwpb-pie-percent i').text(Math.round(percent));
                },
                animate: {
                    duration:$pie.attr('data-speed'),
                    enabled: typeof $pie.attr('data-speed') !== 'undefined'
                }
            }).next('.bwpb-pie-title').css('opacity',1);
            
            $('canvas', $pie).height('auto');
        }
    },
    
    // element: faq
    faq: function() {
        
        $('.bwpb-faq-item').each(function() {
            var $this = $(this);
            $('.bwpb-faq-title', $this).bind('click', function() {
                $this.toggleClass('bwpb-faq-active');
            });
        });
        
    },
    
    // element: tab
    tab: function() {
        
        $('.bwpb-tab-wrapper').each(function() {
            
            var $tab = $(this),
                $tabList = $('.bwpb-tab-list li', this),
                $tabContent = $('.bwpb-tab-content .bwpb-tab-item', this),
                classTabActive = 'bwpb-tab-item-visible';
            
            $tabList.eq(0).addClass('active');
            $tabContent.eq(0).addClass( classTabActive );
            $tabList.on('click', function() {
                $tabList.removeClass('active');
                $(this).addClass('active');
                $tabContent.removeClass( classTabActive ).eq( $tabList.index( $(this) ) ).addClass( classTabActive );
            });
            
        });
        
    },
    
    // layout: rows
    rows: function() {
        
        var bwpbAdminBar = 0;
        if( $('#wpadminbar').length ) {
            bwpbAdminBar = $('#wpadminbar').height();
        }
        
        // set static row height in percentage
        $('.static-window-height').each(function() {
            var $row = $(this),
                $col = $(' > .bwpb-row > .bwpb-row-inner > .bwpb-column', this);
                
                console.log($row);
                
            $col.css('height', ( $(window).height() * ( parseInt( $row.attr('data-static-height') ) * 0.01 ) ) - ( parseInt( $row.css('paddingTop') ) + parseInt( $row.css('paddingBottom') ) ) - bwpbAdminBar );
        });
        
        
        // dispatch the event
        document.dispatchEvent(this.bwpbEvent);
        
    },
    
    // layout: columns
    cols: function() {
        
        var self = this;
        
        // align columns with the same height
        if( $('body.bwpb-align-tables').length ) {
            $('img').imagesLoaded(function() {
                $('.bwpb-row-inner').each(function() {
                    
                    var $row = $(this);
                    var $cols = $(' > .bwpb-column:not(.bwpb-colwidth-100)', this);
                    var maxHeight = 0;
                    
                    $cols.each(function() {
                        $(this).css('min-height', 0);
                        colHeight = $(this).outerHeight();
                        maxHeight = colHeight > maxHeight ? colHeight : maxHeight;
                    });
                    
                    if( maxHeight > 0 ) {
                        $cols.each(function() {
                            $(this).css( 'min-height', maxHeight );
                        });
                    }
                });
            });
        }
        
        self.rows();
        
    },
    
    waypoints: function() {
        
        if( ! window.bwpb_params.ismobile ) {
            
            // row, col animations
            $('.bwpb-waypoint').waypoint( function( direction ) {
                
                var $el = $(this.element);
                
                setTimeout(function() {
                    $el.addClass('bwpb-animated').addClass( $el.attr('data-animation') );
                }, $el.attr('data-animation-delay') );
                
                this.destroy();
                
            }, { offset: '90%' });
            
            // animation sequences
            $('.bwpb-waypoint-seq-wrap').waypoint( function( direction ) {
                
                var $el = $(this.element);
                
                $('.bwpb-waypoint-seq', $el).each(function( index ) {
                    var $seqEl = $(this);
                    setTimeout(function() {
                        $seqEl.addClass('bwpb-animated').addClass( $el.attr('data-animation') );
                    }, $el.attr('data-animation-delay') * ( index + 1 ) );
                });
                
                this.destroy();
                
            }, { offset: '90%' });
            
            // progress bar
            $('.bwpb-pb-wrapper').waypoint( function( direction ) {
                
                $('.bwpb-pb').each(function(i) {
                    
                    var $barWrapper = $(this);
                    var $barItem = $('.bwpb-pb', this);
                    var $bar = $('.bwpb-pb-bar', this);
                    
                    setTimeout(function() {
                        $bar.css('width', $barWrapper.attr('data-percentage') + '%').addClass('bar-animated');
                    }, 150 * i);
                    
                });
                
                this.destroy();
                
            }, {
                offset: '95%',
            });
            
        }
        
    },
    
    revealScrolling: {
        
        start: function() {
            
            if( window.bwpb_params.ismobile ) { return; }
            
            var self = this;
            var $reveals = $('.reveal-scrolling');
            
            if( $reveals.length > 0 ) {
                $reveals.each(function() {
                    
                    var $reveal = $(this);
                    
                    self.cal( $reveal );
                    
                    $(window).bind('scroll.bwpbEventReveal', function() {
                        
                        self.cal( $reveal );
                        
                    });
                });
                
            }
            
        },
        
        stop: function() {
            
            $(window).unbind('scroll.bwpbEventReveal');
            
        },
        
        cal: function( $reveal ) {
            
            var windowHeight = $(window).height(),
                scrollTop = $(window).scrollTop(),
                offsetTop = $reveal.offset().top,
                screenBottomPosition = scrollTop + windowHeight,
                windowOffset = windowHeight * 0.1;
            
            if( offsetTop < screenBottomPosition - ( windowOffset ) && scrollTop < offsetTop ) {
                
                var afterReveal = ( scrollTop + windowHeight - ( windowOffset ) ) - offsetTop;
                var realOpacity = afterReveal / ( windowHeight * 0.28 );
                if( realOpacity > 0 ) { if( realOpacity < 1 ) { $reveal.css('opacity', realOpacity ); }else{ $reveal.css('opacity', 1 ); } }
            }
            
            if( scrollTop > offsetTop ) {
                $reveal.css('opacity', 1 );
            }
            
        }
        
    },
    
    // call the animations
    animations: function() {
        
        this.movingBg();
        this.parallaxBg();
        this.multiLayerParallax();
        this.imageSequence.start();
        
    },
    
    // display multiple images in some sequence
    imageSequence: {
        
        start: function() {
            
            if( window.bwpb_params.ismobile ) { return; }
            this.calculate();
            
        },
        
        calculate: function() {
            
            var $allSeq = $('.bwpb-image-sequence');
            
            if( $allSeq.length ) {
                $allSeq.each(function() {
                    
                    var $sequence = $(this), sqHeight = 0;
                    
                    $('.bwpb-image-sequence-layer', $sequence).each(function() {
                        var layerHeight = $(this).height();
                        if( layerHeight > sqHeight ) {
                            sqHeight = layerHeight;
                        }
                    });
                    
                    $sequence.css( 'height', sqHeight );
                    
                });
            }
            
        }
        
    },
    
    // check the client browser
    getBrowser: function() {
        var e = navigator.appName, t = navigator.userAgent, n;
        var r = t.match(/(opera|chrome|safari|firefox|msie)\/?\s*(\.?\d+(\.\d+)*)/i);
        if (r && ( n = t.match(/version\/([\.\d]+)/i)) !== null) {
            r[2] = n[1];
        }
        r = r ? [r[1], r[2]] : [e, navigator.appVersion, "-?"];
        return r[0];
    },
    
    // background: video backgrounds
    videoBg: function() {
        
        if( $('.bwpb-video-wrap').length ) {
            $('.bwpb-video-wrap').each(function() {
                $(this).bwpbBgVideo();
            });
        }
        
    },
    
    // background: parallax backgrounds
    parallaxBg: function() {
        if ($(".bwpb-background-parallax").length) {
            $(".bwpb-background-parallax").each(function () {
                if( ! $(this).hasClass('no-parallax') ) {
                    $(this).bwpbNewParallax();
                }
            });
        }
        
    },
    
    // background: background with multiple layers, mouse sensitive
    multiLayerParallax: function() {
        
        var self = this;
        
        if ($(".bwpb-multilayer-parallax").length) {
            $(".bwpb-multilayer-parallax").each(function () {
                if( ! $(this).hasClass('no-parallax') ) {
                    $(this).bwpbMultiParallax();
                }
            });
        }
        
    },
    
    // background: background with moving image
    movingBg: function() {
        
        if ($(".bwpb-moving-background").length && ! window.bwpb_params.ismobile) {
            $(".bwpb-moving-background").each(function () {
                
                var ele = $(this),
                    curbgpos = $(ele).css('backgroundPosition').split(" "),
                    direction = $(ele).attr('data-direction'),
                    bgpos = 0,
                    bgpos2 = 0,
                    bgimage = $(this).css('background-image');
                    bgimage = /^url\((['"]?)(.*)\1\)$/.exec(bgimage);
                    bgimage = bgimage ? bgimage[2] : "";

                var newimg = new Image();
                    newimg.src = bgimage;

                var browser = Bwpb.getBrowser().toLowerCase();
                
                $(newimg).load(function () {
                    
                    var maxwidth = newimg.width,
                        maxheight = newimg.height,
                        bsmove = function () {

                        if (direction === 'horizontal') {
                            if (bgpos > maxwidth) {
                                bgpos = 0;
                            }

                            if (browser === 'netscape' || browser === 'msie') {
                                $(ele).css('background-position-x', bgpos++ + "px");
                            } else {
                                $(ele).css('background-position', bgpos++ + "px " + curbgpos[1]);
                            }
                        } else if (direction === 'vertical') {
                            
                            if (bgpos > maxheight) {
                                bgpos = 0;
                            }
                            
                            if (browser === 'netscape' || browser === 'msie') {
                                $(ele).css('background-position-y', bgpos++ + "px");
                            } else {
                                $(ele).css('background-position', curbgpos[0] + ' ' + bgpos++ + "px ");
                            }
                        } else if (direction === 'diagonal') {
                            if (bgpos > maxwidth) {
                                bgpos = 0;
                            }
                            if (bgpos2 > maxheight) {
                                bgpos2 = 0;
                            }

                            if (browser === 'netscape' || browser === 'msie') {
                                $(ele).css('background-position-x', bgpos++ + "px");
                                $(ele).css('background-position-y', bgpos2++ + "px");
                            } else {
                                $(ele).css('background-position', bgpos++ + "px " + bgpos2++ + "px ");
                            }
                        }
                        
                        requestAnimationFrame(bsmove);
                        
                    };
                    
                    requestAnimationFrame(bsmove);
                    
                });
            });
        }
    },
    
    magnificPopup: function() {
        
        $('.bwpb-mp-item').magnificPopup({
            removalDelay: 500,
            mainClass: 'mfp-fade',
            type: 'image',
            fixedContentPos:true,
            image: {
                titleSrc: function(item) {
                    var output = '';
                    if (typeof item.el.attr('data-title') !== "undefined" && item.el.attr('data-title') !== "") {
                        output = item.el.attr('data-title');
                    }
                    if (typeof item.el.attr('data-alt') !== "undefined" && item.el.attr('data-alt') !== "") {
                        output += '<small>' + item.el.attr('data-alt') + '</small>';
                    }
                    return output;
                }
            },
            iframe: {
                markup:
                    '<div class="mfp-figure mfp-figure--video">' +
                    '<button class="mfp-close"></button>' +
                    '<div>' +
                    '<div class="mfp-iframe-scaler">' +
                    '<iframe class="mfp-iframe" frameborder="0" allowfullscreen></iframe>' +
                    '</div>' +
                    '</div>' +
                    '<div class="mfp-bottom-bar">' +
                    '<div class="mfp-title mfp-title--video"><small></small></div>' +
                    '<div class="mfp-counter"></div>' +
                    '</div>' +
                    '</div>',
                patterns: {
                    youtube: {
                        index: 'youtube.com/', // String that detects type of video (in this case YouTube). Simply via url.indexOf(index).
                        id: 'v=', // String that splits URL in a two parts, second part should be %id%
                        // Or null - full URL will be returned
                        // Or a function that should return %id%, for example:
                        // id: function(url) { return 'parsed id'; }
                        src: '//www.youtube.com/embed/%id%' // URL that will be set as a source for iframe.
                    },
                    vimeo: {
                        index: 'vimeo.com/',
                        id: '/',
                        src: '//player.vimeo.com/video/%id%'
                    },
                    gmaps: {
                        index: '//maps.google.',
                        src: '%id%&output=embed'
                    }
                    // you may add here more sources
                },
                srcAction: 'iframe_src' // Templating object key. First part defines CSS selector, second attribute. "iframe_src" means: find "iframe" and set attribute "src".
            },
            gallery: {
                enabled: true,
                navigateByImgClick: true,
                // arrowMarkup: '<a href="#" class="mfp-arrow mfp-arrow-%dir% control-item arrow-button arrow-button--%dir%"></a>',
                tPrev: 'Previous (Left arrow key)', // title for left button
                tNext: 'Next (Right arrow key)', // title for right button
                // tCounter: '<div class="gallery-control gallery-control--popup"><div class="control-item count js-gallery-current-slide"><span class="js-unit">%curr%</span><sup class="js-gallery-slides-total">%total%</sup></div></div>'
                tCounter: '<div class="gallery-control gallery-control--popup"><a href="#" class="control-item arrow-button arrow-button--left js-arrow-popup-prev"></a><div class="control-item count js-gallery-current-slide"><span class="js-unit">%curr%</span> / <span class="js-gallery-slides-total">%total%</span></div><a href="#" class="control-item arrow-button arrow-button--right js-arrow-popup-next"></a></div>'
            },
            callbacks: {
                markupParse: function(template, values, item) {
                    values.title = item.el.attr('data-title') + '<small>' + item.el.attr('data-alt') + '</small>';
                }
            }
        });
        
    }
}

// call start method from main object.
if( Boolean( window.bwpb_params.front_end_load_js ) ) {
    Bwpb.start();
}
