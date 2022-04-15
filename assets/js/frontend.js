(function ($) {
    "use strict";
    
    var getElementSettings = function( $element ) {
		var elementSettings = {},
			modelCID 		= $element.data( 'model-cid' );

		if ( isEditMode && modelCID ) {
			var settings 		= elementorFrontend.config.elements.data[ modelCID ],
				settingsKeys 	= elementorFrontend.config.elements.keys[ settings.attributes.widgetType || settings.attributes.elType ];

			jQuery.each( settings.getActiveControls(), function( controlKey ) {
				if ( -1 !== settingsKeys.indexOf( controlKey ) ) {
					elementSettings[ controlKey ] = settings.attributes[ controlKey ];
				}
			} );
		} else {
			elementSettings = $element.data('settings') || {};
		}

		return elementSettings;
	};

    var isEditMode		= false;

    /**
	 * Testimonials Carousel handler Function.
	 *
	 */
    var TestimonialsCarouselHandler = function ( $scope, $ ) {
        var $carousel            = $scope.find( '.blank-testimonials-carousel' ).eq( 0 ),
            $slider_wrap         = $scope.find( '.blank-testimonials-carousel .slick-slide' ),
            elementSettings      = getElementSettings( $scope ),
            $arrow_next          = elementSettings.arrow,
            $arrow_prev          = ( $arrow_next !== undefined ) ? $arrow_next.replace( "right", "left" ) : '',
			$items               = ( elementSettings.slides_per_view !== undefined && elementSettings.slides_per_view !== '' ) ? parseInt( elementSettings.slides_per_view.size ) : 1,
			$items_tablet        = ( elementSettings.slides_per_view_tablet !== undefined && elementSettings.slides_per_view_tablet !== '' ) ? parseInt( elementSettings.slides_per_view_tablet.size ) : 1,
			$items_mobile        = ( elementSettings.slides_per_view_mobile !== undefined && elementSettings.slides_per_view_mobile !== '' ) ? parseInt( elementSettings.slides_per_view_mobile.size ) : 1,
			$items_scroll        = ( elementSettings.slides_to_scroll !== undefined && elementSettings.slides_to_scroll !== '' ) ? parseInt( elementSettings.slides_to_scroll ) : 1,
			$items_scroll_tablet = ( elementSettings.slides_to_scroll_tablet !== undefined && elementSettings.slides_to_scroll_tablet !== '' ) ? parseInt( elementSettings.slides_to_scroll_tablet ) : 1,
			$items_scroll_mobile = ( elementSettings.slides_to_scroll_mobile !== undefined && elementSettings.slides_to_scroll_mobile !== '' ) ? parseInt( elementSettings.slides_to_scroll_mobile ) : 1;
        
            $carousel.slick({
                slidesToShow:           $items,
				slidesToScroll:  		$items_scroll,
                autoplay:               'yes' === elementSettings.autoplay,
                autoplaySpeed:          elementSettings.autoplay_speed,
                arrows:                 'yes' === elementSettings.arrows,
                prevArrow:              '<div class="blank-slider-arrow blank-arrow blank-arrow-prev"><i class="' + $arrow_prev + '"></i></div>',
				nextArrow:              '<div class="blank-slider-arrow blank-arrow blank-arrow-next"><i class="' + $arrow_next + '"></i></div>',
                dots:                   'yes' === elementSettings.dots,
                fade:                   'fade' === elementSettings.effect,
                speed:                  elementSettings.animation_speed,
                infinite:               'yes' === elementSettings.loop,
                pauseOnHover:           'yes' === elementSettings.pause_on_hover,
                adaptiveHeight:         'yes' === elementSettings.adaptive_height,
                rtl:                    'right' === elementSettings.direction,
                responsive: [
                    {
                    breakpoint: 1024,
                        settings: {
                            slidesToShow: $items_tablet,
							slidesToScroll: $items_scroll_tablet,
                        }
                    },
                    {
                    breakpoint: 768,
                        settings: {
                            slidesToShow: $items_mobile,
							slidesToScroll: $items_scroll_mobile,
                        }
                    },
                ]
            });

            $carousel.slick( 'setPosition' );

            if ( isEditMode ) {
                $slider_wrap.resize( function() {
                    $carousel.slick( 'setPosition' );
                });
            }
    };

    /**
	 * Slider handler Function.
	 *
	 */
    var SliderHandler = function ( $scope, $ ) {
        var $carousel            = $scope.find( '.blank-slider' ).eq( 0 ),
            $slider_wrap         = $scope.find( '.blank-slider .slick-slide' ),
            elementSettings      = getElementSettings( $scope );
        
            $carousel.slick({
                slidesToShow:           1,
				slidesToScroll:  		1,
                autoplay:               false,
                vertical:               true,
                arrows:                 false,
                prevArrow:"<button type='button' class='slick-prev pull-left'><i class='fa fa-angle-left' aria-hidden='true'></i></button>",
                nextArrow:"<button type='button' class='slick-next pull-right'><i class='fa fa-angle-right' aria-hidden='true'></i></button>",
                dots:                   true,
                infinite:               true,
                pauseOnHover:           true,
                adaptiveHeight:         true,
                responsive: [
                    {
                    breakpoint: 1024,
                        settings: {
                            slidesToShow: 1,
							slidesToScroll: 1,
                        }
                    },
                    {
                    breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
							slidesToScroll: 1,
                        }
                    },
                ]
            });

            $carousel.slick( 'setPosition' );

            if ( isEditMode ) {
                $slider_wrap.resize( function() {
                    $carousel.slick( 'setPosition' );
                });
            }
    };
    
    /**
	 * Instagram handler Function.
	 *
	 */
    var InstagramFeedHandler = function ($scope, $) {
        var instafeed_elem              = $scope.find('.blank-instagram-feed').eq(0),
            settings                    = instafeed_elem.data('settings'),
            pp_widget_id                = settings.target,
            pp_popup                    = settings.popup,
            like_span                   = (settings.likes === '1') ? '<span class="likes"><i class="fa fa-heart"></i> {{likes}}</span>' : '',
            comments_span               = (settings.comments === '1') ? '<span class="comments"><i class="fa fa-comment"></i> {{comments}}</span>' : '',
            $more_button                = instafeed_elem.find('.blank-load-more-button'),
        
            feed = new Instafeed({
                get:                    'user',
                userId:                 settings.user_id,
                sortBy:                 settings.sort_by,
                accessToken:            settings.access_token,
                limit:                  settings.images_count,
                target:                 pp_widget_id,
                resolution:             settings.resolution,
                orientation:            'portrait',
                template:               function () {
                    if (pp_popup === '1') {
                        return '<div class="blank-feed-item"><a href="{{image}}"><div class="blank-overlay-container">' + like_span + comments_span + '</div><img src="{{image}}" /></a></div>';
                    } else {
                        return '<div class="blank-feed-item">' +
                            '<a href="{{link}}">' +
                                '<div class="blank-overlay-container">' + like_span + comments_span + '</div>' +
                                '<img src="{{image}}" />' +
                            '</a>' +
                            '</div>';
                    }
                }(),
                after: function () {
                    if (!this.hasNext()) {
                        $more_button.attr('disabled', 'disabled');
                    }
                },
                success: function() {
                    $more_button.removeClass( 'blank-button-loading' );
                    $more_button.find( '.blank-load-more-button-text' ).html( 'Load More' );
                }
            });
        
        $more_button.on('click', function() {
            feed.next();
            $more_button.addClass( 'blank-button-loading' );
            $more_button.find( '.blank-load-more-button-text' ).html( 'Loading...' );
        });
        
        feed.run();
        
        if (pp_popup === '1') {
            $(pp_widget_id).each(function () {
                $(this).magnificPopup({
                    delegate: 'div a', // child items selector, by clicking on it popup will open
                    gallery: {
                        enabled: true,
                        navigateByImgClick: true,
                        preload: [0, 1]
                    },
                    type: 'image'
                });
            });
        }
    };
    
    /**
	 * Counter handler Function.
	 *
	 */
    var CounterHandler = function ($scope, $) {
        var counter_elem                = $scope.find('.blank-counter').eq(0),
            $target                     = counter_elem.data('target');
        
        $(counter_elem).waypoint(function () {
            $($target).each(function () {
                var v                   = $(this).data("to"),
                    speed               = $(this).data("speed"),
                    od                  = new Odometer({
                        el:             this,
                        value:          0,
                        duration:       speed
                    });
                od.render();
                setInterval(function () {
                    od.update(v);
                });
            });
        },
            {
                offset:             "80%",
                triggerOnce:        true
            });
    };
    
    /**
	 * Post Slider handler Function.
	 *
	 */
    var PostsSliderHandler = function ( $scope, $ ) {
        var $carousel            = $scope.find( '.blank-portfolio-slider' ).eq( 0 ),
            elementSettings      = getElementSettings( $scope ),
            $arrow_next          = elementSettings.arrow,
            $arrow_prev          = ( $arrow_next !== undefined ) ? $arrow_next.replace( "right", "left" ) : '',
            $scrollable_nav      = elementSettings.scrollable_nav,
            $preview_position    = elementSettings.preview_position,
            $stack_on            = elementSettings.preview_stack;
        var time = 2;
        var $bar,
            $barRound,
            $slick,
            isPause,
            tick,
            percentTime;
        
            $carousel.slick({
                slidesToShow:           1,
				slidesToScroll:  		1,
                autoplay:               'yes' === elementSettings.autoplay,
                autoplaySpeed:          elementSettings.autoplay_speed,
                arrows:                 'yes' === elementSettings.arrows,
                prevArrow:              '<div class="pp-slider-arrow pp-arrow pp-arrow-prev"><i class="' + $arrow_prev + '"></i></div>',
				nextArrow:              '<div class="pp-slider-arrow pp-arrow pp-arrow-next"><i class="' + $arrow_next + '"></i></div>',
                dots:                   'yes' === elementSettings.dots,
                fade:                   'fade' === elementSettings.effect,
                speed:                  elementSettings.animation_speed,
                infinite:               'yes' === elementSettings.infinite_loop,
                pauseOnHover:           'yes' === elementSettings.pause_on_hover,
                adaptiveHeight:         'yes' === elementSettings.adaptive_height,
                rtl:                    'right' === elementSettings.direction,
            });
        
        $bar = $('.slider-progress .progress');
        $barRound = $('.progress');
        
        $('.blank-portfolio-slider').on({
            mouseenter: function() {
              isPause = true;
            },
            mouseleave: function() {
              isPause = false;
            }
        })

        function startProgressbar() {
            resetProgressbar();
            percentTime = 0;
            isPause = false;
            tick = setInterval(interval, 15);
        }
        var $rbar = $('.progress circle');
        var rlen = 2 * Math.PI * $rbar.attr('r');

        function interval() {
            if(isPause === false) {
                percentTime += 1 / (time + 0.1);
                $bar.css({
                    width: percentTime + '%'
                });
                $rbar.css({
                    'stroke-dasharray': rlen,
                    'stroke-dashoffset': rlen * (1 - percentTime / 100)
                });

                if (percentTime >= 100) {
                    $carousel.slick('slickNext');
                    startProgressbar();
                }
            }

        }


        function resetProgressbar() {
            $bar.css({
                width: 0 + '%'
            });
            clearTimeout(tick);
        }

        startProgressbar();
    };
    
    /**
	 * Woo mini cart handler Function.
	 *
	 */
    var WooMiniCartHandler = function ($scope, $) {
		new BlankWooMiniCart( $scope );
	};
    
    /**
	 * Nav Menu handler Function.
	 *
	 */
	var WidgethfeNavMenuHandler = function( $scope, $ ) {

		if ( 'undefined' == typeof $scope )
			return;
		
		var id = $scope.data( 'id' );
		var wrapper = $scope.find('.elementor-widget-blank-navigation ');		
		var layout = $( '.elementor-element-' + id + ' .be-nav-menu' ).data( 'layout' );
		var flyout_data = $( '.elementor-element-' + id + ' .be-flyout-wrapper' ).data( 'flyout-class' );
		var last_item = $( '.elementor-element-' + id + ' .be-nav-menu' ).data( 'last-item' );
		var last_item_flyout = $( '.elementor-element-' + id + ' .be-flyout-wrapper' ).data( 'last-item' );

		$( 'div.be-has-submenu-container' ).removeClass( 'sub-menu-active' );

		_toggleClick( id );

		if( 'horizontal' !== layout ){

			_eventClick( id );
		}else if ( 'horizontal' === layout && window.matchMedia( "( max-width: 767px )" ).matches ) {

			_eventClick( id );
		}else if ( 'horizontal' === layout && window.matchMedia( "( max-width: 1024px )" ).matches ) {

			_eventClick( id );
		}

		$( '.elementor-element-' + id + ' .be-flyout-trigger .be-nav-menu-icon' ).off( 'click keyup' ).on( 'click keyup', function() {

			_openMenu( id );
		} );

		$( '.elementor-element-' + id + ' .be-flyout-close' ).off( 'click keyup' ).on( 'click keyup', function() {

			_closeMenu( id );
		} );

		$( '.elementor-element-' + id + ' .be-flyout-overlay' ).off( 'click' ).on( 'click', function() {

			_closeMenu( id );
		} );	


		$scope.find( '.sub-menu' ).each( function() {

			var parent = $( this ).closest( '.menu-item' );

			$scope.find( parent ).addClass( 'parent-has-child' );
			$scope.find( parent ).removeClass( 'parent-has-no-child' );
		});

		if( ( 'cta' == last_item || 'cta' == last_item_flyout ) && 'expandible' != layout ){
			$( '.elementor-element-' + id + ' li.menu-item:last-child a.be-menu-item' ).parent().addClass( 'elementor-button-wrapper' );
			$( '.elementor-element-' + id + ' li.menu-item:last-child a.be-menu-item' ).addClass( 'elementor-button' );			
		}

		_borderClass( id );	

		$( window ).resize( function(){ 

			if( 'horizontal' !== layout ) {

				_eventClick( id );
			}else if ( 'horizontal' === layout && window.matchMedia( "( max-width: 767px )" ).matches ) {

				_eventClick( id );
			}else if ( 'horizontal' === layout && window.matchMedia( "( max-width: 1024px )" ).matches ) {

				_eventClick( id );
			}

			if( 'horizontal' == layout && window.matchMedia( "( min-width: 977px )" ).matches){

				$( '.elementor-element-' + id + ' div.be-has-submenu-container' ).next().css( 'position', 'absolute');	
			}

			if( 'expandible' == layout || 'flyout' == layout ){

				_toggleClick( id );
			}else if ( 'vertical' == layout || 'horizontal' == layout ) {
				if( window.matchMedia( "( max-width: 767px )" ).matches && ($( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-tablet') || $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-mobile'))){

					_toggleClick( id );					
				}else if ( window.matchMedia( "( max-width: 1024px )" ).matches && $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-tablet') ) {
					
					_toggleClick( id );
				}
			}

			_borderClass( id );	

		});

        // Acessibility functions

  		$scope.find( '.parent-has-child .be-has-submenu-container a').attr( 'aria-haspopup', 'true' );
  		$scope.find( '.parent-has-child .be-has-submenu-container a').attr( 'aria-expanded', 'false' );

  		$scope.find( '.be-nav-menu__toggle').attr( 'aria-haspopup', 'true' );
  		$scope.find( '.be-nav-menu__toggle').attr( 'aria-expanded', 'false' );

  		// End of accessibility functions

		$( document ).trigger( 'hfe_nav_menu_init', id );

		$( '.elementor-element-' + id + ' div.be-has-submenu-container' ).on( 'keyup', function(e){

			var $this = $( this );

		  	if( $this.parent().hasClass( 'menu-active' ) ) {

		  		$this.parent().removeClass( 'menu-active' );

		  		$this.parent().next().find('ul').css( { 'visibility': 'hidden', 'opacity': '0', 'height': '0' } );
		  		$this.parent().prev().find('ul').css( { 'visibility': 'hidden', 'opacity': '0', 'height': '0' } );

		  		$this.parent().next().find( 'div.be-has-submenu-container' ).removeClass( 'sub-menu-active' );
		  		$this.parent().prev().find( 'div.be-has-submenu-container' ).removeClass( 'sub-menu-active' );
			}else { 

				$this.parent().next().find('ul').css( { 'visibility': 'hidden', 'opacity': '0', 'height': '0' } );
		  		$this.parent().prev().find('ul').css( { 'visibility': 'hidden', 'opacity': '0', 'height': '0' } );

		  		$this.parent().next().find( 'div.be-has-submenu-container' ).removeClass( 'sub-menu-active' );
		  		$this.parent().prev().find( 'div.be-has-submenu-container' ).removeClass( 'sub-menu-active' );

				$this.parent().siblings().find( '.be-has-submenu-container a' ).attr( 'aria-expanded', 'false' );

				$this.parent().next().removeClass( 'menu-active' );
		  		$this.parent().prev().removeClass( 'menu-active' );

				event.preventDefault();

				$this.parent().addClass( 'menu-active' );

				if( 'horizontal' !== layout ){
					$this.addClass( 'sub-menu-active' );	
				}
				
				$this.find( 'a' ).attr( 'aria-expanded', 'true' );

				$this.next().css( { 'visibility': 'visible', 'opacity': '1', 'height': 'auto' } );

				if ( 'horizontal' !== layout ) {
						
		  			$this.next().css( 'position', 'relative');			
				} else if ( 'horizontal' === layout && window.matchMedia( "( max-width: 767px )" ).matches && ($( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-tablet') || $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-mobile'))) {
										
  					$this.next().css( 'position', 'relative');		  					
				} else if ( 'horizontal' === layout && window.matchMedia( "( max-width: 1024px )" ).matches ) {
					
  					if ( $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-tablet') ) {

  						$this.next().css( 'position', 'relative');	
  					} else if ( $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-mobile') || $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-none') ) {
  						
  						$this.next().css( 'position', 'absolute');	
  					}
  				}		
			}
		});

		$( '.elementor-element-' + id + ' li.menu-item' ).on( 'keyup', function(e){
			var $this = $( this );

	 		$this.next().find( 'a' ).attr( 'aria-expanded', 'false' );
	 		$this.prev().find( 'a' ).attr( 'aria-expanded', 'false' );
	  		
	  		$this.next().find('ul').css( { 'visibility': 'hidden', 'opacity': '0', 'height': '0' } );
	  		$this.prev().find('ul').css( { 'visibility': 'hidden', 'opacity': '0', 'height': '0' } );
	  		
	  		$this.siblings().removeClass( 'menu-active' );
	  		$this.next().find( 'div.be-has-submenu-container' ).removeClass( 'sub-menu-active' );
		  	$this.prev().find( 'div.be-has-submenu-container' ).removeClass( 'sub-menu-active' );
		  		
		});
	};

	function _openMenu( id ) {

		var layout = $( '#be-flyout-content-id-' + id ).data( 'layout' );
		var layout_type = $( '#be-flyout-content-id-' + id ).data( 'flyout-type' );
		var wrap_width = $( '#be-flyout-content-id-' + id ).data( 'width' ) + 'px';
		var container = $( '.elementor-element-' + id + ' .be-flyout-container .be-side.be-flyout-' + layout );

		$( '.elementor-element-' + id + ' .be-flyout-overlay' ).fadeIn( 100 );

		if( 'left' == layout ) {

			$( 'body' ).css( 'margin-left' , '0' );
			container.css( 'left', '0' );

			if( 'push' == layout_type ) {

				$( 'body' ).addClass( 'be-flyout-animating' ).css({ 
					position: 'absolute',
					width: '100%',
					'margin-left' : wrap_width,
					'margin-right' : 'auto'
				});
			}		
		} else {

			$( 'body' ).css( 'margin-right', '0' );
			container.css( 'right', '0' );

			if( 'push' == layout_type ) {

				$( 'body' ).addClass( 'be-flyout-animating' ).css({ 
					position: 'absolute',
					width: '100%',
					'margin-left' : '-' + wrap_width,
					'margin-right' : 'auto',
				});
			}
		}		
	}

	function _closeMenu( id ) {

		var layout    = $( '#be-flyout-content-id-' + id ).data( 'layout' );
		var wrap_width = $( '#be-flyout-content-id-' + id ).data( 'width' ) + 'px';
		var layout_type = $( '#be-flyout-content-id-' + id ).data( 'flyout-type' );
		var container = $( '.elementor-element-' + id + ' .be-flyout-container .be-side.be-flyout-' + layout );

		$( '.elementor-element-' + id + ' .be-flyout-overlay' ).fadeOut( 100 );	

		if( 'left' == layout ) {

			container.css( 'left', '-' + wrap_width );

			if( 'push' == layout_type ) {

				$( 'body' ).css({ 
					position: '',
					'margin-left' : '',
					'margin-right' : '',
				});

				setTimeout( function() {
					$( 'body' ).removeClass( 'be-flyout-animating' ).css({ 
						width: '',
					});
				});
			}			
		} else {
			container.css( 'right', '-' + wrap_width );
			
			if( 'push' == layout_type ) {

				$( 'body' ).css({
					position: '',
					'margin-right' : '',
					'margin-left' : '',
				});

				setTimeout( function() {
					$( 'body' ).removeClass( 'be-flyout-animating' ).css({ 
						width: '',
					});
				});
			}
		}	
	}

	function _eventClick( id ){

		var layout = $( '.elementor-element-' + id + ' .be-nav-menu' ).data( 'layout' );

		$( '.elementor-element-' + id + ' div.be-has-submenu-container' ).off( 'click' ).on( 'click', function( event ) {

			var $this = $( this );
			
		  	if( $this.hasClass( 'sub-menu-active' ) ) {

		  		if( ! $this.next().hasClass( 'sub-menu-open' ) ) {

		  			$this.find( 'a' ).attr( 'aria-expanded', 'false' );

		  			if( 'horizontal' !== layout ){

						event.preventDefault();

		  				$this.next().css( 'position', 'relative' );	
					}else if ( 'horizontal' === layout && window.matchMedia( "( max-width: 767px )" ).matches && ($( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-tablet') || $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-mobile'))) {
						
						event.preventDefault();

		  				$this.next().css( 'position', 'relative' );	
					}else if ( 'horizontal' === layout && window.matchMedia( "( max-width: 1024px )" ).matches && ( $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-tablet') || $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-mobile'))) {
						
						event.preventDefault();	

		  				$this.next().css( 'position', 'relative' );	
					}	
	  			
					$this.removeClass( 'sub-menu-active' );
					$this.next().removeClass( 'sub-menu-open' );
					$this.next().css( { 'visibility': 'hidden', 'opacity': '0', 'height': '0' } );
					$this.next().css( { 'transition': 'none'} );										
		  		}else{

		  			$this.find( 'a' ).attr( 'aria-expanded', 'false' );
		  			
		  			$this.removeClass( 'sub-menu-active' );
					$this.next().removeClass( 'sub-menu-open' );
					$this.next().css( { 'visibility': 'hidden', 'opacity': '0', 'height': '0' } );
					$this.next().css( { 'transition': 'none'} );	
						  			  			
					if ( 'horizontal' !== layout ){

						$this.next().css( 'position', 'relative' );
					} else if ( 'horizontal' === layout && window.matchMedia( "( max-width: 767px )" ).matches && ($( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-tablet') || $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-mobile'))) {
						
						$this.next().css( 'position', 'relative' );	
						
					} else if ( 'horizontal' === layout && window.matchMedia( "( max-width: 1024px )" ).matches && ( $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-tablet') || $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-mobile'))) {
						
						$this.next().css( 'position', 'absolute' );				
					}	  								
		  		}		  											
			}else {

					$this.find( 'a' ).attr( 'aria-expanded', 'true' );
					if ( 'horizontal' !== layout ) {
						
						event.preventDefault();
			  			$this.next().css( 'position', 'relative');			
					} else if ( 'horizontal' === layout && window.matchMedia( "( max-width: 767px )" ).matches && ($( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-tablet') || $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-mobile'))) {
						
						event.preventDefault();
	  					$this.next().css( 'position', 'relative');		  					
					} else if ( 'horizontal' === layout && window.matchMedia( "( max-width: 1024px )" ).matches ) {
						event.preventDefault();

	  					if ( $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-tablet') ) {

	  						$this.next().css( 'position', 'relative');	
	  					} else if ( $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-mobile') || $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-none') ) {
	  						
	  						$this.next().css( 'position', 'absolute');	
	  					}
	  				}	
	  					
				$this.addClass( 'sub-menu-active' );
				$this.next().addClass( 'sub-menu-open' );	
				$this.next().css( { 'visibility': 'visible', 'opacity': '1', 'height': 'auto' } );
				$this.next().css( { 'transition': '0.3s ease'} );								
			}
		});

		$( '.elementor-element-' + id + ' .be-menu-toggle' ).off( 'click keyup' ).on( 'click keyup',function( event ) {

			var $this = $( this );

		  	if( $this.parent().parent().hasClass( 'menu-active' ) ) {

	  			event.preventDefault();

				$this.parent().parent().removeClass( 'menu-active' );
				$this.parent().parent().next().css( { 'visibility': 'hidden', 'opacity': '0', 'height': '0' } );

				if ( 'horizontal' !== layout ) {
						
		  			$this.parent().parent().next().css( 'position', 'relative');			
				} else if ( 'horizontal' === layout && window.matchMedia( "( max-width: 767px )" ).matches && ($( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-tablet') || $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-mobile'))) {
										
  					$this.parent().parent().next().css( 'position', 'relative');		  					
				} else if ( 'horizontal' === layout && window.matchMedia( "( max-width: 1024px )" ).matches ) {
					
  					if ( $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-tablet') ) {

  						$this.parent().parent().next().css( 'position', 'relative');	
  					} else if ( $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-mobile') || $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-none') ) {
  						
  						$this.parent().parent().next().css( 'position', 'absolute');	
  					}
  				}
			}else { 

				event.preventDefault();

				$this.parent().parent().addClass( 'menu-active' );

				$this.parent().parent().next().css( { 'visibility': 'visible', 'opacity': '1', 'height': 'auto' } );

				if ( 'horizontal' !== layout ) {
						
		  			$this.parent().parent().next().css( 'position', 'relative');			
				} else if ( 'horizontal' === layout && window.matchMedia( "( max-width: 767px )" ).matches && ($( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-tablet') || $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-mobile'))) {
										
  					$this.parent().parent().next().css( 'position', 'relative');		  					
				} else if ( 'horizontal' === layout && window.matchMedia( "( max-width: 1024px )" ).matches ) {
					
  					if ( $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-tablet') ) {

  						$this.parent().parent().next().css( 'position', 'relative');	
  					} else if ( $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-mobile') || $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-none') ) {
  						
  						$this.parent().parent().next().css( 'position', 'absolute');	
  					}
  				}		
			}
		});
	}

	function _borderClass( id ){

		var last_item = $( '.elementor-element-' + id + ' .be-nav-menu' ).data( 'last-item' );
		var last_item_flyout = $( '.elementor-element-' + id + ' .be-flyout-wrapper' ).data( 'last-item' );
		var layout = $( '.elementor-element-' + id + ' .be-nav-menu' ).data( 'layout' );

		$( '.elementor-element-' + id + ' nav').removeClass('be-dropdown');

		if ( window.matchMedia( "( max-width: 767px )" ).matches ) {

			if( $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-mobile') || $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-tablet')){
				
				$( '.elementor-element-' + id + ' nav').addClass('be-dropdown');
				if( ( 'cta' == last_item || 'cta' == last_item_flyout ) && 'expandible' != layout ){
					$( '.elementor-element-' + id + ' li.menu-item:last-child a.be-menu-item' ).parent().removeClass( 'elementor-button-wrapper' );
					$( '.elementor-element-' + id + ' li.menu-item:last-child a.be-menu-item' ).removeClass( 'elementor-button' );	
				}	
			}else{
				
				$( '.elementor-element-' + id + ' nav').removeClass('be-dropdown');
				if( ( 'cta' == last_item || 'cta' == last_item_flyout ) && 'expandible' != layout ){
					$( '.elementor-element-' + id + ' li.menu-item:last-child a.be-menu-item' ).parent().addClass( 'elementor-button-wrapper' );
					$( '.elementor-element-' + id + ' li.menu-item:last-child a.be-menu-item' ).addClass( 'elementor-button' );	
				}
			}
		}else if ( window.matchMedia( "( max-width: 1024px )" ).matches ) {

			if( $( '.elementor-element-' + id ).hasClass('be-nav-menu__breakpoint-tablet') ) {
				
				$( '.elementor-element-' + id + ' nav').addClass('be-dropdown');
				if( ( 'cta' == last_item || 'cta' == last_item_flyout ) && 'expandible' != layout ){
					$( '.elementor-element-' + id + ' li.menu-item:last-child a.be-menu-item' ).parent().removeClass( 'elementor-button-wrapper' );
					$( '.elementor-element-' + id + ' li.menu-item:last-child a.be-menu-item' ).removeClass( 'elementor-button' );	
				}
			}else{
				
				$( '.elementor-element-' + id + ' nav').removeClass('be-dropdown');
				if( ( 'cta' == last_item || 'cta' == last_item_flyout ) && 'expandible' != layout ){
					$( '.elementor-element-' + id + ' li.menu-item:last-child a.be-menu-item' ).parent().addClass( 'elementor-button-wrapper' );
					$( '.elementor-element-' + id + ' li.menu-item:last-child a.be-menu-item' ).addClass( 'elementor-button' );
				}
			}
		}

		var layout = $( '.elementor-element-' + id + ' .be-nav-menu' ).data( 'layout' );
		if( 'expandible' == layout ){
			if( ( 'cta' == last_item || 'cta' == last_item_flyout ) && 'expandible' != layout ){
				$( '.elementor-element-' + id + ' li.menu-item:last-child a.be-menu-item' ).parent().removeClass( 'elementor-button-wrapper' );
				$( '.elementor-element-' + id + ' li.menu-item:last-child a.be-menu-item' ).removeClass( 'elementor-button' );			
			}			
		}
	}

	function _toggleClick( id ){

		if ( $( '.elementor-element-' + id + ' .be-nav-menu__toggle i' ).parent().parent().hasClass( 'be-active-menu-full-width' ) ){

			$( '.elementor-element-' + id + ' .be-nav-menu__toggle i' ).parent().parent().next().css( 'left', '0' );

			var width = $( '.elementor-element-' + id ).closest('.elementor-section').outerWidth();
			var sec_pos = $( '.elementor-element-' + id ).closest('.elementor-section').offset().left - $( '.elementor-element-' + id + ' .be-nav-menu__toggle i' ).parent().parent().next().offset().left;
			$( '.elementor-element-' + id + ' .be-nav-menu__toggle i' ).parent().parent().next().css( 'width', width + 'px' );
			$( '.elementor-element-' + id + ' .be-nav-menu__toggle i' ).parent().parent().next().css( 'left', sec_pos + 'px' );
		}

		$( '.elementor-element-' + id + ' .be-nav-menu__toggle .be-nav-menu-icon' ).off( 'click keyup' ).on( 'click keyup', function( event ) {

			var $this = $( this ).find( 'i' );

			if ( $this.parent().parent().hasClass( 'be-active-menu' ) ) {

				var layout = $( '.elementor-element-' + id + ' .be-nav-menu' ).data( 'layout' );
				var full_width = $this.parent().parent().next().data( 'full-width' );
				var toggle_icon = $( '.elementor-element-' + id + ' nav' ).data( 'toggle-icon' );

				$( '.elementor-element-' + id).find( '.be-nav-menu-icon i' ).attr( 'class', toggle_icon );

				$this.parent().parent().removeClass( 'be-active-menu' );
				$this.parent().parent().attr( 'aria-expanded', 'false' );
				
				if ( 'yes' == full_width ){

					$this.parent().parent().removeClass( 'be-active-menu-full-width' );
				
					$this.parent().parent().next().css( 'width', 'auto' );
					$this.parent().parent().next().css( 'left', '0' );
					$this.parent().parent().next().css( 'z-index', '0' );
				}				
			} else {

				var layout = $( '.elementor-element-' + id + ' .be-nav-menu' ).data( 'layout' );
				var full_width = $this.parent().parent().next().data( 'full-width' );
				var close_icon = $( '.elementor-element-' + id + ' nav' ).data( 'close-icon' );

				$( '.elementor-element-' + id).find( '.be-nav-menu-icon i' ).attr( 'class', close_icon );
				
				$this.parent().parent().addClass( 'be-active-menu' );
				$this.parent().parent().attr( 'aria-expanded', 'true' );

				if ( 'yes' == full_width ){

					$this.parent().parent().addClass( 'be-active-menu-full-width' );

					var width = $( '.elementor-element-' + id ).closest('.elementor-section').outerWidth();
					var sec_pos = $( '.elementor-element-' + id ).closest('.elementor-section').offset().left - $this.parent().parent().next().offset().left;
				
					$this.parent().parent().next().css( 'width', width + 'px' );
					$this.parent().parent().next().css( 'left', sec_pos + 'px' );
					$this.parent().parent().next().css( 'z-index', '9999' );
				}
			}

			if( $( '.elementor-element-' + id + ' nav' ).hasClass( 'menu-is-active' ) ) {

				$( '.elementor-element-' + id + ' nav' ).removeClass( 'menu-is-active' );
			}else {

				$( '.elementor-element-' + id + ' nav' ).addClass( 'menu-is-active' );
			}				
		} );
	}
    
    var ProductsSliderHandler = function ( $scope, $ ) {
        var $carousel         = $scope.find( ".blank-product-slider .products" ).eq( 0 ),
            $slider_wrap      = $scope.find( '.blank-product-slider .slick-slide' ),
            elementSettings   = getElementSettings( $scope );
        
            $carousel.slick({
                slidesToShow:           1,
                slidesToScroll:         1,
                autoplay:               false,
                arrows:                 true,
                prevArrow:              '<div class="be-slider-arrow be-arrow-prev"><span class="be-slider-icon"></span></div>',
				nextArrow:              '<div class="be-slider-arrow be-arrow-next"><span class="be-slider-icon"></span></div>',
                dots:                   false,
                infinite:               true,
                pauseOnHover:           true,
                adaptiveHeight:         true,
                responsive: [
                     {
                    breakpoint: 1024,
                        settings: {
                            slidesToShow: 1,
							slidesToScroll: 1,
                        }
                    },
                    {
                    breakpoint: 768,
                        settings: {
                            slidesToShow: 1,
							slidesToScroll: 1,
                        }
                    },
                ]
            });

            $carousel.slick( 'setPosition' );

            if ( isEditMode ) {
                $slider_wrap.resize( function() {
                    $carousel.slick( 'setPosition' );
                });
            }
    };
    
    var BlankBreadcrumbsHandler = function( $scope, $ ) {
		var elementSettings			= getElementSettings( $scope ),
            $breadcrumbs_type		= elementSettings.breadcrumbs_type;

		if ( $breadcrumbs_type !== 'ultrablog' ) {
			$scope.find('.be-breadcrumbs a' ).parent().css({'padding' : '0', 'background-color' : 'transparent', 'border' : '0', 'margin' : '0', 'box-shadow' : 'none'});
		}
		if ( $breadcrumbs_type === 'yoast' || $breadcrumbs_type === 'rankmath' ) {
			$scope.find('.be-breadcrumbs a' ).parent().parent().css({'padding' : '0', 'background-color' : 'transparent', 'border' : '0', 'margin' : '0', 'box-shadow' : 'none'});
		}
	}
    
    $(window).on('elementor/frontend/init', function () {
        if ( elementorFrontend.isEditMode() ) {
			isEditMode = true;
		}
        
        elementorFrontend.hooks.addAction('frontend/element_ready/blank-testimonials-carousel.default', TestimonialsCarouselHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/blank-slider.default', SliderHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/blank-instagram-feed.default', InstagramFeedHandler);
        elementorFrontend.hooks.addAction('frontend/element_ready/blank-counter.default', CounterHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/blank-portfolio-slider.default', PostsSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/blank-portfolio-slider.classic', PostsSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/blank-woo-mini-cart.default', WooMiniCartHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/blank-navigation.default', WidgethfeNavMenuHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/blank-product-slider.default', ProductsSliderHandler);
		elementorFrontend.hooks.addAction('frontend/element_ready/blank-breadcrumbs.default', BlankBreadcrumbsHandler);
    });
    
}(jQuery));