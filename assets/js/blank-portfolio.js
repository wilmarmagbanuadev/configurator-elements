( function( $ ) {

	var loadStatus = true;
	var count = 1;
	var loader = '';
	var total = 0;
	
	var PostsHandler = function( $scope, $ ) {
		
		var selector = $scope.find( '.blank-portfolio-grid' ),
			layout = $scope.find( '.blank-portfolio-grid' ).data( 'layout' ),
            $filters = $scope.find( '.blank-portfolio-filters-wrap' ),
            $filter_taxonomy = $filters.data( 'filter-taxonomy' ),
			$filter = '',
		
		loader = $scope.find( '.blank-portfolio-loader' );
		
		$scope.find( '.blank-portfolio-filter' ).off( 'click' ).on( 'click', function() {
            var $filter = $( this ).data('filter');
			$( this ).siblings().removeClass( 'blank-filter-current' );
			$( this ).addClass( 'blank-filter-current' );
			count = 1;
            //console.log($filter);
            
			_postsFilterAjax( $scope, $filter, $filter_taxonomy );
            

		});

		if ( selector.hasClass( 'blank-portfolio-infinite-scroll' ) ) {

			var windowHeight50 = jQuery( window ).outerHeight() / 1.25;

			$( window ).scroll( function () {

				if ( elementorFrontend.isEditMode() ) {
					loader.show();
					return false;
				}

				if ( ( $( window ).scrollTop() + windowHeight50 ) >= ( $scope.find( '.blank-portfolio:last' ).offset().top ) ) {

					var $args = {
						'page_id':		$scope.find( '.blank-portfolio-grid' ).data('page'),
						'widget_id':	$scope.data( 'id' ),
						'filter':		$scope.find( '.blank-filter-current' ).data( 'filter' ),
						'skin':			$scope.find( '.blank-portfolio-grid' ).data( 'skin' ),
						'page_number':	$scope.find( '.blank-portfolio-pagination .current' ).next( 'a' ).html()
					};

					total = $scope.find( '.blank-portfolio-pagination-wrap' ).data( 'total' );

					if( true == loadStatus ) {

						if ( count < total ) {
							loader.show();
							_callAjax( $scope, $args, true );
							count++;
							loadStatus = false;
						}

					}
				}
			} );
		}
	}

	$( document ).on( 'click', '.blank-portfolio-load-more', function( e ) {

		$scope = $( this ).closest( '.elementor-widget-blank-portfolio' );
		loader = $scope.find( '.blank-portfolio-loader' );

		e.preventDefault();

		if( elementorFrontend.isEditMode() ) {
			loader.show();
			return false;
		}

		var $args = {
			'page_id':		$scope.find( '.blank-portfolio-grid' ).data('page'),
			'widget_id':	$scope.data( 'id' ),
			'filter':		$scope.find( '.blank-filter-current' ).data( 'filter' ),
			'skin':			$scope.find( '.blank-portfolio-grid' ).data( 'skin' ),
			'page_number':	( count + 1 )
		};

		total = $scope.find( '.blank-portfolio-pagination-wrap' ).data( 'total' );

		if( true == loadStatus ) {

			if ( count < total ) {
				loader.show();
				$( this ).hide();
				_callAjax( $scope, $args, true );
				count++;
				loadStatus = false;
			}

		}
	} );

	$( 'body' ).delegate( '.blank-portfolio-pagination .page-numbers', 'click', function( e ) {

		$scope = $( this ).closest( '.elementor-widget-blank-portfolio' );

		e.preventDefault();

		$scope.find( '.blank-portfolio-grid .blank-portfolio' ).last().after( '<div class="blank-portfolio-loader"><div class="blank-loader"></div><div class="blank-loader-overlay"></div></div>' );

		var page_number = 1;
		var curr = parseInt( $scope.find( '.blank-portfolio-pagination .page-numbers.current' ).html() );

		if ( $( this ).hasClass( 'next' ) ) {
			page_number = curr + 1;
		} else if ( $( this ).hasClass( 'prev' ) ) {
			page_number = curr - 1;
		} else {
			page_number = $( this ).html();
		}

		$scope.find( '.blank-portfolio-grid .blank-portfolio' ).last().after( '<div class="blank-portfolio-loader"><div class="blank-loader"></div><div class="blank-loader-overlay"></div></div>' );

		var $args = {
			'page_id':		$scope.find( '.blank-portfolio-grid' ).data('page'),
			'widget_id':	$scope.data( 'id' ),
			'filter':		$scope.find( '.blank-filter__current' ).data( 'filter' ),
			'skin':			$scope.find( '.blank-portfolio-grid' ).data( 'skin' ),
			'page_number':	page_number
		};

		$('html, body').animate({
			scrollTop: ( ( $scope.find( '.blank-portfolio-container' ).offset().top ) - 30 )
		}, 'slow');

		_callAjax( $scope, $args );

	} );

	var _postsFilterAjax = function( $scope, $filter, $filter_taxonomy ) {

		$scope.find( '.blank-portfolio-grid .blank-grid-item-wrap' ).last().after( '<div class="blank-portfolio-loader-wrap"><div class="blank-loader"></div><div class="blank-loader-overlay"></div></div>' );

		var $args = {
			'page_id':		$scope.find( '.blank-portfolio-grid' ).data('page'),
			'widget_id':	$scope.data( 'id' ),
            'filter_taxonomy':	$filter_taxonomy,
			'filter':		$filter,
			//'filter':		$this.data( 'filter' ),
			'page_number':	1
		};

		_callAjax( $scope, $args );
	}

	var _callAjax = function( $scope, $obj, $append ) {

        var loader = $scope.find( '.blank-portfolio-loader' );
        
		$.ajax({
			url: BlankElementsFrontendConfig.ajaxurl,
			data: {
				action:			'blank_get_portfolio',
				page_id:		$obj.page_id,
				widget_id:		$obj.widget_id,
				filter_taxonomy:$obj.filter_taxonomy,
				filter:		    $obj.filter,
				page_number:	$obj.page_number
			},
			dataType: 'json',
			type: 'POST',
			success: function( data ) {

				//$scope.find( '.blank-portfolio-loader' ).remove();

				var sel = $scope.find( '.blank-portfolio-grid' );
				
				//console.log(data.data.html);

				if ( true == $append ) {

					var html_str = data.data.html;
					//html_str = html_str.replace( 'blank-portfolio-wrapper-featured', '' );
					sel.append( html_str );
				} else {
					sel.html( data.data.html );
				}

				$scope.find( '.blank-portfolio-pagination-wrap' ).html( data.data.pagination );

				var layout = $scope.find( '.blank-portfolio-grid' ).data( 'layout' ),
					selector = $scope.find( '.blank-portfolio-grid' );

				if ( 'masonry' == layout ) {

					$scope.imagesLoaded( function() {
						selector.isotope( 'destroy' );
						selector.isotope({
							layoutMode: layout,
							itemSelector: '.blank-grid-item-wrap',
						});
					});
				}

				//	Complete the process 'loadStatus'
				loadStatus = true;
				if ( true == $append ) {
					loader.hide();
					$scope.find( '.blank-portfolio-load-more' ).show();
				}

				if( count == total ) {
					$scope.find( '.blank-portfolio-load-more' ).hide();
				}
			}
		});
	}

	$( window ).on( 'elementor/frontend/init', function () {

		elementorFrontend.hooks.addAction( 'frontend/element_ready/blank-portfolio.default', PostsHandler );

	});

} )( jQuery );
