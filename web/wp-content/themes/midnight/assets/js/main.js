/*global jQuery:false*/
window.jQuery = window.$ = jQuery;

var $window = $(window), $body = $('body'), v3mTween = $('.bw-menu-nav > li > a'), v3mSocialTween = $('#bw-v3m .bw-social li');

var App = {
    
    start : function() {
        
        "use strict";
        
        this.bind();
        this.isotope();
        this.smartResize();
        this.equalHeight($('.bw-isotope article'));
        this.slider.start();
        this.modal.start();
        this.dealCounter();
        this.header();
        this.newsletter();
        this.loginWithAjax();
        this.socialLogin.start();
        this.magnificPopup();
        this.imgLoad();
        this.breadcrumbImg();
        
        this.woocommerce.start();
        
        document.addEventListener("bwpbFinished", function(e) {
            App.waypoints();
        });
        if( typeof Bwpb == 'undefined' ) {
            App.waypoints();
        }
        
        
    },
    
    imgLoad: function() {
        
        "use strict";
        
        $(document).imagesLoaded(function() {
            App.container();
        });
        
    },
    
    breadcrumbImg: function() {
        
        var $brc = $('.bw-breadcrumb.bw-image-enabled'), $brcImg = $('.brc-bg-image', $brc), brcImg = $brc.attr('data-bg_img');
        
        if( $brc.length ) {
            
            var brcTempImg = $('<img src="' + brcImg + '">').imagesLoaded(function() {
                
                $brc.addClass('bw-images-loaded');
                $brcImg.css('background-image', 'url(' + brcImg + ')');
                setTimeout(function() {
                    $brcImg.css('opacity', 1);
                }, 100);
                
            });
        }
    },
    
    mobileMenu: function() {
        
        "use strict";
        
        if( $body.hasClass('bw-mobile-menu-expanded') ) {
            $('#bw-modal-bg').css({'opacity': 0, 'visibility':'hidden'});
            $body.removeClass('bw-mobile-menu-expanded');
        }else{
            $('#bw-modal-bg').css({'opacity': 0.85, 'visibility':'visible'});
            $body.addClass('bw-mobile-menu-expanded');
        }
    },
    
    mobileSearch: function() {
        
        "use strict";
        
        if( ! $('.bw-hm-top').hasClass('bw-is-searching') ) {
            $('.bw-hm-top').addClass('bw-is-searching');
            $('.bw-hm-search .bw-search-field').focus();
        }else{
            $('.bw-hm-top').removeClass('bw-is-searching');
        }
    },
    
    faq: function() {
        
        "use strict";
        
        var $this = $(this), $faqWrap = $this.closest('.bw-faq-wrapper');
        var $faqWrapItems = $faqWrap.find('.bw-faq-item');
        
        $('.bw-faq-title', $faqWrapItems).removeClass('bw-active');
        $('.bw-faq-content', $faqWrapItems).removeClass('bw-active');
        
        $this.addClass('bw-active').closest('.bw-faq-item').find('.bw-faq-content').addClass('bw-active');
        
    },
    
    socialLogin: {
        
        start: function() {
        
            "use strict";
            
            $('.bw-social-login-facebook').on('click', this.fb.start);
            $('.bw-social-login-google').on('click', this.google.start);
            
        },
        
        google: {
            
            start: function() {
        
                "use strict";
                
                $('.bw-social-login-google').addClass('bw-loading').html(bw_theme_ajax.string_google_signin);
                
                var additionalParams = {
                    'callback': App.socialLogin.google.login,
                    'scope': 'profile email'
                };
                gapi.auth.signIn(additionalParams);
                
            },
            
            login: function( authResult ) {
        
                "use strict";
                
                if (authResult['status']['signed_in']) {
                    gapi.client.load('plus', 'v1', App.socialLogin.google.gapiClientLoaded);
                } else {
                    $('.bw-social-login-google').removeClass('bw-loading').empty().append(bw_theme_ajax.string_google_error);
                }
                
            },
            
            gapiClientLoaded: function() {
        
                "use strict";
                
                gapi.client.plus.people.get({userId: 'me'}).execute(App.socialLogin.google.handleGoogleResponse);
            },
            
            handleGoogleResponse: function( resp ) {
        
                "use strict";
                
                var userid = resp.id;
                var username = resp.displayName;
                username = username.toLowerCase().replace(' ', '') + userid;
                var firstname = resp.name.givenName;
                var lastname = resp.name.familyName;
                var email;
                for (var i=0; i < resp.emails.length; i++) {
                    if (resp.emails[i].type === 'account') {
                        email = resp.emails[i].value;
                    }
                }
                var avatar = App.socialLogin.google.getPathFromUrl(resp.image.url);
                var security = $('#securitySignin').val();
                var ajaxURL = bw_theme_ajax.ajax;

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxURL,
                    data: {
                        'action': '__call_google_login',
                        'userid': userid,
                        'signin_user': username,
                        'first_name': firstname,
                        'last_name': lastname,
                        'email': email,
                        'avatar': avatar,
                        'security': security
                    },
                    success: function(data) {
                        if(data.signedin === true) {
                            $('.bw-social-login-google').removeClass('bw-loading').empty().append(data.message);
                            document.location.href = bw_theme_ajax.home;
                        } else {
                            $('.bw-social-login-google').removeClass('bw-loading').empty().append(data.message);
                        }
                    },
                    error: function(errorThrown) {

                    }
                });
            },
            
            getPathFromUrl: function(url) {
        
                "use strict";
                
                return url.split("?")[0];
            }
            
        },
        
        fb: {
            
            start: function() {
        
                "use strict";
                
                $('.bw-social-login-facebook').addClass('bw-loading').html(bw_theme_ajax.string_facebook_signin);
            
                FB.getLoginStatus(function(response) {
                    if(response.status === 'connected') {
                        var newUser = App.socialLogin.fb.getUserInfo(function(user) {
                            var newUserAvatar = App.socialLogin.fb.getUserPhoto(function(photo) {
                                App.socialLogin.fb.wpLogin(user, photo);
                            });
                        });
                    } else if(response.status === 'not_authorized') {
                        FB.login(function(response) {
                            if(response.authResponse) {
                                var newUser = App.socialLogin.fb.getUserInfo(function(user) {
                                    var newUserAvatar = App.socialLogin.fb.getUserPhoto(function(photo) {
                                        App.socialLogin.fb.wpLogin(user, photo);
                                    });
                                });
                            } else {
                                $('.bw-social-login-facebook').removeClass('bw-loading').empty().append(bw_theme_ajax.string_facebook_error);
                            }
                        }, {
                            scope: 'public_profile, email'
                        });
                    } else {
                        FB.login(function(response) {
                            if(response.authResponse) {
                                var newUser = App.socialLogin.fb.getUserInfo(function(user) {
                                    var newUserAvatar = App.socialLogin.fb.getUserPhoto(function(photo) {
                                        App.socialLogin.fb.wpLogin(user, photo);
                                    });
                                });
                            } else {
                                $('.bw-social-login-facebook').removeClass('bw-loading').empty().append(bw_theme_ajax.string_facebook_error);
                            }
                        }, {
                            scope: 'public_profile, email'
                        });
                    }
                });
                
            },
            
            getUserInfo: function(callback) {
        
                "use strict";
                
                FB.api('/me?fields=email,name,first_name,last_name', function(response) {
                    callback(response);
                });
            },

            getUserPhoto: function(callback) {
        
                "use strict";
                
                FB.api('/me/picture?type=normal', function(response) {
                    callback(response.data.url);
                });
            },

            wpLogin: function(user, photo) {
        
                "use strict";
                
                var userid = user.id;
                var username = user.name;
                username = username.toLowerCase().replace(' ', '') + userid;
                var firstname = user.first_name;
                var lastname = user.last_name;
                var email = user.email;
                var avatar = photo;
                var security = $('#securitySignin').val();
                var ajaxURL = bw_theme_ajax.ajax;

                $.ajax({
                    type: 'POST',
                    dataType: 'json',
                    url: ajaxURL,
                    data: {
                        'action': '__call_facebook_login',
                        'userid': userid,
                        'signin_user': username,
                        'first_name': firstname,
                        'last_name': lastname,
                        'email': email,
                        'avatar': avatar,
                        'security': security
                    },
                    success: function(data) {
                        if(data.signedin === true) {
                            $('.bw-social-login-facebook').removeClass('bw-loading').empty().append(data.message);
                            document.location.href = bw_theme_ajax.home;
                        } else {
                            $('.bw-social-login-facebook').removeClass('bw-loading').empty().append(data.message);
                        }
                    },
                    error: function(errorThrown) {}
                });
            }
            
        }
        
    },
    
    loginWithAjax: function() {
        
        "use strict";
        
        $('.bw-form-trigger').on('click', function() {
            $('.bw-form-trigger').removeClass('bw-active');
            $(this).addClass('bw-active');
            $('.lwa .bw-form').removeClass('bw-form-active');
            $('.lwa .bw-form.bw-form-' + $(this).attr('data-action')).addClass('bw-form-active');
        });
        
        $('.lwa-status-invalid > a').live('click', function() {
            console.log(1111);
            $('.bw-form-trigger').removeClass('bw-active');
            $(this).addClass('bw-active');
            $('.lwa .bw-form').removeClass('bw-form-active');
            $('.lwa .bw-form.bw-form-password').addClass('bw-form-active');
        });
        
    },
    
    newsletter: function() {
        
        "use strict";
        
        var $nlsModal = $('#bw-nsl');
        if( $nlsModal.length && ! $nlsModal.hasClass('bw-dont-trigger') ) {
            setTimeout(function() {
                App.modal.triggerModal( 'bw-nsl' );
            }, 300);
        }
        
        $('.bw-open-modal-nsl').on('click', function() {
            App.modal.triggerModal( 'bw-nsl' );
        });
        
    },
    
    pad: function( number, size ) {
        
        "use strict";
        
        number = String( number );
        if ( number.length < ( size ) ) {
            number = "0" + number;
        }
        return number;
    },
    
    // push bw-breadcrumb
    breadcrumb: function() {
        
        "use strict";
        
        var $header = $('.bw-header'), $breadcrumb = $('.bw-breadcrumb-holder');
        if( ! $header.hasClass('bw-is-transparent') && ! $header.hasClass('bw-is-bottom') && ! $header.hasClass('bw-header-v1') && ! $body.hasClass('bw-overlap-header') ) {
            $breadcrumb.css('padding-top', $header.height() );
        }
    },
    
    container: function() {
        
        "use strict";
        
        var windowHeight = $(window).height();
        if( $('#wpadminbar').length ) {
            windowHeight -= $('#wpadminbar').height();
        }
        $('.bw-wrapper').css('min-height', windowHeight);
    },
    
    header: function() {
        
        "use strict";
        
        this.breadcrumb();
        
        // make sticky when header on bottom
        var $bottomHeader = $('.bw-is-sticky.bw-is-bottom');
        if( $bottomHeader.length ) {
            $window.scroll(function() {
                if( $window.scrollTop() > $window.height() ) {
                    $bottomHeader.addClass('bw-is-bottom-go');
                }else{
                    $bottomHeader.removeClass('bw-is-bottom-go');
                }
            });
        }
        // version 3 menu expand
        if( $('#bw-v3m').length ) {
            $('.bw-v3m-close, .bw-menuicon').on('click', function() {
                $body.toggleClass('bw-v3m-show');
                if( ! $body.hasClass('bw-v3m-show') ) {
                    TweenMax.killAll(false,true,false);
                    v3mTween.removeAttr('style');
                    v3mSocialTween.removeAttr('style');
                }else{
                    TweenMax.allFrom(v3mTween, 0.8, {delay:0,opacity:0,top:-15, ease: Power2.easeOut}, 0.1);
                    TweenMax.allFrom(v3mSocialTween, 0.4, {delay:0.3,opacity:0,top:-10, ease: Power2.easeOut}, 0.1);
                }
            });
        }
    },
    
    modal: {
        
        overlay: $('#bw-modal-bg'),
        ql: $('#bw-modal-quick-look'),
        
        start: function() {
        
            "use strict";
            
            var self = this;
            
            $('.bw-modal-close').live('click', function() {
                self.close();
            });
            
            $('.bw-open-modal').on('click', function() {
                self.triggerModal( $(this).attr('data-modal') );
            });
            
        },
        
        triggerModal: function( modal ) {
        
            "use strict";
            
            this.overlay.css({'opacity': 0.85, 'visibility':'visible'});
            $( '.bw-modal#' + modal ).addClass('bw-modal-open');
        },
        
        show: function( $this ) {
        
            "use strict";
            
            var modal = $this.attr('data-modal');
            
            if( typeof modal === 'undefined' ) { return; }
            
            this.overlay.css({'opacity': 0.85, 'visibility':'visible'});
            
            if( modal === 'bw-modal-quick-look' ) { this.quickLook( parseInt( $this.attr('data-product_id') ) ); }
            
            if( $('#' + modal ).length ) {
                $('#' + modal ).addClass('bw-modal-open');
            }
            
        },
        
        close: function() {
            
            "use strict";
            
            App.modal.overlay.css({'opacity': 0, 'visibility':'hidden'});
            $('.bw-modal').removeClass('bw-modal-open');
            
            App.imageZoom.stop();
            
            $body.removeClass('bw-mobile-menu-expanded');
        },
        
        quickLook: function( product_id ) {
        
            "use strict";
            
            if( typeof product_id === 'undefined' ) { return; }
            App.modal.ql.empty().addClass('bw-loading');
            
            $.ajax({
                type: "post", url: bw_theme_ajax.ajax,
                data: {
                    prod_id: product_id,
                    action: '__call_quick_look',
                },
                success: function( response ) {
                    
                    $(response).imagesLoaded(function() {
                        App.modal.ql.removeClass('bw-loading').html( response );
                        
                        // Variation Form
                        var form_variation = App.modal.ql.find( '.variations_form' );
                        
                        form_variation.wc_variation_form();
                        form_variation.trigger( 'check_variations' );

                        if( typeof $.fn.yith_wccl !== 'undefined' ) {
                            form_variation.yith_wccl();
                        }
                        
                        setTimeout(function() {
                            $('#bw-modal-quick-look .bw-ql').addClass('bw-animate');
                        }, 20);
                        
                        App.imageZoom.init( $('#bw-modal-quick-look .woocommerce-main-image') );
                        
                        
                    });
                    
                }
            });
            
        }
        
    },
    
    imageZoom: {
        
        init: function( $mainImage ) {
        
            "use strict";
            
            if( $body.hasClass('bw-image-zoom-enabled') ) {
                
                $mainImage.zoom({
                    url: $mainImage.attr('href'),
                    duration: 120,
                    onZoomIn: function() {
                        $(this).closest('.woocommerce-main-image').addClass('bw-image-zoomed');
                    },
                    onZoomOut: function() {
                        $(this).closest('.woocommerce-main-image').removeClass('bw-image-zoomed');
                    }
                });
                
            }
            
        },
        
        stop: function() {
        
            "use strict";
            
            if( $body.hasClass('bw-image-zoom-enabled') ) {
                
                $('#bw-modal-quick-look .woocommerce-main-image').trigger('zoom.destroy');
                
            }
            
        }
        
    },
    
    monthArray: new Array("Jan","Feb","Mar","Apr","May","Jun","Jul","Aug","Sep","Oct","Nov","Dec"),
    
    countdown: function(el,yr,m,d) {
        
        "use strict";
        
        if(!el.length) {return;}
        var theyear=yr;var themonth=m;var theday=d,
            today=new Date(),
            todayy=today.getYear();
        if (todayy < 1000) {todayy+=1900;}
        var todaym=today.getMonth(),
            todayd=today.getDate(),
            todayh=today.getHours(),
            todaymin=today.getMinutes(),
            todaysec=today.getSeconds(),
            todaystring=this.monthArray[todaym]+" "+todayd+", "+todayy+" "+todayh+":"+todaymin+":"+todaysec,
            futurestring=this.monthArray[m-1]+" "+d+", "+yr,
            dd=Date.parse(futurestring)-Date.parse(todaystring),
            dday=Math.floor(dd/(60*60*1000*24)*1),
            dhour=Math.floor((dd%(60*60*1000*24))/(60*60*1000)*1),
            dmin=Math.floor(((dd%(60*60*1000*24))%(60*60*1000))/(60*1000)*1),
            dsec=Math.floor((((dd%(60*60*1000*24))%(60*60*1000))%(60*1000))/1000*1);
        el.find('ul').html("<li><strong>"+dday+"</strong> Days</li><li><strong>"+('0000'+dhour).slice(-2)+"</strong> Hours</li><li><strong>"+('0000'+dmin).slice(-2)+"</strong> Mins</li><li><strong>"+('0000'+dsec).slice(-2)+"</strong> Secs</li>");
        setTimeout(function() {
            App.countdown(el,theyear,themonth,theday);
        }, 1000);
    },
    
    dealCounter: function() {
        
        "use strict";
        
        $('.bw-deal-counter').each(function() {
            var $counter = $(this);
            App.countdown( $counter, parseInt( $counter.attr('data-year') ), parseInt( $counter.attr('data-month') ), parseInt( $counter.attr('data-day') ) );
        });
        
    },
    
    woocommerce: {
        
        start: function() {
        
            "use strict";
        
            this.bind();
            
        },
        
        bind: function() {
        
            "use strict";
            
            $('.add_to_wishlist:not(.added):not(.loading), .remove_from_wishlist, #yith-wcwl-form .add_to_cart_button').live('click', function() {
                $('.bw-top-prods-wishlist').addClass('bw-ajaxing');
            });
            
            $('.bw-woo-buttons li').live('click', function(e) {
                e.preventDefault();
            });
            
            $('.bw-quick-look').live('click', this.quickLook);
            $('#bw-modal-bg').live('click', App.modal.close);
            $('.single_add_to_cart_button').live('click', this.buttonAddToCart);
            
            // bw-featured-products
            $('.bw-featured-tabs li').on('click', this.featuredProducts);
            
            // quantity input
            $('.bw-quant .bw-quantity').live('click', this.quantityInput);
            
            $('.woocommerce-main-image').live('click', function(e) { e.preventDefault(); });
            $('.thumbnails > a').live('click', this.qlGallery);
            
            App.imageZoom.init( $('.bw-image-zoom-enabled.single-product .woocommerce-main-image:first') );
            
        },
        
        qlGallery: function(e) {
            
            "use strict";
            
            e.preventDefault();
            
            var $this = $(this), imgSrc = $this.attr('data-image-cat'), imgFull = $this.attr('data-image-full');
            
            if( $body.hasClass('bw-image-zoom-enabled') ) {
                App.imageZoom.stop();
            }
            
            $('<img src="' + imgSrc + '">').load(function() {
                
                $this.closest('.images').find('.woocommerce-main-image img.attachment-shop_single').attr('src', imgSrc).removeAttr('srcset').closest('.woocommerce-main-image').attr('href', imgFull);
                var $mainImage = $this.closest('.images').find('.woocommerce-main-image');
                if( ! $this.closest('.bw-ql').length ) { $mainImage.trigger('zoom.destroy'); }
                App.imageZoom.init( $mainImage );
                
            });
            
        },
        
        quantityInput: function() {
            
            "use strict";
            
            var $this = $(this), $input = $this.closest('.bw-quant').find('input:first'), toSum = parseInt( $input.val() ) + ( $this.hasClass('bw-quantity-plus') ? 1 : -1 );
            
            if( $this.closest('.group_table').length ) {
                if( toSum < 0 ) { return; }
            }else{
                if( toSum <= 0 ) { return; }
            }
            
            $input.val( ('0000'+toSum).slice(-2) );
        },
        
        featuredProducts: function() {
        
            "use strict";
            
            var $this = $(this), $featured = $this.closest('.bw-featured-products'), $featuredTabs = $this.closest('.bw-featured-tabs').find('li'), $featuredList = $featured.find('ul.products');
            
            if( $featured.hasClass('bw-ajaxing') || $this.hasClass('bw-active') ) { return; }
            
            $featured.addClass('bw-ajaxing');
            $featuredTabs.removeClass('bw-active');
            $this.addClass('bw-active');
            
            var productData = {
                'action'            : '__call_featured_products',
                'tab'               : $this.attr('data-tab'),
                'number_of_posts'   : $featured.attr('data-number_of_posts'),
                'items_per_row'     : $featured.attr('data-items_per_row')
            };
            
            if( typeof $featured.attr('data-category') !== 'undefined' ) { productData.category = $featured.attr('data-category'); }
            
            $.ajax({
                type: "post", url: bw_theme_ajax.ajax,
                data: productData,
                success: function( response ) {
                    $(response).imagesLoaded(function() {
                        $featured.removeClass('bw-ajaxing');
                        $featuredList.html( response );
                        
                        // featured slider - rebuild owl carousel
                        if( $featured.find('.bw-featured-slider').length ) {
                            App.slider.rebuild( $featured.find('.bw-featured-slider') );
                        }
                        
                    });
                }
            });
            
        },
        
        buttonAddToCart: function(e) {
        
            "use strict";
                
            var $this = $(this), type = $this.closest('.bw-product-type').attr('data-type');
            
            if( type !== 'external' ) {
                
                e.preventDefault();
                
                var productData = {};
                $('form.cart').serializeArray().map(function(x){productData[x.name] = x.value;});
                productData['action'] = '__call_add_to_cart';
                
                if( type == 'grouped' ) {
                    var groupedTotal = 0;
                    $('.bw-select-quantity').remove();
                    $('form.cart .quantity > input').each(function() {
                        groupedTotal += parseInt( $(this).val() );
                    });
                    if( groupedTotal <= 0 ) {$('form.cart').append('<p class="bw-select-quantity">Please select quantity.</p>'); return; }
                }
                
                $this.addClass('bw-loading');
                
                $.ajax({
                    type: "post", url: bw_theme_ajax.ajax,
                    data: productData,
                    success: function( response ) {
                        
                        $this.removeClass('bw-loading').addClass('bw-added');
                        var $cart = $('.cart-contents sub');
                        var currentCartNumber = parseInt( $cart.html() );
                        
                        if( type == 'grouped' ) {
                            var cartPutNum = groupedTotal;
                        }else{
                            var cartPutNum = typeof productData.quantity == 'undefined' ? 1 : parseInt( productData.quantity );
                        }
                        
                        App.woocommerce.cartPut( currentCartNumber + cartPutNum );
                    }
                });
            
            }
        },
        
        quickLook: function( e ) {
            
            "use strict";
            
            e.preventDefault();
            var $this = $(this);
            
            App.modal.show( $(this) );
            
        },
        
        // cart adding animation
        cartPuter: false,
        
        cartPut: function( cartNumber ) {
        
            "use strict";
            
            var $cart = $('.cart-contents sub');
            var currentCartNumber = parseInt( $cart.html() );
            
            if( this.cartPuter ) {
                
                $cart.html( cartNumber );
                
                $cart.removeClass( 'animated bounceIn' );
                setTimeout(function() {
                    $cart.addClass( 'animated bounceIn' );
                }, 30);
            }
            
            this.cartPuter = true;
            
        },
        
        // add to wishlist
        wishlistPut: function( action ) {
            
            "use strict";
            
            if( typeof action === 'undefined' ) { action = 1; }
            
            var $wishlist = $('.bw-wishlist sub');
            
            if( $wishlist.length === 0 ) {
                $wishlist = $('<sub/>', {'class' : 'bw-round', 'text' : '0'}).appendTo($('.bw-wishlist'));
            }
            
            var currentCartNumber = parseInt( $wishlist.html() );
            var cartNumber = currentCartNumber + action;
            
            $wishlist.html( cartNumber );
            $wishlist.removeClass( 'animated bounceIn' );
            setTimeout(function() {
                $wishlist.addClass( 'animated bounceIn' );
            }, 30);
            
            this.wishlistRefresh();
            
        },
        
        wishlistRefresh: function() {
        
            "use strict";
            
            $.ajax({
                type: "post", url: bw_theme_ajax.ajax,
                data: {
                    action: '__call_prod_wishlist',
                },
                success: function( response ) {
                    var $wishlist = $('.bw-top-prods-wishlist');
                    imagesLoaded( $(response), function() {
                        $wishlist.html( response );
                        setTimeout(function() {
                            $wishlist.removeClass('bw-ajaxing')
                        }, 30);
                    });
                    
                }
            });
            
        }
        
    },
    
    shareSocial: function(e) {
        e.preventDefault();
        self = $(this);
        var left = (screen.width - 640) / 2;
        var top = (screen.height - 320) / 2.5;
        window.open(self.attr('href'), 'facebook_share', 'height=320, width=640, toolbar=no, menubar=no, scrollbars=no, resizable=no, location=no, directories=no, status=no, top=' + top + ', left=' + left);
    },
    
    bind: function() {
        
        "use strict";
        
        // share icons popup
        if( ! bw_theme_ajax.ismobile ) {
            $('.bw-add-share').live('click', App.shareSocial);
        }
        
        // mobile search
        $('.bw-hm-search-icon').on('click', App.mobileSearch);
        
        // mobile menu
        $('.bw-hm-icon-menu').on('click', App.mobileMenu);
        
        // faq
        $('.bw-faq-title').on('click', this.faq);
        
        // disable empty url\'s
        $(document).on('click', 'a[href="#"]', function(e) {
            e.preventDefault();
        });
        
        // section load more
        var loadMoreSection  = '.bw-section-load-more',
            sectionAppend    = '.bw-section-append',
            loadMore         = '.bw-load-more',
            ajaxLoadingClass = 'bw-ajax-loading',
            excludeItem      = 'article:not(.bw-exclude-item)';
        
        $(loadMoreSection).each(function( i, el ) {
            var $el = $(el);
            $(el).on( 'click', '.bw-load-more-btn', function( e ) {
                var $clicked = $(this).closest($(loadMore));
                if( $clicked.hasClass( ajaxLoadingClass ) || $clicked.hasClass('bw-no-more') ) { return; }
                var $new_archive = $( '<div/>' );
                $clicked.addClass( ajaxLoadingClass );
                $new_archive.load( $clicked.attr( 'data-page-load' ), false, function( response ) {
                    $new_archive = $( response ).find(loadMoreSection);
                    var $new_items_clicked = $new_archive.eq( $el.index( loadMoreSection ) );
                    $clicked.replaceWith($new_items_clicked.find( loadMore ));
                    $new_items_clicked.imagesLoaded(function() {
                        var $toAppend = $new_items_clicked.find( sectionAppend ).children( excludeItem );
                        $el.find(sectionAppend).append( $toAppend ).isotope( 'appended', $toAppend ).isotope( 'reloadItems' ).isotope({filter: '*'});
                        if( typeof App.djax !== 'undefined' ) { App.djax( $toAppend ); }
                        var $loadMoreBtn = $el.find('.bw-load-more-btn');
                        if( $loadMoreBtn.length ) {
                            $loadMoreBtn.removeClass( ajaxLoadingClass );
                        }else{
                            $el.find(loadMore).addClass('bw-no-more').html('<span class="bw-load-more-placeholder"><i class="fa fa-check"></i></span>');
                            setTimeout(function() { $el.find('.bw-load-more-placeholder').css('opacity', 0.12); }, 2000);
                        }
                    });
                    // reset filter after load more
                    $el.find('.bw-isotope-filter li:first a').trigger('click');
                });
            });
        });
    },
    
    waypoints: function() {
        
        "use strict";
        
        $('.bw-creanim').waypoint( function( direction ) {
            var el = this.element;
            if( $(el).closest('.bw-creanim-slider').length ) { this.destroy();return; }
            $(el).addClass('bw-animated');
            this.destroy();
        }, { offset: '80%' });
        
        $('.bw-look').waypoint( function( direction ) {
            var el = this.element;
            $(el).addClass('bw-animated');
            this.destroy();
        }, { offset: '80%' });
        
        // scroller
        var scroller = $('.bw-scroller');
        if( scroller.length ) {
            var numRows = $('.bwpb-row').length;
            if( numRows > 0 ) {
                
                // bind arrows
                $('i', scroller).on('click', function() {
                    var sectionToScrollIndex = parseInt( $('em', scroller).html() ) + ( $(this).hasClass('bw-scroller-up') ? -1 : 1 );
                    if( sectionToScrollIndex > 0 && sectionToScrollIndex <= numRows ) {
                        var sectionScroll = $('.bwpb-row').eq( sectionToScrollIndex - 1 ).offset().top;
                        $('html, body').animate({scrollTop: sectionScroll}, {duration: 550, easing: 'swing'});
                    }
                });
                
                $('span', scroller).html( App.pad( numRows, 5 ) );
                
                $('.bwpb-row').waypoint( function( direction ) {
                    var el = this.element;
                    var viewportRowIndex = $( ".bwpb-row" ).index( $(el) ) + ( direction == 'down' ? 1 : 0 );
                    $('em', scroller).html( App.pad( viewportRowIndex, 2 ) );
                }, { offset: '50%' });
                
            }
        }
        
    },
    
    slider: {
        
        start: function() {
        
            "use strict";
            
            this.build();
        },
        
        check: function( $el, param ) {
            
            "use strict";
            
            return typeof $el.attr(param) !== 'undefined';
        },
        
        getCarouselOptions: function( $slider ) {
            
            "use strict";
            
            var self = this;
            
            return {
                pagination          : this.check($slider, 'data-pagination'),
                navigation          : this.check($slider, 'data-navigation'),
                autoPlay            : this.check($slider, 'data-autoplay'),
                autoHeight          : this.check($slider, 'data-autoheight'),
                afterMove           : App.slider.afterMove,
                afterInit           : App.slider.afterInit,
                items               : typeof $slider.attr('data-slides') !== 'undefined' ? parseInt( $slider.attr('data-slides') ) : 1,
                singleItem          : typeof $slider.attr('data-slides') !== 'undefined' && $slider.attr('data-slides') == '1' ? true : false,
            };
        },
        
        build: function( $sliderElement ) {
            
            "use strict";
            
            var self = this;
            
            if( typeof $sliderElement == 'undefined' ) { var $sliderElement = $('.bw-slider')}
            
            if( $sliderElement.length > 0 ) {
                $sliderElement.each(function() {
                    
                    var $slider = $(this);
                    
                    $slider.imagesLoaded(function() {
                        
                        $slider.owlCarousel( self.getCarouselOptions( $slider ) );
                        
                    });
                    
                });
            }
        },
        
        rebuild: function( $sliderElement ) {
        
            "use strict";
            
            $sliderElement.data('owlCarousel').reinit(this.getCarouselOptions( $sliderElement ));
        },
        
        afterMove: function( elem ) {
            
            "use strict";
            
            // creative animation slider
            if( elem.hasClass('bw-creanim-slider') ) {
                
                // fade in slide
                var current = this.currentItem;
                elem.find('.owl-item').eq(current).find(' > .bw-creanim').addClass('bw-animated');
                
                // fade out slide
                var prev = this.prevItem;
                elem.find('.owl-item').eq(prev).find(' > .bw-creanim').removeClass('bw-animated');
            }
        },
        
        afterInit: function( elem ) {
            
            "use strict";
            
            if( elem.hasClass('bw-creanim-slider') ) {
                var current = this.currentItem;
                elem.find('.owl-item').eq(0).find(' > .bw-creanim').addClass('bw-animated');
            }
        }
        
    },
    
    smartResize: function() {
        
        "use strict";
        
        $(window).bind("debouncedresize", function() {
            
            App.equalHeight( $('.bw-isotope article') );
            
            App.breadcrumb();
            
            App.container();
            
            App.modal.close();
            $body.removeClass('bw-mobile-menu-expanded');
            
        });
        
    },
    
    isotope: function() {
        
        "use strict";
        
        var $isotope = $('.bw-isotope');
        
        $isotope.imagesLoaded(function() {
            $isotope.isotope({
                itemSelector: 'article', // item selector
                resizable: false, // disable default resizing
                layoutMode: 'fitRows' // all elements will output with the same height
            });
            
            var $isFil = $('.bw-isotope-filter');
            if( $isFil.length > 0 ) {
                $('a', $isFil).on('click', function(e) {
                    e.preventDefault();
                    $(this).closest('ul').find('li').removeClass('active');
                    $(this).closest('li').addClass('active');
                    var filter = $(this).attr('data-filter');
                    if(typeof(filter) !== 'undefined') {
                        $isotope.isotope({filter: function() {
                            if( $(this).hasClass('bw-portf-head') ) { return true; }
                            return $(this).hasClass( filter );
                        }});
                    }else{
                        $isotope.isotope({filter: '*'});
                    }
                });
            }
            
        });
        
    },
    
    equalHeight: function( group ) {
        
        "use strict";
        
        var tallest = 0;
        group.each(function() {
            var thisHeight = $(this).height();
            if( thisHeight > tallest ) {
                tallest = thisHeight;
            }
        });
        group.height( tallest );
    },
    
    magnificPopup: function() {
        
        "use strict";
        
        $(".bw-lightbox, .post a[href$='.jpg'], .post a[href$='.jpeg'], .post a[href$='.png'], .post a[href$='.gif'], .page a[href$='.jpg'], .page a[href$='.jpeg'], .page a[href$='.png'], .page a[href$='.gif'], .bw-project-container a[href$='.jpg'], .bw-project-container a[href$='.jpeg'], .bw-project-container a[href$='.png'], .bw-project-container a[href$='.gif']").magnificPopup({
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
                    values.title = ( ( typeof item.el.attr('data-title') !== 'undefined' ) ? item.el.attr('data-title') : '' ) + '<small>' +
                    ( ( typeof item.el.attr('data-alt') !== 'undefined' ) ? item.el.attr('data-alt') : '' ) + '</small>';
                }
            }
        });
    }

}

App.start();